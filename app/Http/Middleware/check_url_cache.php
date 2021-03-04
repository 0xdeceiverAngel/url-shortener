<?php

namespace App\Http\Middleware;

use Closure;
use Redis;
use Storage;
use DateTime;
use DateTimeZone;
use view;
use App\Jobs\db_sync;
// use ProcessPodcast;
use Illuminate\Bus\Dispatcher;

class check_url_cache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function update($hash, $date)
    {
        $redis = Redis::connection();
        $redis->hincrby($hash, 'redirect_times', 1);
        $redis->hmset($hash, 'last_time_use', $date);
        $tmp = array(
            "method" => "update_last_use",
            "url" => $hash,
            'redirect_times' => $redis->hget($hash, "redirect_times"),
            'last_time_use' => $date
        );
        $job = (new db_sync($tmp));
        dispatch($job);
    }
    public function handle($request, Closure $next)
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Taipei'));
        $redis = Redis::connection();
        $res = $redis->hgetall($request->hash);
        // return response($res["password"]);
        if (count($res)) {

            if ($res["type"] == "url") {
                $this->update($request->hash, $date->format('Y-m-d H:i:s'));
                return redirect($res["url"], 301);
            }

            if ($res["type"] == 'img' && ($res["password"] != NULL)) {
                // $this->update($request->hash, $date->format('Y-m-d H:i:s'));
                return response(view(
                    'img_password',
                    [
                        'summit_disyplay' => 'input password',
                        'img_display'=>'d-none'
                    ]
                ));
            }

            if ($res["type"] == 'img') {
                $filename = $res["file_name"] . "." . $res["extension"];
                $contents = Storage::get($filename);
                $base64_data = base64_encode($contents);
                $this->update($request->hash, $date->format('Y-m-d H:i:s'));
                return response(view(
                    'img_password',
                    [
                        'img_data' => $base64_data,
                        'summit_disyplay' => 'd-none',
                    ]
                ));
            }
            
                
        }
        return $next($request);
    }
}
