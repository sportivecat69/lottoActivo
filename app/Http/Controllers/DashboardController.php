<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SellerAgency;
use App\Agency;
use App\AgencyCategoriesSell;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }
    
    /**
     * Display the specified resource agency por specified user seller
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function indexSeller()
    {
    	// obtener datod del usuario autenticado
    	
    	if(Auth::user()->hasRole('seller')){
    		
    		$seller=SellerAgency::where('users_id',Auth::user()->id)->first();
    		$agency=Agency::where('id', $seller->agencies_id)->first();
    		$acs = AgencyCategoriesSell::where('agencies_id',$agency->id)->get();
    		
    		//dd($seller);die();
//     		$agency = Agency::find($id);
//     		$acs = AgencyCategoriesSell::where('agencies_id',$id)->get();
//     		$sellers=SellerAgency::where('agencies_id', $id)->get();
//     		return view('warehouses.agencies.show', ['agency' => $agency, 'acs'=>$acs, 'sellers'=>$sellers]);
    		return view('dashboard.index-seller',['seller' => $seller, 'agency' => $agency, 'acs'=>$acs]);
    		
    	}else{
    		
    		return redirect()->route('dashboard')->with('fail', 'Usted no puede obtener la petici&oacute;n realizada');
    		
    	}
    }
}
