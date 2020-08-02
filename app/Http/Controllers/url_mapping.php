<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Intervention\Image\Facades\Image;
use Validator;
use Storage;

class url_mapping extends Controller
{
    //
    public function redirect(Request $request)
    {

        $url = $request->url;
        $find_url = DB::table('mapping')->where('redirect_url', $url)->first();
        if ($find_url != NULL) {
            if ($find_url->type === 'url') { // if is url redirecr
                return redirect($find_url->org_url, 301
                    // , ['custom-header' => 'custom value']
                );
            } else if ($find_url->type === 'img' && $find_url->password === '' && $request->isMethod('get')) { //if is img and no password set
                $file_extension = $find_url->extension;
                $filename = $find_url->file_name . "." . $file_extension;
                $contents = Storage::get($filename);
                $base64_data=base64_encode($contents);
                return view('img_password',
                    ['img_data'=> $base64_data,
                      'summit_disyplay'=>'d-none',])->render();
                // return base64_encode($contents);
            } else if ($find_url->type === 'img' && $find_url->password  === $request->password && $request->isMethod('post')) { // if is img and password correct
                $file_extension = $find_url->extension;
                $filename = $find_url->file_name . "." . $file_extension;
                $contents = Storage::get($filename);
                $base64_data = base64_encode($contents);
                return $base64_data;
            } else if ($find_url->type === 'img') { //if is img and have to check password
                return view('img_password');
            }
        } else {
            return redirect('/', 301
                // , ['custom-header' => 'custom value']
            );
        }
    }
    public function creat(Request $request)
    {

        if (is_null($request->url)) {                 //avoid url is null 
            return (array('result' => 'url_empty'));
        }
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
            $find = DB::table('mapping')->where('redirect_url', (string)$hash_url)->first();
            if ($find != NULL) {
                return (array('org' => urlencode($org_url), 'result' => $hash_url));
            } else {

                DB::table('mapping')->insert(
                    [
                        'org_url' => (string) $org_url,
                        'redirect_url' => (string) $hash_url,
                        'type' => 'url'
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
        } else {
            $password = $request->password;
            $file_extension = $request->extension;
            $ranom_file_name = bin2hex(random_bytes(16));
            $ranom_file_name = substr($ranom_file_name, 0, 6);

            Storage::put($ranom_file_name . '.' . $file_extension, $request->file('file')->get());
            // return ($ranom_file_name);
            DB::table('mapping')->insert(
                [
                    'file_name' => (string) $ranom_file_name,
                    'redirect_url' => (string) $ranom_file_name,
                    'extension' => (string) $file_extension,
                    'password' => (string) $password,
                    'type' => 'img'
                ]
            );

            return (array('result' => $ranom_file_name));
        }
    }
}
