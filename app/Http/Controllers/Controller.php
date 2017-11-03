<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Routing\Route;
use App\Http\Requests;
use Illuminate\Http\Request;



class Controller extends BaseController
{
use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private $nameController;
    private $nameAction;
    
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Route $route)
    {
    	// requiere autenticación
    	$this->middleware('auth');
    	
    	$r=$this->currentRoute($route);
    	list($this->nameController, $this->nameAction)=$r;
    	$controller=str_replace('Controller', '', $this->nameController);
    	
    	// creación del permiso sintaxis nameController-nameAction
    	$permiso=$controller.'-'.$this->nameAction;
    	$array_exception=array('Login', 'Reminders');// excepciones para aquellos controladores no requieran este middleware
    	if(!in_array($controller, $array_exception)){
    		$this->middleware('access:'.$permiso); // filtro de ruta
    	}
    
    	
    
    }
    
    /**
     * Función que retorna el controlador y action de la ruta actual
     * @return array nameController, nameAction
     * */
    private function currentRoute($route){
    
    	$return = array();
    
    	$current= $route->getActionName();
    	list($controller, $action) = explode('@', $current);
    
    	$return[]= preg_replace('/.*\\\/', '', $controller);
    	$return[]=preg_replace('/.*\\\/', '', $action);
    
    	return $return;
    
    }
    
}
