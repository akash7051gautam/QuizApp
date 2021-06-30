<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student')->except(['login','studentlogin','logout']);
    }

    public function login(){
        return view('auth.student');
    }

    public function studentlogin(Request $request){
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/student');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function logout(){
        Auth::guard('student')->logout();
        return redirect('/student/login');
    }
}
