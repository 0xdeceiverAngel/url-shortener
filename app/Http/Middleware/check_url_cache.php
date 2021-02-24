<?php

namespace App\Http\Middleware;

use Closure;
use Redis;
use Storage;
use DateTime;
use DateTimeZone;
class check_url_cache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function update($hash,$date)
    {
        $redis = Redis::connection();
        $redis->hincrby($hash, 'redirect_times',1);
        $redis->hmset($hash, 'last_time_use',$date);

    }
    public function handle($request, Closure $next)
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Taipei'));
        $redis = Redis::connection();
        $res=$redis->hgetall($request->hash);
        if($res!=NULL)
        {
            if ($res["type"] == "url") {
                $this->update($request->hash, $date->format('Y-m-d H:i:s'));
                return redirect($res["url"], 301);
            }

            // if ($res["type"] == 'img' && is_null($res["password"])) {
            //     $filename = $res["file_name"] . "." . $res["file_extension"];
            //     $contents = Storage::get($filename);
            //     $base64_data = base64_encode($contents);
            //     $this->update($request->hash, $date->format('Y-m-d H:i:s'));
            //     return view(
            //         'img_password',
            //         [
            //             'img_data' => $base64_data,
            //             'summit_disyplay' => 'd-none',
            //         ]
            //     )->render();
            // }

            // if ($res["type"] == 'img') {
            //     $this->update($request->hash, $date->format('Y-m-d H:i:s'));
            //     return view(
            //         'img_password',
            //         [
            //             'summit_disyplay' => 'input password',
            //         ]
            //     )->render();
            // }
        }
       
        return $next($request);
    }
}
