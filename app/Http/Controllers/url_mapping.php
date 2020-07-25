<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Storage;
class url_mapping extends Controller
{
    //
    public function redirect($url)
    {
        // echo $url;
        $find = DB::table('mapping')->where('redirect_url', $url)->first();
        if ($find != NULL) {
            return redirect($find->org_url, 301
                // , ['custom-header' => 'custom value']
            );
        } else {
            return view('home');
        }
        // return $find->org_url;
        // return $find;

    }
    public function creat(Request $request)
    {
        // $times=0;

        $check = Validator::make($request->all(), [
            'url' => 'url'
        ]);

        if ($check->fails()) {
            return (array('result' => 'url_error'));
        } else {
            $org_url = $request->url;

            $to_hash = $org_url . "Sa1t";
            $hash_url = sha1($to_hash);
            $hash_url = substr($hash_url, 0, 5);
            // $date = new DateTime();
            // $date= $date->format('Y-m-d H:i:s');
            $find = DB::table('mapping')->where('redirect_url', $hash_url)->first();
            if ($find != NULL) {
                return (array('org' => urlencode($org_url), 'result' => $hash_url));
            } else {

                DB::table('mapping')->insert(
                    [
                        'org_url' => $org_url,
                        'redirect_url' => $hash_url
                    ]
                    // 'redirect_time'=>'0',
                    // 'creat_time'=>$date]
                    // 'last_time_use'=>NULL]
                );
                return (array('org' => urlencode($org_url), 'result' => $hash_url));
            }
        }
    }
    public function img_creat(Request $request)
    {
        
    }
}
