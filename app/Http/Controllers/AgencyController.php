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
    	
    	$categories=$request->categorie;
    	$data= $request->except(['categorie','_token','_method']);
    	
    	
    	//debe existir al menos una categoría a seleccionar
    	if($categories===null){
    		return redirect()->route('agency.create')
    		->with('fail', '501, Contacte al Administrador del Sistema')
    		->withInput();
    	}
    	
    	$array=array();

    	foreach ($categories as $k=>$categorie){
   			if (array_key_exists('on', $categorie)){ // fue seleccionado
    			$acs=new AgencyCategoriesSell();
    			$acs->categorie_id = $k;
    			$acs->bet_min = convertAmount($categorie['bet_min']);
    			$acs->prize_min = convertAmount($categorie['prize_min']);
    			$array[]=$acs;
   			}
    		
    	}

    	// debe haber seleccionado al menos una categoría a vender
    	
    	if(empty($array)){
    		return redirect()->route('agency.create')
    		->with('fail', 'Debe seleccionar al menos una loter&iacute;a a vender')
    		->withInput();
    	}
    	
    	
    	$menssages=array();
    	foreach ($array as $loteria){
    		$valida = Validator::make($loteria->getAttributes(), $agency_cs->rules);
			if ($valida->fails()) {
		   		
			   $errors=$valida->messages();
			   
			   foreach ($loteria->getAttributes() as $att => $valor){
			   		
			   		$e=$errors->get($att);
			   		if(!empty($e)){
			   			$menssages[$att."-".$loteria->categorie_id]=$e;
			   		}
			   }
			  
			}
    	}
    
    	$data['percentage_gain']=convertAmount($data['percentage_gain']);
   	
    	$validator = Validator::make($data, $agency->rules);
    	
    
    	if (($validator->fails()) or (count($menssages)>0)) {

	    	foreach ($menssages as $k=>$menssage){ 	
	    		$validator->errors()->add($k,$menssage[0]);
	    	}
    		
    		return redirect()->route('agency.create')
    		->withErrors($validator)
    		->withInput();
    	} else {
    		 
    		//Almaceno la agencia
    		$val=$agency->insert($data);
    		
    		if(is_int($val)){
    			
    			foreach ($array as $loteria){
    				$loteria->agencies_id=$val;
    				$loteria->save();
    			}
    			
    			return redirect()->route('agency.index')->with('succes', 'Se creo la agencia satisfactoriamente');
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
    	$categories = Categorie::all();
    	$acs = AgencyCategoriesSell::where('agencies_id',$id)->get();
    	
    	return view('warehouses.agencies.edit', ['agency' => $agency, 'categories' => $categories, 'acs'=>$acs]);
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
    		
    		if(is_int($val)){
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
    	$acs = AgencyCategoriesSell::where('agencies_id',$id)->get();
    	return view('warehouses.agencies.show', ['agency' => $agency, 'acs'=>$acs]);
    }
    
}
