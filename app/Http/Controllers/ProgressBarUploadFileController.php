<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use DB;
class ProgressBarUploadFileController extends Controller
{
    //
    public function index()
    {
        return view('progress-bar-file-upload');
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);
 
        $ranom_file_name = bin2hex(random_bytes(16));
        $ranom_file_name = substr($ranom_file_name, 0, 6);
        Storage::put($ranom_file_name, $request->file('file')->get());
        $url = Storage::url($ranom_file_name);
        return response()->json(['success'=>$url]);
    }
}
