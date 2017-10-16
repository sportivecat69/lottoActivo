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

    
   
}
