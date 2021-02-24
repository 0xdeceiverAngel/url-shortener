<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;
use Hash;
use DB;
use Route;
class LoginCon extends Controller
{

    public function register(Request $request)
    {
        $cred = $request->only('name', 'email','password');
        $validator = Validator::make($cred,[
            'name'=>'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()) {
            $user = User::create([
                'username' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            AUTH::login($user, 1);
            return redirect()->intended('dashboard');
        } else {
            return redirect()->intended('index');
        }
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
            // return 'ok';
            // return view('info');
            return redirect()->intended('dashboard');
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
    public function index()
    {
        return view('index');
    }
    public function dashboard(Request $request)
    {
        $res=DB::table('mapping')->where('owner',$request->owner_id)->get();
        return view('dashboard',['user'=>$res]);
    }
    
}   

