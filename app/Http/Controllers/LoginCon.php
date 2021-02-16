<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;
use Hash;
use DB;
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
        return redirect()->intended('dashboard');

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
            return view('info');
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
    public function dashboard(Request $request)
    {
        if($request->owner==NULL)
        {
            return redirect('/');
        }
        $res=DB::table('mapping')->where('owner',$request->owner)->get();
        // return response($res);
        return view('dashboard',['user'=>$res]);
    }
    public function home(Request $request)
    {
        // if($request->is_login===1)
        // {
            // $username = Auth::user();
            // return view('home',['username'=>$username]);
        // }
        // else
        // {
            return view('home');
        // }
    }
}   

