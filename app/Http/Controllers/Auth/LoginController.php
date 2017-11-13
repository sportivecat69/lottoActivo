<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

     /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts ($request) {
        $maxLoginAttempts = 2;
        $lockoutTime = 1; // 1 minutes
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $maxLoginAttempts, $lockoutTime
        );
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
//     public function authenticate()
//     {
//     	if (Auth::attempt(['email' => $email, 'password' => $password, 'app_status' => TRUE], $remember)) {
    		
//     		Auth::user()->session=TRUE;
//     		Auth::user()->update();
//     		// Authentication passed...
//     		return redirect()->intended('dashboard');
//     	}
//     }

    protected function credentials($request)
    {
    	$request['app_status'] = true; // app activa
    	$request['session'] = false; // no posee session
    	$request['deleted_at'] = null; // esta activo
    	return $request->only($this->username(), 'password', 'app_status', 'session', 'deleted_at');
    }
}
