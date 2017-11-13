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

class ProfileController extends Controller
{
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
     * Show the user profile.
     *
     * @return \Illuminate\Http\Response
     */
//     public function index()
//     {
//         return view('profile');
//     }
    
    /**
     * Display profile.
     *
     * @param  Auth::id()
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
    	$user = User::find(Auth::id());
    	return view('profile', ['user' => $user]);
    }
}
