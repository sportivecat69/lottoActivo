<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Security\Role;

use App\Security\Permission;

use App\Security\PermisosRole;

use Validator, Input, Redirect, Session;

use App\Helpers\Functions;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	// get all the Roles
    	$Roles = Role::all();
    	
    	// load the view and pass the Roles
    	return \View::make('roles.index')
    	->with('Roles', $Roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	// load the create form (app/views/Roles/create.blade.php)
    	return \View::make('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// validate
    	// read more on validation at http://laravel.com/docs/validation
    	$validator = Role::validation(\Input::all());
    	
    	// process the login
    	if ($validator->fails()) {
    		return Redirect::to('roles/create')
    		->withErrors($validator);
    	} else {
    		// store
    		$Role = new Role;
    		$Role->name       = Input::get('name');
    		$Role->display_name      = Input::get('display_name');
    		$Role->description      = Input::get('description');

    		$Role->save();
    	
    		// redirect
    		Session::flash('message', 'Successfully created Role!');
    		return Redirect::to('roles');
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
    	// get the Role
    	$Role = Role::find($id);
    	
    	// show the view and pass the Role to it
//     	return \View::make('roles.show')
//     	->with('Role', $Role);
    	
    	
    	/*************Listar Permisos*****/
    	
    	
    	$patch_controller=app_path().'\Http\Controllers';
    	//print_r($patch_controller);exit();
    	$directorio=scandir($patch_controller);
    	$array=array();
    	$array_permisos_rol=PermisosRole::obtenerNamePermisosRol($Role->name);
    	//Class 'App\Permission' not found
    	//https://github.com/Zizaco/entrust/issues/498
    	$array_controladores_permisos=Permission::validarPermisosEnControladores($array_permisos_rol);
    	
    	foreach ($directorio as $archivo){
    		// archivos a ignorar
    		if(($archivo=='.') || ($archivo=='..') || ($archivo=='Auth') || ($archivo=='.gitkeep') || ($archivo=='BaseController.php') || ($archivo=='LoginController.php') || ($archivo=='RemindersController.php')){continue;}
    			
    		$nombre_controladorO=str_replace('Controller.php', '', $archivo);
    			
    		$direccion=str_replace(' ', '', ($patch_controller.'/ '.$archivo));
    		$lineas = file($direccion);
    	
    		// Recorre nuestro array, muestra el código fuente HTML como tal y muestra tambien los números de linea.
    		foreach ($lineas as $num_linea => $linea) {
    				
    			$f=Functions::buscar_Texto('public function', htmlspecialchars($linea));
    			if($f!=null){
    	
    				// omitir comentarios en las lineas
    				$linea=is_int(strpos($linea, '/')) ? '88888' : $linea;
    				//omitir las líneas de coincidencia en este archivo
    				$linea=is_int(strpos($linea, "\$f=Functions::buscar_Texto('public function', htmlspecialchars(\$linea));")) ? '88888' : $linea;
    				$linea=is_int(strpos($linea, "\$linea[0]=str_replace('public function'")) ? '88888' : $linea;
    					
    				//ignorar lineas
    				$x=Functions::buscar_Texto('__construct|88888', $linea);
    	
    				if($x==null){
    					$linea=explode('(', $linea);
    					$linea[0]=str_replace('public function','', $linea[0]);
    					$linea[0]=trim($linea[0]);
    					$permiso=$nombre_controladorO.'-'.htmlspecialchars($linea[0]);
    						
    					// actualizar tabla de permisos
    					$nuevo_permiso=Permission::whereName($permiso)->first();
    	
    					if(empty($nuevo_permiso)){
    						$createP = new Permission();
    						$createP->name         = $permiso;
    						$createP->display_name = $permiso;
    						$createP->save();
    					}
    						
    					// array de permisos actuales
    					$array[]=$permiso;
    				}
    			}
    		}
    	}
    	
    		sort($array);
    		// depurar tabla de permisos para aquellas acciones que han sido eliminadas
    		foreach (Permission::all() as $per)
    		{
    			if(!in_array($per->name, $array)){
    				// solo se eliminará el permiso si no esta asociado a ningún rol
    				$p= new Permission();
    				$eliminar= $p->eliminar($per->name);
    				//print_r($eliminar);
    			}
    		}
    		
    		// preparar array con los controladores y sus metodos
    		$lista=array();
    		foreach($array as $controlador){
    				
    			$aux=explode('-', $controlador);
    				
    			if(array_key_exists($aux[0], $lista)){
    				$lista[$aux[0]][]=$aux[1];
    			}else{
    				$lista[$aux[0]]=array();
    				$lista[$aux[0]][]=$aux[1];
    			}
    				
    		}
    		
    		//$Permissions = DB::table('permissions')->get();
    		$vars = compact('Role', 'array', 'lista', 'array_permisos_rol', 'array_controladores_permisos');
    		return \View::make('roles.show')->with($vars);
    	
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	// get the Role
    	$Role = Role::find($id);
    	
    	// show the edit form and pass the Role
    	return \View::make('roles.edit')
    	->with('Role', $Role);
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
    	// validate
    	// read more on validation at http://laravel.com/docs/validation
    	$validator = Role::validation(\Input::all());
    	
    	// process the login
    	if ($validator->fails()) {
    		return \Redirect::to('roles/' . $id . '/edit')
    		->withErrors($validator);
    	} else {
    		// store
    		$Role = Role::find($id);
    		$Role->name       = \Input::get('name');
    		$Role->display_name      = Input::get('display_name');
    		$Role->description      = Input::get('description');
    		
    		$Role->save();
    	
    		// redirect
    		\Session::flash('message', 'Successfully updated Role!');
    		return \Redirect::to('roles');
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
    	// delete
    	$Rol = Role::find($id);
    	$Rol->delete();
    	
    	// redirect
    	\Session::flash('message', 'Successfully deleted the Role!');
    	return \Redirect::to('roles');
    }
    
    public function getAsignarPermiso($rolname){
    
    	$permiso=$_GET['permiso'];
    	$vals=PermisosRole::asignarPermiso($rolname, $permiso);
    
    	if($vals===true){
    		return \Response::json($vals);
    
    	}elseif(isset($vals['error']) AND !empty($vals['error'])){
    		$msg='
				<div class="alert alert-danger" role="alert">
				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				  <span class="sr-only">Error:</span>
				  '.$vals['error'].'
				</div>
			';
    
    		return \Response::json($msg);
    	}
    }
    
    
    public function getEliminarPermiso($rolname){
    
    	$permiso=$_GET['permiso'];
    	$vals=PermisosRole::eliminarPermiso($rolname, $permiso);
    
    	if($vals===true){
    		return \Response::json($vals);
    
    	}elseif(isset($vals['error']) AND !empty($vals['error'])){
    		$msg='
				<div class="alert alert-danger" role="alert">
				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				  <span class="sr-only">Error:</span>
				  '.$vals['error'].'
				</div>
			';
    
    		return \Response::json($msg);
    	}
    }
    
    public function getAsignarPermisosArray($rolname){
    
    	$controlador=$_GET['controlador'];
    	$permisos=Permission::buscarPermisosControlador($controlador);
    	$vals=PermisosRole::asignarPermisosArray($rolname, $permisos);
    
    	if(isset($vals['success']) AND !empty($vals['success'])){
    		$succes=true;
    		return \Response::json($succes);
    
    	}elseif(isset($vals['error']) AND !empty($vals['error'])){
    		$msg='
				<div class="alert alert-danger" role="alert">
				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				  <span class="sr-only">Error:</span>
				  <li>';
    		foreach($vals['error'] as $error){$msg.= $error;}
    		$msg.='</li>
				</div>
			';
    
    		return \Response::json($msg);
    	}
    }
    
    
    public function getEliminarPermisosArray($rolname){
    
    	$controlador=$_GET['controlador'];
    	$permisos=Permission::buscarPermisosControlador($controlador);
    	$vals=PermisosRole::eliminarPermisosArray($rolname, $permisos);
    
    	if($vals===true){
    		return \Response::json($vals);
    
    	}elseif(isset($vals['error']) AND !empty($vals['error'])){
    		$msg='
				<div class="alert alert-danger" role="alert">
				  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				  <span class="sr-only">Error:</span>
				  <li>';
    		foreach($vals['error'] as $error){$msg.= $error;}
    		$msg.='</li>
				</div>
			';
    
    		return \Response::json($msg);
    	}
    }
}
