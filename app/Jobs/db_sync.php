<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use DB;

class db_sync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;
    // public function __construct()
    public function __construct(array $data)
    {
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        if ($data["method"] == "insert-url") {
            DB::table('mapping')->insert(
                [
                    'org_url' => $data["url"],
                    'redirect_url' => $data["hash"],
                    'type' => 'url',
                    "redirect_times" => 0,
                    'creat_time' => $data["creat_time"],
                    'owner' => $data["owner"]
                ]
            );
        }
        if ($data["method"] == "insert-img") {
            DB::table('mapping')->insert(
                [
                    'file_name' => $data["file_name"],
                    'redirect_url' => $data["file_name"],
                    'extension' => $data["extension"],
                    'password' => $data["password"] ?? "",
                    'type' => 'img',
                    "redirect_times" => 0,
                    'creat_time' => $data["creat_time"],
                    'owner' => $data["owner"]
                ]
            );
        }
        if ($data["method"] == "update_last_use") {
            DB::table('mapping')->where('redirect_url', $data["url"])->update(
                ['redirect_times' => $data["redirect_times"], 'last_time_use' => $data["last_time_use"]]
            );
        }
        if ($data["method"] == "del_url") {
            DB::table('mapping')->where('redirect_url', $data["url"])->delete();

        }
        if ($data["method"] == "change_pw") {
            DB::table('mapping')->where('redirect_url', $data["url"])->update(
                ['password' => $data["pw"]]
            );
        }
    }
}
