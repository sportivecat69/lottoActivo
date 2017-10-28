<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Article;
use App\SaleInvoice;
use App\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use App\Draw;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class SaleController extends Controller
{
	public function __construct()
	{
	    if (!session()->has('sale_cart')) session()->put('sale_cart', array());
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$sale_cart = session()->get('sale_cart');
		$total = $this->total();
		
		$sorteos = Draw::where('categorie_id', 1)->orderBy('id', 'asc')->get();
		
		return view('sales.index', ['sale_cart' => $sale_cart, 'total' => $total, 'sorteos' => $sorteos ]);
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function add(Request $request, Article $product)
	{
		
	    $article = Article::where([
	        ['cod', $request->cod],
	        ['categorie_id', $request->categorie]
	    ])->first();
	    
	    /**
	     * Hacer resta de total de venta por articulo menos el limite de venta
	     * Ej: $rest = $limite - $venta; //200 
	     */
	    
	    if (!$article) {
	        return 'not registro';
	    } else {

	        if($article->status != 0){
	            $rowCount = count($request->sorteo);
	            for($i=0; $i < $rowCount; $i++){
	                
// 	                if (convertAmount($request->amount) <= '200') {
						// quizas pueda resumirse pero lo cierto es que la variable
	                    // product no te sirve como objeto a salvar
						$producto=new Article();
						foreach ($product->getAttributes() as $key=>$value){
							$producto->setAttribute($key, $value);
						}
						

    	                $sale_cart = session()->get('sale_cart');
    	                $producto->sorteo = $request->sorteo[$i];
    	                $producto->amount = convertAmount($request->amount);
    	                $sale_cart[$producto->cod.substr($request->sorteo[$i],0,2)] = $producto;
    	                session()->put('sale_cart', $sale_cart);
// 	                } else {
// 	                    return 1;//Se ha excedido el limite de venta
// 	                }
	                
	            }
	            return $article->name;
	        } else {
	            return 0;//El n&uacute;mero esta inhabilitado
	        }

	    }
	}
	
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$sale_cart = session()->get('sale_cart');
		unset($sale_cart[$id]);
		session()->put('sale_cart', $sale_cart);
	
		return 1;
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function trash()
	{
	    session()->forget('sale_cart');
	
		return redirect()->route('sale.index');
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function total()
	{
		$sale_cart = session()->get('sale_cart');
		$total= 0;
		foreach ($sale_cart as $c) {
			$total += $c->amount;
		}
		 
		return $total;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function process(Request $request)
	{
		$sale_invoice = new SaleInvoice();
		$sale_invoice->sellers_agency_id = 1;
		$sale_invoice->total = $this->total();
		$sale_invoice->save();
		 
		$sale_cart = session()->get('sale_cart');
		foreach ($sale_cart as $sc) {
			//agrego en la tabla sale la descripcion de ventas
			$sale = new Sale();
			$sale->sale_invoice_id = $sale_invoice->id;
			$sale->draws_id = $sc->sorteo;
			$sale->articles_id = $sc->id;
			$sale->bet = $sc->amount;
			$sale->save();
		}
		
		$this->print($sale_invoice->id);
		
		//Elimino los datos del carrito
		session()->forget('sale_cart');
		
		return 1;
		 
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function print($factura_id)
	{
        
	    $sale_cart = session()->get('sale_cart');
	    
	    /*
	     Aquí, en lugar de "POS-58" (que es el nombre de mi impresora)
	     escribe el nombre de la tuya. Recuerda que debes compartirla
	     desde el panel de control
	     */
	    
	    $nombre_impresora = "POS-58-Series";
	    
	    
	    $connector = new WindowsPrintConnector($nombre_impresora);
	    $printer = new Printer($connector);
	    
	    # Vamos a alinear al centro lo próximo que imprimamos
	    $printer->setJustification(Printer::JUSTIFY_LEFT);
	    
	    /*
	     Ahora vamos a imprimir un encabezado
	     */
	    
	    $printer->text("Agencia Mi SUerte II" . "\n");
	    #La fecha también
	    $printer->text("Fecha: ".date("d/m/Y") ." Hora: ".date("H:i:s") . "\n");
	    $printer->text("Ticket: " . $factura_id . "\n");
	    
	    
	    /*
	     Ahora vamos a imprimir los
	     productos
	     */
	    
	    //************UNION DE SORTEOS***************
	    $sorteos_unido = array();
	    foreach($sale_cart as $val => $key) {
	        if (!in_array($key->sorteo, $sorteos_unido)) {
	            $sorteos_unido[] = $key->sorteo;
	        }
	    }
	    //************END UNION DE SORTEOS***************

	    //CREACION DE LA DESCRIPCION DEL TICKET
	    foreach ($sorteos_unido as $sorteo) {
	        $s = Draw::find($sorteo);
	        $printer->text("---- Sorteo " . $s->time . " ----\n");
	        
	        foreach ($sale_cart as $sc) {
	            $sorte = Draw::find($sc->sorteo);
	            if(date('H', strtotime($s->time)) == date('H', strtotime($sorte->time))){
	                $article = Article::find($sc->id);
	                
	                /*Alinear a la izquierda para la cantidad y el nombre*/
	                $printer->setJustification(Printer::JUSTIFY_LEFT);
	                $printer->text($article->name . " x " . $sc->amount . "\n");
	            }
	        }
	    }
	    //END CREACION DE LA DESCRIPCION DEL TICKET

	    /*
	     Terminamos de imprimir
	     los productos, ahora va el total
	     */
	    $printer->text("-------------------------\n");
	    $printer->text("TOTAL Bsf: ". number_format($this->total(),0,",",".") . " Items:". count($sale_cart) ."\n");
	    $printer->text("-------------------------\n");
	    
	    /*
	     Podemos poner también un pie de página
	     */
// 	    $printer->text("\n");
	    $printer->text("Despues del sorteo \n");
	    $printer->text("No hay reclamos \n");
	    $printer->text("Gracias y Suerte");
	    
	    /*Alimentamos el papel 3 veces*/
	    $printer->feed(3);
	    
	    /*
	     Cortamos el papel. Si nuestra impresora
	     no tiene soporte para ello, no generará
	     ningún error
	     */
	    $printer->cut();
	    
	    /*
	     Por medio de la impresora mandamos un pulso.
	     Esto es útil cuando la tenemos conectada
	     por ejemplo a un cajón
	     */
	    $printer->pulse();
	    
	    /*
	     Para imprimir realmente, tenemos que "cerrar"
	     la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
	     */
	    $printer->close();
	    
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function report()
	{
	    $reports = SaleInvoice::paginate(10);
	    return view('sales.reports.index', ['reports' => $reports]);
	}
}
