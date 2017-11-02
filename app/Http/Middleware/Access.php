<?php
/**
 * @autor ypacheco
 * @date 01-02-2017
 *
 * Middleware que controlará los permisos de acceso a los controladores
 * Prioridad: Alta
 *
 * */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;



class Access
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	
	
	/**
	 * @param $permission acción del controlador consultado
	 * 
	 * */	
    public function handle($request, Closure $next, $permission)
    {
    	/**
    	 * Si el usuario no es rooter, se requiere validar permisos
    	 * */
    	if(!Auth::user()->hasRole('rooter')){
    		if (!Auth::user()->can($permission)) {	// no tiene el permiso
    			abort(401,'Unauthorized Action');
    		}
    	}
    	
     	return $next($request);
    
    }
    
}
