<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class url_manage extends Controller
{
    public function delete_url(Request $request)
    {

            
            $res= DB::table('mapping')->where('redirect_url', $request->url)->first();
            // return response($res->owner.$request->owner_id);
            if((string)$res->owner== (string)$request->owner_id)
            {
                DB::table('mapping')->where('redirect_url', $request->url)->delete();
                return response('success');
            }
            else
            {
                return response('try to del others url');
            }
        
    }
    public function change_pw(Request $request)
    {
        // $pw = $request->only('pw');
        // $validator = Validator::make($pw, [
            // 'pw' => 'required',
        // ]);
        // if ($validator->passes()) {
            $res = DB::table('mapping')->where('redirect_url', $request->url)->first();
            if ((string)$res->owner == (string)$request->owner_id) {
                DB::table('mapping')->where('redirect_url', $request->url)->update(
                    ['password' => $request->pw]
                );
                return response('success');
            } else {
                return response('try to change others url');
            }
        // }
        // else{
            // return response('no password');
        // }
       
            
    }
}
