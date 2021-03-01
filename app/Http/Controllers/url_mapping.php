<?php

namespace App\Http\Controllers;

use App\Jobs\db_sync;
use App\Jobs\ProcessPodcast;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Intervention\Image\Facades\Image;
use DateTime;
use DateTimeZone;
use Redis;
use Validator;
use Storage;
use Auth;

class url_mapping extends Controller
{
    public function check_img_size_and_type_and_pw(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'max:500000',
            'file' => 'Image'
        ]);
        if ($validator->fails()) {
            return (array('result' => 'img_too_large or not_img'));
        }
        // if (is_null($request->password)) {
        // return (array('result' => 'must enter password'));
        // }
        return 1;
    }
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
    public function save_to_redis($hash, $url, $type, $cre_time, $red_time, $last_t_u, $pw, $f_n, $ex, $id)
    {
        $redis = Redis::connection();
        // $redis->set($hash, $url);
        // $redis->set($url, $hash);
        $redis->hmset($hash, array(
            "url" => $url ?? "",
            "type" => $type ?? "",
            "redirect_times" => $red_time ?? "",
            "creat_time" => $cre_time ?? "",
            "last_time_use" => $last_t_u ?? "",
            "password" => $pw ?? "",
            "file_name" => $f_n ?? "",
            "extension" => $ex ?? "",
            "owner" => $id ?? ""

        ));
    }
    //==============================================================
    public function img_pw_verify(Request $request)
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Taipei'));
        $url = $request->hash;
        $find_url = DB::table('mapping')->where('redirect_url', $url)->first();

        if ($find_url->type === 'img' && $find_url->password  === $request->password) { // if is img and password correct
            $file_extension = $find_url->extension;
            $filename = $find_url->file_name . "." . $file_extension;
            $contents = Storage::get($filename);
            $base64_data = base64_encode($contents);
            $redis = Redis::connection();
            $redis->hincrby($url, 'redirect_times', 1);
            $redis->hmset($url, 'last_time_use', $date->format('Y-m-d H:i:s'));

            $tmp = array(
                "method" => "update_last_use",
                "url" => $url,
                'redirect_times' => $redis->hget($url, "redirect_times"),
                'last_time_use' => $date
            );
            $job = (new db_sync($tmp));
            $this->dispatch($job);

            return $base64_data;
        } else {
            return response('password error');
        }
    }
    public function redirect(Request $request)
    {

        $date = new DateTime("now", new DateTimeZone('Asia/Taipei'));
        $url = $request->hash;
        $find_url = DB::table('mapping')->where('redirect_url', $url)->first();
        if ($find_url != NULL) {
            $red_time = $find_url->redirect_times;
            $red_time++;
            if ($find_url->type === 'url') { // if is url 
                $find_url = DB::table('mapping')->where('redirect_url', $url)->first();
                $this->save_to_redis($find_url->redirect_url, $find_url->org_url, "url", "", $red_time, $date->format('Y-m-d H:i:s'), "", "", "", $find_url->owner_id);

                // DB::table('mapping')->where('redirect_url', $url)->update(
                //     ['redirect_times' => $red_time, 'last_time_use' => $date]
                // );
                $tmp = array(
                    "method" => "update_last_use",
                    "url" => $url,
                    'redirect_times' => $red_time,
                    'last_time_use' => $date
                );
                $job = (new db_sync($tmp));
                $this->dispatch($job);

                return redirect($find_url->org_url, 301
                    // , ['custom-header' => 'custom value']
                );
            } else if ($find_url->type === 'img' && is_null($find_url->password)) { //if is img and no password set
                $file_extension = $find_url->extension;
                $filename = $find_url->file_name . "." . $file_extension;
                $contents = Storage::get($filename);
                $base64_data = base64_encode($contents);
                $this->save_to_redis($find_url->redirect_url, $find_url->org_url, "img", "", $red_time, $date->format('Y-m-d H:i:s'), $find_url->password, $find_url->file_name, $find_url->extension, $find_url->owner_id);

                $tmp = array(
                    "method" => "update_last_use",
                    "url" => $url,
                    'redirect_times' => $red_time,
                    'last_time_use' => $date
                );
                $job = (new db_sync($tmp));
                $this->dispatch($job);

                return view(
                    'img_password',
                    [
                        'img_data' => $base64_data,
                        'summit_disyplay' => 'd-none',
                    ]
                )->render();
            } else if ($find_url->type === 'img') { //if is img and have to check password
                $this->save_to_redis($find_url->redirect_url, $find_url->org_url, "img", "", $red_time, $date->format('Y-m-d H:i:s'), $find_url->password, $find_url->file_name, $find_url->extension, $find_url->owner);

                $tmp = array(
                    "method" => "update_last_use",
                    "url" => $url,
                    'redirect_times' => $red_time,
                    'last_time_use' => $date
                );
                $job = (new db_sync($tmp));
                // $this->dispatch($job);

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
    public function creat_url(Request $request)
    {
        $val = $this->check_url($request);
        if (1 != $val) {
            return $val;
        }

        $date = new DateTime("now", new DateTimeZone('Asia/Taipei'));
        $org_url = $request->url;
        $to_hash = $org_url . "Sa1t" . bin2hex(random_bytes(6));
        $hash_url = sha1($to_hash);
        $hash_url = substr($hash_url, 0, 5);
        $this->save_to_redis($hash_url, $org_url, "url", $date->format('Y-m-d H:i:s'), 0, "", "", "", "", Auth::user()->id??"");

        $tmp = array(
            "method" => "insert-url",
            "hash" => $hash_url,
            "url" => $org_url,
            "type" => "url",
            "redirect_times" => 0,
            "creat_time" => $date->format('Y-m-d H:i:s'),
            "password" => "",
            "file_name" => "",
            "extension" => "",
            "owner" => Auth::user()->id??""
        );
        $job = (new db_sync($tmp));
        $this->dispatch($job);

        return (array('org' => urlencode($org_url), 'result' => $hash_url));
    }
    public function img_creat(Request $request)
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Taipei'));
        $val = $this->check_img_size_and_type_and_pw($request);
        if (1 != $val) {
            return $val;
        }
        $password = $request->password;
        $file_extension = $request->extension;
        $ranom_file_name = bin2hex(random_bytes(16));
        $ranom_file_name = substr($ranom_file_name, 0, 6);

        Storage::put($ranom_file_name . '.' . $file_extension, $request->file('file')->get());
        $this->save_to_redis($ranom_file_name, '', "img", $date->format('Y-m-d H:i:s'), 0, "", $password, $ranom_file_name, $file_extension, Auth::user()->id??"");
        $tmp = array(
            "method" => "insert-img",
            "hash" => $ranom_file_name,
            "url" => "",
            "type" => "img",
            "redirect_times" => 0,
            "creat_time" => $date->format('Y-m-d H:i:s'),
            "password" => $password,
            "file_name" => $ranom_file_name,
            "extension" => $file_extension,
            "owner" => Auth::user()->id??""
        );
        $job = (new db_sync($tmp));
        $this->dispatch($job);

        return (array('result' => $ranom_file_name));
    }
}
