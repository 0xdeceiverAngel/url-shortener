<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;
use Hash;
use DB;
use Route;
use Redis;
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
            $res = DB::table('users')->where('email', $request->email)->first();
            if(sizeof((array)$res)!=0)
            {
                return response('exist');
            }
            $user = User::create([
                'username' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            AUTH::login($user, 1);
            return response('ok');
            // return redirect()->intended('dashboard');
        } else {
            // return redirect()->intended('index');
            return response('format error');

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
            $res = DB::table('mapping')->where('owner', Auth::user()->id)->get();
            $redis = Redis::connection();
            foreach($res as $data)
            {
                $redis->hmset($data->redirect_url, array(
                    "url" => $data->org_url ?? "",
                    "type" => $data->type ?? "",
                    "redirect_times" => $data->redirect_times ?? "",
                    "creat_time" => $data->creat_time ?? "",
                    "last_time_use" => $data->last_time_use ?? "",
                    "password" => $data->password ?? "",
                    "file_name" => $data->file_name ?? "",
                    "extension" => $data->extension ?? "",
                    "owner" =>  Auth::user()->id ?? ""
                ));
                
            }
            return 'ok';
            // return view('info');
            // return redirect()->intended('dashboard');
        }
        else
        {
            // return redirect('/', 301);
            return response('error info');
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
        $res = DB::table('mapping')->where('owner', $request->owner_id)->get();
        return view('dashboard', ['user' => $res]);
    }
    
}   

