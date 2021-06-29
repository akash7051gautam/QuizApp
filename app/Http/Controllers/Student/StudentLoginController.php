<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentLoginController extends Controller
{
    public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->middleware('guest:student')->except('logout');
        }
    public function login(Request $request){
        dd($request->all());
    }
}
