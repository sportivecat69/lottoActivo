<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Categorie;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$articles = Article::paginate(10);
    	return view('warehouses.articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = Categorie::all();
    	return view('warehouses.articles.create', ['categories' => $categories]);
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
    			'cod' => 'required|max:255|unique:articles',
    			'categoria' => 'required|max:255',
    			'nombre' => 'required|max:255',
    			'precio_venta' => 'required|max:255',
    			'estado' => 'required|max:255',
    	]);
    	 
    	if ($validator->fails()) {
    		return redirect()->route('article.create')
    		->withErrors($validator)
    		->withInput();
    	} else {
    	
    		//Almaceno el equipo
    		$article = new Article();
    		$article->cod = $request->cod;
    		$article->categorie_id = $request->categoria;
    		$article->name = $request->nombre;
    		$article->sale_price = convertAmount($request->precio_venta);
    		$article->status = $request->estado;
    		$article->save();
    	
    		return redirect()->route('article.index')->with('status', 'Se creo el articulo con exito');
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
    	$categories = Categorie::all();
    	$article = Article::find($id);
    	return view('warehouses.articles.edit', ['article' => $article, 'categories' => $categories]);
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
    			'precio_venta' => 'required|max:255',
    			'estado' => 'required|max:255',
    	]);
    	
    	if ($validator->fails()) {
    		return redirect()->route('article.edit', $id)
    		->withErrors($validator)
    		->withInput();
    	} else {
    		
    		$article = Article::find($id);
    		$article->sale_price = convertAmount($request->precio_venta);
    		$article->status = $request->estado;
    		$article->save();
    		 
    		return redirect()->route('article.index')->with('status', 'Se edito el articulo con exito');
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
    	$article =  Article::find($id);
    	 
    	$article->delete();
    	
    	return redirect()->route('article.index')->with('status', 'Se elimino el articulo con exito');
    }
}
