<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class url_manage extends Controller
{
    public function delete_url(Request $request)
    {
        // $res = DB::table('mapping')->where('redirect_url', $request->url)->first();

        // return response($request->owner.$res->owner);
        if($request->owner!=null)
        {
            $res= DB::table('mapping')->where('redirect_url', $request->url)->first();
            if((string)$res->owner== (string)$request->owner)
            {
                DB::table('mapping')->where('redirect_url', $request->url)->delete();
                return response('success');
            }
            else
            {
                return response('try to del others url');
            }
        }
        else
        {
            return response('no auth');
        }
        
    }
    public function change_pw(Request $request)
    {
        if($request->pw=='')
        {
            return response('no password');
        }
        $pw= $request->pw;
        if ($request->owner != null) {
            $res = DB::table('mapping')->where('redirect_url', $request->url)->first();
            if ((string)$res->owner == (string)$request->owner) {
                DB::table('mapping')->where('redirect_url', $request->url)->update(
                    ['password'=>$pw]
                );
                return response('success');
            } else {
                return response('try to change others url');
            }
        } else {
            return response('no auth');
        }
    }
}
