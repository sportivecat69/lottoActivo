<?php 
namespace App\Security;
 
use Zizaco\Entrust\EntrustRole;
 
class Role extends EntrustRole
{
   protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
    
   //establecemos las relacion de muchos a muchos con el modelo User, ya que un rol 
   //lo pueden tener varios usuarios y un usuario puede tener varios roles
   public function users(){
        return $this->belongsToMany('App\User');
    }
    
    public static function validation($datos){
    	 
    	$rules = array(
    			'name'       => 'required|unique:roles,name',
    			'display_name'      => 'required',
    	);
    	
//     	$rules = array(
//     			'name'         => 'required|min:4|max:255|unique:roles,name',
//     			'display_name' => 'required|min:4|max:255|unique:roles,display_name',
//     	);
    	 
    	return $validator = \Validator::make($datos, $rules);
    	 
    }
}