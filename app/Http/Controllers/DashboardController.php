<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//     	if(Auth::user()->hasRole('banker')){
//     		return view('dashboard');
//     	}elseif(Auth::user()->hasRole('seller')){
//     		return view('dashboard', ['message'=>'hola']);
//     	}
    	 
    	//return view('warehouses.agencies.edit', ['agency' => $agency, 'categories' => $categories, 'acs'=>$acs]);
        return view('dashboard');
    }
}
