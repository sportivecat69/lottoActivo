<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agency;
use App\Categorie;
use Illuminate\Support\Facades\Validator;
use App\AgencyCategoriesSell;

class AgencyController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$agencies = Agency::paginate(10);
    	return view('warehouses.agencies.index', ['agencies' => $agencies]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = Categorie::all();
    	return view('warehouses.agencies.create', ['categories' => $categories]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$agency = new Agency();
    	$agency_cs= new AgencyCategoriesSell();

    	$validator = Validator::make($request->all(), $agency->rules);
    
    	if ($validator->fails()) {
    		return redirect()->route('agency.create')
    		->withErrors($validator)
    		->withInput();
    	} else {
    		 
    		//Almaceno la agencia
    		$val=$agency->insert($request);
    		
    		if(($val)){
    			return redirect()->route('agency.index')->with('status', 'Se creo la agencia satisfactoriamente');
    		}else{
    			return redirect()->route('agency.index')->with('fail', 'Hubo un error intente de nuevo');
    		}
    		 
    		
    	}
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$agency = Agency::find($id);
    	return view('warehouses.agencies.edit', ['agency' => $agency]);
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$agency = new Agency();
    	$validator = Validator::make($request->all(), $agency->rules);
    	 
    	if ($validator->fails()) {
    		return redirect()->route('agency.edit', $id)
    		->withErrors($validator)
    		->withInput();
    	} else {
    
    		//Edito
    		$val=$agency->edit($request, $id);
    		
    		if(($val)){
    			return redirect()->route('agency.index')->with('status', 'Se creo la agencia satisfactoriamente');
    		}else{
    			return redirect()->route('agency.index')->with('fail', 'Hubo un error intente de nuevo');
    		}
    	}
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$agency = Agency::find($id);
    	return view('warehouses.agencies.show', ['agency' => $agency]);
    }
    
}
