<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Redis;
use Illuminate\Bus\Dispatcher;
use App\Jobs\db_sync;

class url_manage extends Controller
{

    public function delete_url(Request $request)
    {


        $res = DB::table('mapping')->where('redirect_url', $request->url)->first();
        // return response($res->owner.$request->owner_id);
        if ((string)$res->owner == (string)$request->owner_id) {
            $redis = Redis::connection();
            $redis->del($request->url);

            $tmp = array(
                "method" => "del_url",
                "url" => $request->url,
            );
            $job = (new db_sync($tmp));
            dispatch_now($job);

            return response('success');
        } else {
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

          

            $tmp = array(
                "method" => "change_pw",
                "url" => $res->url,
                "pw"=>$res->pw
            );
            $job = (new db_sync($tmp));
            dispatch_now($job);

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
