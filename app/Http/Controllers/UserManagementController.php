<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Security\Role;
use App\Security\RolesUsuario;

class UserManagementController extends Controller
{
       /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user-management';

         /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);

        return view('users-mgmt.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	//$Roles= Role::pluck('display_name', 'id');
    	//$Roles= Role::where('name','<>','rooter')->pluck('display_name', 'id')->prepend('Seleccione', 0);
    	$Roles= Role::where('name','<>','rooter')->where('name','<>','banker')->pluck('display_name', 'id')->all();
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
    	$this->validateInput($request);
        
        $user=User::create([
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
         	'documento' => $request['documento'],
        ]);
        
        
    	$role=(int)$request['user_level'];
        $user->attachRole($role);
        
        return redirect()->intended('/user-management');
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
        $user = User::find($id);
        $Roles= Role::where('name','<>','rooter')->where('name','<>','banker')->pluck('display_name', 'id')->prepend('Seleccione', null);
        // Redirect to user list if updating user wasn't existed
        if ($user == null || count($user) == 0) {
            return redirect()->intended('/user-management');
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
        $user = User::findOrFail($id);
        $constraints = [
            'firstname'=> 'required|max:60',
            'lastname' => 'required|max:60',
            ];
        $input = [
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
        ];
        if ($request['password'] != null && strlen($request['password']) > 0) {
            $constraints['password'] = 'required|min:6|confirmed';
            $input['password'] =  bcrypt($request['password']);
        }
        $this->validate($request, $constraints);
        User::where('id', $id)
            ->update($input);
            
        RolesUsuario::where('user_id', $id)->delete();
        $role=(int)$request['user_level'];
        $user->attachRole($role);
        
        return redirect()->intended('/user-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	RolesUsuario::where('user_id', $id)->delete();
        User::where('id', $id)->delete();
         return redirect()->intended('/user-management');
    }


    private function validateInput($request) {
        $this->validate($request, [
        'email' 	 => 'required|email|max:255|unique:users,email',
        'user_level' => 'required|numeric',
        'password' => 'required|min:6|confirmed',
        'firstname' => 'required|max:60',
        'lastname' => 'required|max:60',
        'documento' => 'required|max:255|unique:users', //documento
    ]);
    }
}
