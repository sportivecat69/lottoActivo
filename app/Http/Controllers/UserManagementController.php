<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Security\Role;
use App\Security\RolesUsuario;
use Illuminate\Support\Facades\Auth;
use App\SellerAgency;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Printer;
use App\Agency;

class UserManagementController extends Controller
{
       /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/usermanagement';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	/***
    	 * El sistema tendrá un mini administrador que será el rol banker y todos los demás son vendedores
    	 * Se listan sólo los vendedores 
    	 */

        //$users = User::where('id', '!=', Auth::id())->where('id', '!=', 1)->paginate(10);
        //$users = User::with(['rol' => function ($query) {$query->where('name','seller');}])->paginate(10);
        
        $users = User::query()
        ->select('users.*')
        ->leftjoin('role_user as ru','ru.user_id', '=', 'users.id')
        ->leftjoin('roles as r','r.id', '=', 'ru.role_id')
        ->where('r.name','seller')
        ->where('users.id', '!=', 1) // solo por seguridad
        ->paginate(10);    
        
        return view('users-mgmt.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    	/***
    	 * Sólo se lista el rol seller
    	 */
    	
    	$Roles= Role::where('name','=','seller')->pluck('display_name', 'id')->all();
    	$Agencies= Agency::all()->pluck('name', 'id')->all();
    	$Printers= Printer::all()->pluck('name', 'id')->all();
    	return view('users-mgmt/create')->with(['Roles'=>$Roles, 'Agencies'=>$Agencies, 'Printers'=>$Printers]);
    	
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$user=new User();
    	$data= $request->except(['_token','_method']);
    	
    	$validator = Validator::make($data, $user->rules);
        
    	if ($validator->fails()){
    		return redirect()->route('usermanagement.create')
    		->withErrors($validator)
    		->withInput();
    	}else{
    		
    		$val=$user->crearUsuario($data);
    		
    		if(is_int($val)){

    			
//     			$role=(int)$request['user_level'];
//     			$user = User::find($val);
//     			$user->attachRole($role);

				/***
				 * Sólo se pueden crear usuarios con rol seller
				 */
    			
    			$role=Role::where('name','=','seller')->first();
    			$user = User::find($val);
    			$user->attachRole($role->id);
    			
    			$sellers_agency= new SellerAgency();
    			$sellers_agency->agencies_id=(int)$request['agency'];
    			$sellers_agency->printer_id=(int)$request['printer'];
    			$sellers_agency->users_id=$val;
    			$sellers_agency->save();
    			 
    			return redirect()->route('usermanagement.index')->with('succes', 'Usuario registrado');
    		}else{
    			return redirect()->route('usermanagement.index')->with('fail', 'Hubo un error intente de nuevo');
    		}
    		
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
    	$user = User::find($id);
    	return view('users-mgmt/show', ['user' => $user]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $Roles= Role::where('name','=','seller')->pluck('display_name', 'id')->all();
        // Redirect to user list if updating user wasn't existed
        
        $Agencies= Agency::all()->pluck('name', 'id')->all();
        $Printers= Printer::all()->pluck('name', 'id')->all();

        /***
         * NO se permite editar el usuario admin ni el usuario en sesión este debe editar su perfil, tampoco un usuario con rol banker
         */
        
        if ($user == null || count($user) == 0 || $user->id == 1 || $user->id == Auth::id() || $user->hasRole('banker')) {
            return redirect()->intended('/usermanagement');
        }

        return view('users-mgmt/edit', ['user' => $user, 'Roles' =>$Roles, 'Agencies'=>$Agencies, 'Printers'=>$Printers]);
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
        $user = User::find($id);
 
    	$data= $request->except(['_token','_method']);
    	$rules=$user->rules;
    	
    	
    	$rules['email'] .= ",{$user->id}";
    	$rules['documento'] .= ",{$user->id}";
    	
    	$validator = Validator::make($data, $rules);
        
    	if ($validator->fails()){
    		return redirect()->route('usermanagement.edit', $id)
    		->withErrors($validator)
    		->withInput();
    	}else{
    		
    		$val=$user->editarUsuario($data, $id);
    		
    		if(is_int($val)){
    			 
     			RolesUsuario::where('user_id', $id)->delete();
     			
//     			$role=(int)$request['user_level'];
//     			$user->attachRole($role);

    			/***
				 * Sólo se pueden crear usuarios con rol seller
				 */
     			
    			$role=Role::where('name','=','seller')->first();
    			$user->attachRole($role->id);
    			
    			SellerAgency::where('users_id', $id)->delete();
    			$sellers_agency= new SellerAgency();
    			$sellers_agency->agencies_id=(int)$request['agency'];
    			$sellers_agency->printer_id=(int)$request['printer'];
    			$sellers_agency->users_id=$id;
    			$sellers_agency->save();
    			 
    			return redirect()->route('usermanagement.index')->with('succes', 'Usuario modificado');
    		}else{
    			return redirect()->route('usermanagement.index')->with('fail', 'Hubo un error intente de nuevo');
    		}
    		
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
    	/***
    	 * Se evalua por fecha deleted_at, si la misma no existe se inactiva el usuario de lo contrario se activa
    	 */
    	
    	//RolesUsuario::where('user_id', $id)->delete();
        //User::where('id', $id)->delete();
        
    	$user = User::find($id);

    	if(empty($user->deleted_at)){
    		$user->deleted_at=Carbon::now();
    		$user->update();
    		return redirect()->route('usermanagement.index')->with('succes', 'Usuario Inactivo');
    	}else{
    		
    		//validar si la agencia esta activa
    		if($user->seller_agency->agency->status===true){
	    		$user->deleted_at=null; 
	    		$user->update();
	    		return redirect()->route('usermanagement.index')->with('succes', 'Usuario Activo');
	    		
    		}else{
    			return redirect()->route('usermanagement.index')->with('fail', 'El usuario no puede ser activado, la agencia esta inactiva');
    		}
    		
    	}
    	
    	
    }

}
