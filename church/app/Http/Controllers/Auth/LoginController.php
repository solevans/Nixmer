<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function username()
    {
        return 'username';
    }

    protected function attemptLogin(Request $request)
    {
        $credentials=$this->credentials($request);
        $user=User::where('username',$credentials['username']->first());
        if($user && $this->guard()->attempt($credentials,$request->filled('remember'))){
            if($user->userType->usertype==='DEVELOPER'){
                return redirect()->intended('/developer/dashboard');
            }elseif($user->userType->usertype==='ACCOUNTS'){
                return redirect()->intended('/accounts/dashboard');
            }elseif($user->userType->usertype==='ENTRY CLERK'){
                return redirect()->intended('/entryclerk/dashboard');
            }elseif($user->userType->usertype==='SYSTEM ADMINISTRATOR'){
                return redirect()->intended('/admin/dashboard');
            }elseif($user->userType->usertype==='MEMBER USER'){
                return redirect()->intended('/member/dashboard');
            }
        }
    }
    
    protected function authenticated(Request $request, $user)
    {
        if($user->userType->usertype==='DEVELOPER'){
            return redirect()->intended('/developer/dashboard');
        }elseif($user->userType->usertype==='ACCOUNTS'){
            return redirect()->intended('/accounts/dashboard');
        }elseif($user->userType->usertype==='ENTRY CLERK'){
            return redirect()->intended('/entryclerk/dashboard');
        }elseif($user->userType->usertype==='SYSTEM ADMINISTRATOR'){
            return redirect()->intended('/admin/dashboard');
        }elseif($user->userType->usertype==='MEMBER USER'){
            return redirect()->intended('/member/dashboard');
        }
        return redirect()->intended('/');
    }
}
