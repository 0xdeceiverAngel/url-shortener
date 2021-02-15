<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Intervention\Image\Facades\Image;
use DateTime;
use DateTimeZone;
use Redis;
use Validator;
use Storage;
class url_mapping extends Controller
{
    
    public function check_url(Request $request)
    {
        if (is_null($request->url)) {                 //avoid url is null 
            return (array('result' => 'url_empty'));
        }
        $check = Validator::make($request->all(), [
            'url' => 'url'
        ]);
        if ($check->fails()) {
            return (array('result' => 'url_error'));
        }
        return 1;
    }
    public function save_to_redis($hash, $url)
    {
        $redis = Redis::connection();
        $redis->set($hash, $url);
        $redis->set($url, $hash);

        // $redis->hmset($url,array('hash'=>$hash,"url"=>$url));
    }
    public function is_in_redis($val) // hash or url both
    {
        $redis = Redis::connection();
        $res = $redis->get($val);
        if ($res != NULL) {
            return $res;
        } else {
            return NULL;
        }
    }
    // public function red(Request $request)
    // {
    //     $redis = Redis::connection();
    //     $val = $redis->hmget($url, array('hash', ""));
    //     if ($val) {
    //         return array("res" => "0");
    //     } else {
    //         return array("res" => NULL);
    //     }
    // }
    //==============================================================
    public function redirect(Request $request)
    {
        
        $date = new DateTime("now", new DateTimeZone('Asia/Taipei'));
        $url = $request->url;
        $redis_val = $this->is_in_redis($url);
        if ($redis_val !== NULL) {
            $find_url = DB::table('mapping')->where('redirect_url', $url)->first();
            $red_time= $find_url->redirect_times;
            DB::table('mapping')->where('redirect_url', $url)->update(
                ['redirect_times' => ++$red_time, 'last_time_use' => $date]
            );
            return redirect($redis_val);
        } else {
            $find_url = DB::table('mapping')->where('redirect_url', $url)->first();
            $red_time = $find_url->redirect_times;
            if ($find_url != NULL) {
                if ($find_url->type === 'url') { // if is url 
                    $this->save_to_redis($url, $find_url->org_url);
                    $find_url = DB::table('mapping')->where('redirect_url', $url)->first();
                    $red_time = $find_url->redirect_times;
                    DB::table('mapping')->where('redirect_url', $url)->update(
                        ['redirect_times' => ++$red_time, 'last_time_use' => $date]
                    );
                    return redirect($find_url->org_url, 301
                        // , ['custom-header' => 'custom value']
                    );
                } else if ($find_url->type === 'img' && is_null($find_url->password) && $request->isMethod('get')) { //if is img and no password set
                    $file_extension = $find_url->extension;
                    $filename = $find_url->file_name . "." . $file_extension;
                    $contents = Storage::get($filename);
                    $base64_data = base64_encode($contents);
                    return view(
                        'img_password',
                        [
                            'img_data' => $base64_data,
                            'summit_disyplay' => 'd-none',
                        ]
                    )->render();
                    // return base64_encode($contents);
                } else if ($find_url->type === 'img' && $find_url->password  === $request->password && $request->isMethod('post')) { // if is img and password correct
                    $file_extension = $find_url->extension;
                    $filename = $find_url->file_name . "." . $file_extension;
                    $contents = Storage::get($filename);
                    $base64_data = base64_encode($contents);
                    DB::table('mapping')->where('redirect_url', $url)->update(
                        ['last_time_use' => $date]
                    );
                    return $base64_data;
                } else if ($find_url->type === 'img' && $find_url->password  != $request->password && $request->isMethod('post')) {
                    return 'password error';
                } else if ($find_url->type === 'img') { //if is img and have to check password
                    return view(
                        'img_password',
                        [
                            'summit_disyplay' => 'input password',
                        ]
                    )->render();
                }
            } else {
                return redirect('/', 301
                    // , ['custom-header' => 'custom value']
                );
            }
        }
    }
    public function creat_url(Request $request)
    {
        $val = $this->check_url($request);
        if (1 != $val) {
            return $val;
        }

        $date = new DateTime("now", new DateTimeZone('Asia/Taipei'));
        $org_url = $request->url;
        $to_hash = $org_url . "Sa1t";
        $hash_url = sha1($to_hash);
        $hash_url = substr($hash_url, 0, 5);
        $redis_val = $this->is_in_redis($hash_url);
        if ($redis_val != NULL) {
            return (array('org' => urlencode($org_url), 'result' => $hash_url));
        } else {
            $find = DB::table('mapping')->where('redirect_url', (string)$hash_url)->first();
            if ($find != NULL) {
                $this->save_to_redis($hash_url, $org_url);
                return (array('org' => urlencode($org_url), 'result' => $hash_url));
            } else {
                $this->save_to_redis($hash_url, $org_url);
                DB::table('mapping')->insert(
                    [
                        'org_url' => (string) $org_url,
                        'redirect_url' => (string) $hash_url,
                        'type' => 'url',
                        'creat_time' => $date->format('Y-m-d H:i:s'),
                        'owner' => $request->owner
                    ]);
                return (array('org' => urlencode($org_url), 'result' => $hash_url));
            }
        }
    }
    public function img_creat(Request $request)
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Taipei'));
        $check = Validator::make($request->all(), [
            'file' => 'Image'
        ]);
        if ($check->fails()) {
            return (array('result' => 'img_error'));
        } else if (is_null($request->password)) {
            return (array('result' => 'must enter password'));
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
                    'type' => 'img',
                    'creat_time' => $date->format('Y-m-d H:i:s'),
                    'owner' => $request->owner

                ]
            );

            return (array('result' => $ranom_file_name));
        }
    }
}
