<?php
namespace App\Security;

use Illuminate\Database\Eloquent\Model;
use App\Security\Role;

class PermisosRole extends Model
{
	protected $table = 'permission_role';
	
	public static function obtenerNamePermisosRol($rolname){
		
		$rol = Role::whereName($rolname)->first();
		$permisos=self::where('role_id', '=', $rol->id)->get();
		$names=array();
		if(isset($permisos[0]) AND !empty($permisos)){
			foreach($permisos as $permiso){
				$p = Permission::find($permiso->permission_id);
				if(!empty($p)){
					$names[]=$p->name;
				}
			}
		}
		
		return $names;
		
	}

	public static function asignarPermiso($rolname, $name_permiso){
		
		$permiso = Permission::whereName($name_permiso)->first();
		$rol = Role::whereName($rolname)->first();
		
		if(!empty($permiso) AND !empty($rol)){
			
			try {
				
				$pr = self::where('permission_id', '=', $permiso->id)->where('role_id', '=', $rol->id)->get();
				if(isset($pr[0])){
					$mensaje['error']='El permiso ya existe para este rol.';
					return $mensaje;
					
				}else{
					$rol->attachPermission($permiso);
					return true;
				}

			}catch(\Exception $e){  //\Illuminate\Database\QueryException  usar $e para obtener el error del query
				$mensaje['error']='Ocurri&oacute un error contacte al administrador del sistema.';
				return $mensaje;
			}
		}else{
			$mensaje['error']="No se puede asignar el permiso.";
			return $mensaje;
		}
	}
	
	
	
	public static function eliminarPermiso($rolname, $name_permiso){
		$mensaje['error']='';
	
		$permiso = Permission::whereName($name_permiso)->first();
		$rol = Role::whereName($rolname)->first();
	
		if((!empty($permiso)) AND  empty($permisos_roles)){
				
			try {
				//eliminar permisos asociados
				\DB::table('permission_role')->where('permission_id', '=', $permiso->id)->where('role_id', '=', $rol->id)->delete();
	
				return true;
			}catch(\Exception $e){  //\Illuminate\Database\QueryException  usar $e para obtener el error del query
				$mensaje['error']='Ocurri&oacute un error contacte al administrador del sistema.';
				return $mensaje;
			}
		}else{
			$mensaje['error']="No se puede eliminar el permiso yaque no existe para este rol.";
			return $mensaje;
		}
	}
	
	/**
	 * @autor ypacheco
	 * Funci�n que permite asignar varios permisos a un rol
	 * @param array permisos
	 * @param string rol
	 * @return bool array permisos y errores
	 * */
	public static function asignarPermisosArray($rolname, $name_permisos){
	
		$permisos=array();
		$mensaje['error']=array();
		$rol = Role::whereName($rolname)->first();
		
		if(!empty($name_permisos) AND count($name_permisos)>0){
			
			foreach($name_permisos as $permiso){
				
				if(!empty($permiso) AND !empty($rol)){
				
					try {
				
						$pr = self::where('permission_id', '=', $permiso->id)->where('role_id', '=', $rol->id)->get();
						if(isset($pr[0])){
							$mensaje['error'][]='El permiso '.$permiso->name.' ya existe para este rol.';
						}else{
							$rol->attachPermission($permiso);
							$permisos[]=$permiso->name;
						}
				
					}catch(\Exception $e){  //\Illuminate\Database\QueryException  usar $e para obtener el error del query
						$mensaje['error'][]='Ocurri&oacute un error contacte al administrador del sistema.';
					}
				}else{
					$mensaje['error'][]="No se puede asignar el permiso.".$permiso->name;
				}
			}
			
		}else{
			$mensaje['error'][]="No se ha recibido ning&uacute;n permiso.";
		}
		
		$return['success']= count($permisos)>0 ? $permisos : '';
		$return['error']= count($mensaje['error'])>0 ? $mensaje['error'] : '';
		
		return $return;
		
	}
	
	/**
	 * @autor ypacheco
	 * Funci�n que permite eliminar varios permisos a un rol
	 * @param array permisos
	 * @param string rol
	 * @return bool array permisos y errores
	 * */
	public static function eliminarPermisosArray($rolname, $name_permisos){
		$permisos=array();
		$mensaje['error']=array();
		$rol = Role::whereName($rolname)->first();
		
		if(!empty($name_permisos) AND count($name_permisos)>0){
			
			foreach($name_permisos as $permiso){
				$delete=self::eliminarPermiso($rolname, $permiso->name);
				if(isset($delete['error'])){
					$mensaje['error'][]=$delete['error'];
				}
			}
		}
		
		if(!empty($mensaje['error']) AND $mensaje['error']>0){
			return $mensaje['error'];
		}else{
			return true;
		}
		
	}
}