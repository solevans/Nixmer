<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLog;

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
        $this->middleware('auth')->only('logout');
    }
    
    public function username()
    {
        return 'username';
    }

    protected function attemptLogin(Request $request)
    {        
        $credentials=$this->credentials($request);
        //dd((new User)->getTable());
        $user=User::where('username',$credentials['username'])->first();
        if($user && $user->is_active_user && $this->guard()->attempt($credentials,$request->filled('remember'))){
            if($user->userType->usertype==='DEVELOPER'){
                return redirect()->intended('/developer/index');
            }elseif($user->userType->usertype==='ACCOUNTS'){
                return redirect()->intended('/accounts/index');
            }elseif($user->userType->usertype==='ENTRY CLERK'){
                return redirect()->intended('/entryclerk/index');
            }elseif($user->userType->usertype==='SYSTEM ADMINISTRATOR'){
                return redirect()->intended('/admin/index');
            }elseif($user->userType->usertype==='MEMBER USER'){
                return redirect()->intended('/member/index');
            }
        }
        return false;
    }
    
    protected function authenticated(Request $request, $user)
    {        //dd($user->uid);
        $user->load('userType');
        UserLog::create([
            'user_id'=>$user->uid,
            'login_time'=>now(),
            'machine_name'=>$request->server('SERVER_NAME'),
            'machine_ip'=>$request->ip()
        ]);

        if($user->userType->usertype==='DEVELOPER'){
            return redirect()->intended('/developer/index');
        }elseif($user->userType->usertype==='ACCOUNTS'){
            return redirect()->intended('/accounts/index');
        }elseif($user->userType->usertype==='ENTRY CLERK'){
            return redirect()->intended('/entryclerk/index');
        }elseif($user->userType->usertype==='SYSTEM ADMINISTRATOR'){
            return redirect()->intended('/admin/index');
        }elseif($user->userType->usertype==='MEMBER USER'){
            return redirect()->intended('/member/index');
        }
        
        
        
        return redirect()->intended('/');      
    }

    public function logout(Request $request)
    {
        $userlog=UserLog::where('user_id', auth()->user()->id)
            ->whereNull('logout')
            ->orderBy('login_time')
            ->first();

        if($userlog){
            $userlog->update([
                'logout_time'=>now(),
                'is_proper_logout'=>true
            ]);
        }

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        redirect('/');
    }
}
