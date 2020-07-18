<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

class url_mapping extends Controller
{
    
    public function redirect($url)
    {
        // echo $url;
        $find = DB::table('mapping')->where('redirect_url', $url)->first();
        return $find->org_url;
    }
    public function creat(Request $request)
    {
        // $times=0;
        $org_url = $request->url;
        if ($org_url == '') {
            return 'url empty';
        } else {
            $hash_url = sha1($org_url);
            $hash_url = substr($hash_url, 0, 5);
            // $date = new DateTime();
            // $date= $date->format('Y-m-d H:i:s');
            // $find = DB::table('mapping')->where('redirect_url', $hash_url)->first();
            // if ($find != NULL) {
                // return 'already have';
            // } else {
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
            // }
        }
    }
}
