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
    	//El sistema tendrá un mini administrador que será el rol banker y todos los demás son vendedores
        $users = User::paginate(10); // falta  sacar el rooter y banker
//     	$users = User::whereHas(['rol' => function($q){
//     		$q->where('name', '=','seller');
//     	}])->get();
//     	dd($users);die();
        return view('users-mgmt.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    	$Roles= Role::where('name','=','seller')->pluck('display_name', 'id')->all();
    	return view('users-mgmt/create')->with('Roles', $Roles);
    	
       
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
    			 
    			$role=(int)$request['user_level'];
    			$user = User::find($val);
    			$user->attachRole($role);
    			 
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
        //$Roles= Role::where('name','<>','rooter')->where('name','<>','banker')->pluck('display_name', 'id')->prepend('Seleccione', null);
        $Roles= Role::where('name','=','seller')->pluck('display_name', 'id')->all();
        // Redirect to user list if updating user wasn't existed
        if ($user == null || count($user) == 0) {
            return redirect()->intended('/usermanagement');
        }

        return view('users-mgmt/edit', ['user' => $user, 'Roles' =>$Roles]);
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
    			$role=(int)$request['user_level'];
    			$user->attachRole($role);
    			 
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
    	//RolesUsuario::where('user_id', $id)->delete();
        //User::where('id', $id)->delete();
    	$user = User::find($id);

    	if(empty($user->deleted_at)){
    		$user->deleted_at=Carbon::now();
    		$user->update();
    		return redirect()->route('usermanagement.index')->with('succes', 'Usuario Inactivo');
    	}else{
    		$user->deleted_at=null; 
    		$user->update();
    		return redirect()->route('usermanagement.index')->with('succes', 'Usuario Activo');
    	}
    	
    	
    }

}
