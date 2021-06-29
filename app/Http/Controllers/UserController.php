<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('guest')->except('logout');
        $this->middleware('auth:student')->except(['login','studentlogin']);
    }


    protected function guard()
    {
        return Auth::guard('student');
    }

    public function login()
    {
        return view('userlogin');
    }

    public function studentlogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        //    dd(Auth::guard('student'));
        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            //   dd(Auth::guard('student')->user());

            return redirect()->intended('/student');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function index()
    {
        // dd('dg');
        return view('userhome');
    }


    // public function index()
    // {
    //     return view('home');
    // }


    public function logout()
    {
        //  dd(Auth::guard('student'));
        //    dd( Auth::guard('student')->logout());
        // Session::flash();
        // Auth::logout();
        //      return redirect('/login');
        Auth::guard('student')->logout();
        return redirect('/login');
    }
}
