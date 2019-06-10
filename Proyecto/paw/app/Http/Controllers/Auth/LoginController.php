<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(){
        $this->middleware('guest')->except('postLogout');
    }

    protected function showLogin(){
          return view('auth.login');
    }

    public function postLogin(){
        $credentials = $this->validate(request(), [
            $this->username() => 'email|required|string',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($credentials)){
            return redirect()->route('in.inicio');
        }else{
            return back()
                ->withErrors([$this->username() => trans('auth.failed')])
                ->withInput(request([$this->username()]));
        }
    } 

    public function postLogout(){
        Auth::logout();
        return redirect()->route('auth.login');
    }

        public function username(){
        return 'email';
    }
}
