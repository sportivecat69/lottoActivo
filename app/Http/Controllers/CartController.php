<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Article;

class CartController extends Controller
{
	public function __construct()
	{
		if (!Session::has('cart')) Session::put('cart', array());
	}
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Article $product)
    {
    	$cart = Session::get('cart');
    	$product->quantity = 1;
		$cart[$product->cod] = $product;
		Session::put('cart', $cart);
		
		return redirect()->route('cart.show');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $cart = Session::get('cart');
        //redireccionar a la vista
        return $cart;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Article $product)
    {
    	$cart = Session::get('cart');
    	unset($cart[$product->cod]);
    	Session::put('cart', $cart);
    	
    	return redirect()->route('cart.show');
    }
}
