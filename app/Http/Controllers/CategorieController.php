<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$categories = Categorie::paginate(10);
    	return view('warehouses.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('warehouses.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    			'name' => 'required|max:255',
    			'description' => 'required|max:255',
    	]);
    	 
    	if ($validator->fails()) {
    		return redirect()->route('categorie.create')
    		->withErrors($validator)
    		->withInput();
    	} else {
    	
    		//Almaceno el equipo
    		$categorie = new Categorie();
    		$categorie->name = $request->name;
    		$categorie->description = $request->description;
    		$categorie->save();
    	
    		return redirect()->route('categorie.index')->with('status', 'Se creo la categoria con exito');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$categorie = Categorie::find($id);
    	return view('warehouses.categories.edit', ['categorie' => $categorie]);
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
    	$validator = Validator::make($request->all(), [
    			'name' => 'required|max:255',
    			'description' => 'required|max:255',
    	]);
    	
    	if ($validator->fails()) {
    		return redirect()->route('categorie.edit')
    		->withErrors($validator)
    		->withInput();
    	} else {
    		 
    		//Almaceno el equipo
    		$equipo = Categorie::find($id);
    		$equipo->name = $request->name;
    		$equipo->description = $request->description;
    		$equipo->save();
    		 
    		return redirect()->route('categorie.index')->with('status', 'Se edito la categoria con exito');
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$categorie =  Categorie::find($id);
    	 
    	$categorie->delete();
    	
    	return redirect()->route('categorie.index')->with('status', 'Se elimino la categoria con exito');
    }
}
