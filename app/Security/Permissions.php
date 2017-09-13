<?php 

namespace App\Security;
 
use Zizaco\Entrust\EntrustPermission;
 
class Permission extends EntrustPermission
{
   protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
 
   //establecemos las relacion de muchos a muchos con el modelo Role, ya que un permiso
   //lo pueden tener varios roles y un rol puede tener varios permisos
   public function roles(){
        return $this->belongsToMany('App\Security\Role');
    }
    
    public static function buscarPermisosControlador($controlador){
    
    	$permisos = self::where('name', 'like', $controlador."-%")->get();
    	return $permisos;
    }
    
    /**
     * @autor ypacheco
     * Función que retorna cantidad de permisos segun controlador para un array de permisos dado
     * @param array nomre de permisos
     * @ return array controladores con cantidad de permisos que aplican y cantidad que hay en el array dado
     * */
    public static function validarPermisosEnControladores($array_permisos){
    	$controladores=array();
    	$search=array();
    	foreach ($array_permisos as $permiso){
    		$contr=explode('-', $permiso);
    
    		if(!in_array($contr[0], $search)){
    			$controlador=$contr[0];
    			$aux=self::buscarPermisosControlador($controlador);
    			$controladores[$controlador]['total_permisos']=count($aux);
    			$controladores[$controlador]['total_permisos_rol']=1;
    			$search[]=$controlador;
    		}else{
    			$controladores[$controlador]['total_permisos_rol']++;
    		}
    	}
    
    	return $controladores;
    }
    
    public function eliminar($name){
    	$mensaje['error']='';
    
    	$permiso = Permission::whereName($name)->first();
    	$permisos_roles=PermisosRole::where('permission_id', $permiso->id)->first();
    
    	if((!empty($permiso)) AND  empty($permisos_roles)){
    			
    		try {
    			//eliminar permisos asociados
    			\DB::table('permission_role')->where('permission_id', $permiso->id)->delete();
    
    			return true;
    		}catch(\Exception $e){  //\Illuminate\Database\QueryException  usar $e para obtener el error del query
    			$mensaje['error']='Ocurri&oacute un error contacte al administrador del sistema.';
    			return $mensaje;
    		}
    	}else{
    		$mensaje['error']="No se puede eliminar el permiso ya que posee roles asociados.";
    		return $mensaje;
    	}
    }
}
