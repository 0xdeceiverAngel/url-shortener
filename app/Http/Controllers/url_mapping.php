<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage as FacadesStorage;
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
        // return $request->grecaptcha;
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
        $check = Validator::make($request->all(), [
            'file' => 'Image'
        ]);
        if ($check->fails()) {
            return (array('result' => 'img_error'));
        }else{
            $password=$request->password;
            $file_extension=$request->extension;
            $ranom_file_name = bin2hex(random_bytes(16));
            $ranom_file_name = substr($ranom_file_name, 0, 6);

            Storage::put($ranom_file_name .'.'. $file_extension, $request->file('file')->get());
            // return ($ranom_file_name);
             DB::table('img_mapping')->insert(
                    [
                        'file_name' => $ranom_file_name,
                        'redirect_url' => $ranom_file_name,
                        'extension'=>$file_extension,
                        'password'=> $password,
                    ]);
            
            return (array('result' => $ranom_file_name));
        }


        
    }
}
