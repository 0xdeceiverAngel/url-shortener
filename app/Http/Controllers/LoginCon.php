<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
class LoginCon extends Controller
{

    public function show()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $cred=$request->only('email','password');
        $rem=$request->only('remember');
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($cred, $rules);
        if(Auth::attempt($cred,$rem)&&$validator->passes())
        {
            // return redirect('/',301);
            return 'ok';
        }
        else
        {
            return redirect('/', 301);
            
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/',301);
    }
    public function info()
    {
        return view('info');
    }
}
