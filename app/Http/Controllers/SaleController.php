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
		return view('sales.index', ['sale_cart' => $sale_cart, 'total' => $total]);
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
						// quizas pueda resumirse pero lo cierto es que la variable product no te sirve como objeto a salvar
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
// 	            print_r(json_encode($sale_cart).'-----');
	            
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
// 		if ($request->client_id != 0) {
// 			$client = Client::find($request->client_id);
			
// 			$sale_invoice = new SaleInvoice();
// 			$sale_invoice->employee = Auth::user()->firstname.' '.Auth::user()->lastname;
// 			$sale_invoice->client = $client->name;
// 			$sale_invoice->doc = $client->doc;
// 			$sale_invoice->phone = $client->phone;
// 			$sale_invoice->address = $client->address;
// 			$sale_invoice->amount_received = convertAmount($request->amount_received);
// 			$sale_invoice->save();
// 		} else {
// 			$sale_invoice = new SaleInvoice();
// 			$sale_invoice->employee = Auth::user()->firstname.' '.Auth::user()->lastname;
// 			$sale_invoice->client = 'Publico General';
// 			$sale_invoice->doc = '---';
// 			$sale_invoice->phone = '---';
// 			$sale_invoice->address = '---';
// 			$sale_invoice->amount_received = convertAmount($request->amount_received);
// 			$sale_invoice->save();
// 		}
		 
// 		//obtengo el ultimo id para agregarlo a la relacion de la venta
// 		$sale_invoice_id = SaleInvoice::all();
		 
// 		$sale_cart = session()->get('sale_cart');
// 		foreach ($sale_cart as $sc) {
// 			//agrego en la tabla de descripcion de ventas
// 			$sale = new Sale();
// 			$sale->cod = $sc->cod;
// 			$sale->product = $sc->name;
// 			$sale->quantity = $sc->quantity;
// 			$sale->price = convertAmount($sc->sale_price);
// 			$sale->sale_invoice_id = $sale_invoice_id->last()->id;
// 			$sale->save();
	
// 			$article = Article::where('cod', $sc->cod)->first();
// 			//edito en el stok
// 			Article::where('cod', $sc->cod)->update(['stok' => $article->stok - $sc->quantity]);
	
// 		}
		 
// 		//Elimino los datos del carrito
// 		session()->forget('sale_cart');
		 
// 		return redirect()->route('sale.invoice', $sale_invoice_id->last()->id);
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
