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
use App\SellerAgency;
use App\AgencyCategoriesSell;

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
	public function index($category)
	{
		$sale_cart = session()->get('sale_cart');
		$total = $this->total();
		
		$sorteos = Draw::where('categorie_id', $category)->orderBy('id', 'asc')->get();
		
		$seller_agency = SellerAgency::where('users_id', Auth::user()->id)->first();
		
		return view('sales.index', ['sale_cart' => $sale_cart, 'total' => $total, 'sorteos' => $sorteos, 'mint_sell' => $seller_agency->agency->mint_sell, 'category' => $category ]);
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
	            
	            //Calculo lavenat por hora del articulo
	            $sales = Sale::where('articles_id', $article->id)->get();
	            
	            $rest = 0;
	            foreach ($sales as $sale){
	                if (date('Y-m-d', strtotime($sale->created_at)) === date('Y-m-d')){
	                    $rest += $sale->bet + $rest;
	                }
	            }
	            
	            $rest_article = $article->sale_price - $rest;
	            
	            return $rest_article;die;
	            
	            //     // 	                if (convertAmount($request->amount) <= '200') {
	            
    	            $rowCount = count($request->sorteo);
    	            for($i=0; $i < $rowCount; $i++){
    	                //Consulto la hora de sorteo
    	                $draw = Draw::find($request->sorteo[$i]);
    	                //Consulto el minuto configurado para cancelar venta
    	                $seller_agency = SellerAgency::where('users_id', Auth::user()->id)->first();
    	                //Le resto los minutos configurado de la agencia al sorteo seleccionado
    	                $horaVenta = strtotime ( '-'.$seller_agency->agency->mint_sell.' minute' , strtotime ( date( 'H:i', strtotime($draw->time)) ) ) ;
    	                //Valido si la hora del sorteo ya paso
    	                if (date('H:i') < date('H:i', $horaVenta)) {
    	                    
    //     						// quizas pueda resumirse pero lo cierto es que la variable
    //     	                    // product no te sirve como objeto a salvar
        						$producto=new Article();
        						foreach ($product->getAttributes() as $key=>$value){
        							$producto->setAttribute($key, $value);
        						}
        						
        
            	                $sale_cart = session()->get('sale_cart');
            	                $producto->categorie = $article->categorie->name;
            	                $producto->sorteo = $request->sorteo[$i];
            	                $producto->amount = convertAmount($request->amount);
            	                $sale_cart[$producto->cod.substr($request->sorteo[$i],0,2)] = $producto;
            	                session()->put('sale_cart', $sale_cart);
        
    	                } else {
    	                   return 'error';
    	                }
    	            }
	               return $article->name;
	               
	               //     // 	                } else {
	               //     // 	                    return 1;//Se ha excedido el limite de venta
	               //     // 	                }
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
	    //Consulto el nombre de la agencia mediante el usuario
	    $seller_agency = SellerAgency::where('users_id', Auth::user()->id)->first();
	    
	    $printer->text($seller_agency->agency->name . "\n");
	    #La fecha también
	    $printer->text("Fecha: ".date("d/m/Y") ." Hora: ".date("h:i:s") . "\n");
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
	    //Ordeno array ascenente
	    sort($sorteos_unido);
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
	                $printer->text($article->cod .' - '. $article->name ." x ". number_format($sc->amount,0,",",".") ." - " . ($article->categorie->name) . "\n");
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
	public function trash($category)
	{
	    session()->forget('sale_cart');
	
	    return redirect()->route('sale.index', $category);
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
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function anular(Request $request, $category)
	{
	    //Consulto el id de la agencia mediante el usuario
	    $seller_agency = SellerAgency::where('users_id', Auth::user()->id)->first();
	    
	    //Consulto el ticket
	    $saleInvoice = SaleInvoice::find($request->ticket);
	    
	    //Valido i el ticket existe
	    if ($saleInvoice) {
	        //verifico si el ticket pertenece a la agencia correcta
	        if ($seller_agency->agency->id != $saleInvoice->sellerAgency->agency->id) {
	            
	            return redirect()->route('sale.index', $category)->with('error', 'El ticket Nro. '.$request->ticket.' no pertenece a esta agencia');
	            
	        } else {
	            
	            //Le resto los minutos configurado de la agencia a la hora actual
	            $horaAnulacion = strtotime ( '-'.$seller_agency->agency->mint_cancel.' minute' , strtotime ( date( 'H:i') ) ) ;
	            //Valido si esta en la hora para anular
	            if (date('Y-m-d', strtotime($saleInvoice->created_at)) == date('Y-m-d') && date('H:i:s', strtotime($saleInvoice->created_at)) > date('H:i:s', $horaAnulacion)) {
	                
	                //Edito el esttus de los producto del ticket y el ticket
	                $sale_Invoice = SaleInvoice::where('id', $request->ticket)->update(['status' => 'ANULADO']);
	                
	                $sale = Sale::where('sale_invoice_id', $request->ticket)->update(['status' => 'ANULADO']);
	                
	                if ($sale_Invoice && $sale) {
	                    return redirect()->route('sale.index', $category)->with('success', 'El ticket Nro. '.$request->ticket.' fue anulado con exito');
	                } else {
	                    return redirect()->route('sale.index', $category)->with('error', 'Error al anular ticket Nro. '.$request->ticket.' intente de nuevo');
	                }
	            } else {
	                return redirect()->route('sale.index', $category)->with('error', 'A superado el tiempo para anular ticket');
	            }
	            
	        }
	    } else {
	        return redirect()->route('sale.index', $category)->with('error', 'El ticket Nro. '.$request->ticket.' no existe');
	    }
	}

	/**
	 * Pagar a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function pagar(Request $request, $category)
	{
	    //Consulto el id de la agencia mediante el usuario
	    $seller_agency = SellerAgency::where('users_id', Auth::user()->id)->first();
	    
	    //Consulto agency_categories_sell para ver cuanto es el precio 
	    //minima de venta y por cuanto se paga 
	    $agencyCategoriesSell = AgencyCategoriesSell::where([
	                                                          ['agencies_id', $seller_agency->agency->id],
	                                                          ['categorie_id', 1]
	                                                        ])->first();
    	    
	    //Consulto el ticket
	    $saleInvoice = SaleInvoice::find($request->ticket);
	    
	    //Valido i el ticket existe
	    if ($saleInvoice) {
	        //verifico si el ticket pertenece a la agencia correcta
	        if ($seller_agency->agency->id != $saleInvoice->sellerAgency->agency->id) {
	            
	            return redirect()->route('sale.index', $category)->with('error', 'El ticket Nro. '.$request->ticket.' no existe');
	            
	        } else {
	            
	            if ($saleInvoice->status != 'ANULADO') {
	                
	                //Le resto los minutos configurado de la agencia a la hora actual
	                $fechaVencimiento = strtotime ( '+3 day' , strtotime( date('Y-m-d', strtotime($saleInvoice->created_at))) );
	                
	                //Valido si esta en la fecha para pagar
	                if (date('Y-m-d') <= date('Y-m-d', $fechaVencimiento)) {
	                    
	                    //Verifico si el ticket tiene premio
	                    $sale_detalles = Sale::where([
                            	                        ['sale_invoice_id', $request->ticket],
                            	                        ['status', 'PREMIADO']
                            	                    ])->get();
	                    
                        if (count($sale_detalles) > 0) {
	                        
                            $monto_jugada = 0;
                            
                            //verifico y sumo el monto de juagdas de los premiados
                            foreach ($sale_detalles as $sale_detalle){
                                $monto_jugada += $sale_detalle->bet;
                            }
                            
                            //Calculo para el pago de ticket
                            $premio = ($monto_jugada * $agencyCategoriesSell->prize_min)/$agencyCategoriesSell->bet_min;
                            
                            //Edito el esttus de los producto del ticket
                            $sale = Sale::where([
                                                    ['sale_invoice_id', $request->ticket],
                                                    ['status', 'PREMIADO']
                                                ])->update(['status' => 'PAGADO']);
                            
                                                return redirect()->route('sale.index', $category)->with('success', 'El ticket fue pagado con exito, Total: '.number_format($premio,2,",","."));
	                    } else {
	                        return redirect()->route('sale.index', $category)->with('error', 'El ticket Nro. '.$request->ticket.' no esta premiado');
	                    }
	                    
	                } else {
	                    return redirect()->route('sale.index', $category)->with('error', 'El ticket ha caducado');
	                }
	                
	            } else {
	                
	                return redirect()->route('sale.index', $category)->with('error', 'El ticket esta anulado');
	                
	            }

	        }
	    } else {
	        return redirect()->route('sale.index', $category)->with('error', 'El ticket Nro. '.$request->ticket.' no existe');
	    }
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
