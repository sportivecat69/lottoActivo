<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$clients = Client::paginate(10);
		return view('sales.client.index', ['clients' => $clients]);
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('sales.client.create');
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
				'doc' => 'required|max:255|unique:clients',
				'nombre' => 'required|max:255',
				'direccion' => 'required|max:255',
				'telefono' => 'required|max:255',
				'correo' => 'required|max:255',
				'estado' => 'required|max:255',
		]);
		 
		if ($validator->fails()) {
			return redirect()->route('client.create')
			->withErrors($validator)
			->withInput();
		} else {
			 
			//Almaceno el equipo
			$article = new Client();
			$article->doc = $request->doc;
			$article->name = $request->nombre;
			$article->address = $request->direccion;
			$article->phone = $request->telefono;
			$article->email = $request->correo;
			$article->status = $request->estado;
			$article->observation = $request->observacion;
			$article->save();
			 
			return redirect()->route('client.index')->with('status', 'Se creo el cliente con exito');
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
		$client = Client::find($id);
		return view('sales.client.edit', ['client' => $client]);
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
				'nombre' => 'required|max:255',
				'direccion' => 'required|max:255',
				'telefono' => 'required|max:255',
				'correo' => 'required|max:255',
				'estado' => 'required|max:255',
		]);
	
		if ($validator->fails()) {
			return redirect()->route('client.edit')
			->withErrors($validator)
			->withInput();
		} else {
			 
			//Almaceno el equipo
			$article = Client::find($id);
			$article->name = $request->nombre;
			$article->address = $request->direccion;
			$article->phone = $request->telefono;
			$article->email = $request->correo;
			$article->status = $request->estado;
			$article->observation = $request->observacion;
			$article->save();
			 
			return redirect()->route('client.index')->with('status', 'Se edito el cliente con exito');
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
		$client =  Client::find($id);
		 
		$client->delete();
	
		return redirect()->route('client.index')->with('status', 'Se elimino el cliente con exito');
	}
}
