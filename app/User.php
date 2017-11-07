<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    
    public $user_level; // role
    
    public $agency; // agency associated
    
    public $printer; // printer associated
    
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'documento', 'email', 'password', 'firstname', 'lastname'
    ];
    
    
    public $rules = array(
    		'documento'       => 'required|min:10|max:15|unique:users,documento',
    		'firstname'       => 'required|min:3|max:255',
    		'lastname'       => 'required|min:3|max:255',
    		'email' 	 => 'required|email|max:255|unique:users,email',
    		'user_level' => 'required|numeric',
    		'agency' => 'required|numeric',
    		'printer' => 'required|numeric'
    );
    
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = ['remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function rol()
    {
    	return $this->belongsToMany('App\Security\Role', 'role_user');
    }
    
	public function seller_agency()
    {
    	return $this->hasOne(SellerAgency::class, 'users_id', 'id');
    }
    
    public function crearUsuario($datos)
    {
    	   
    		unset($datos['user_level']);
    		unset($datos['agency']);
    		unset($datos['printer']);
    		$datos['password']=bcrypt($datos['documento']);
    		
    		if($id=User::insertGetId($datos)){
    			return $id;
    		}else{
    			return false;
    		}
    
    		
    }
    
    public function editarUsuario($datos, $id)
    {
//     	self::$rules['email'] .= ",{$user->id}";
//     	self::$rules['documento'] .= ",{$user->id}";
    	$user = User::find($id);
    	unset($datos['user_level']);
    	unset($datos['agency']);
    	unset($datos['printer']);
    	$datos['password']=bcrypt($datos['documento']);
    	if($user->update($datos)){
    		return $user->id;
    	}else{
    		return false;
    	}

    }
}
