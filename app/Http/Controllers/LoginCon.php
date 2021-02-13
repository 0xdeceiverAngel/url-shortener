<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;
use Hash;
class LoginCon extends Controller
{

    public function register(Request $request)
    {
        $user=User::create([
            'username' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        AUTH::login($user,1);
        return redirect()->intended('info');

        // return response('success');
    }
    public function show()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $cred=$request->only('email','password');
        // $rem=$request->only('remember');
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $validator = Validator::make($cred, $rules);
        // $user = new User;
        // $user->email= $request->email;
        // $user->password = $request->password;
        if(Auth::attempt($cred,1)&&$validator->passes())
        {
            // return redirect('/',301);
            // return 'ok';
            return redirect()->intended('info');
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
