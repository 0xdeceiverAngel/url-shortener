<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use DB;
use Illuminate\Support\Facades\URL;
use Validator;

class uploadfileController extends Controller
{
    
 
    public function store(Request $request)
    {
        $validator = Validator::make($request->file, [
            'file' => 'required|max:10240',
        ]);
        if (!$validator->passes()) {
            return response(array('result' => 'file too large'));

        }
 
        $ranom_file_name = bin2hex(random_bytes(16));
        $ranom_file_name = substr($ranom_file_name, 0, 6);
        Storage::put($ranom_file_name, $request->file('file')->get());
        $url= URL::temporarySignedRoute(
            'download',
            now()->addMinutes(10),
            ['ranom_file_name' => $ranom_file_name]
        );
        return response(array('result'=>$url));
    }
    public function download(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        ;
        return Storage::download($request->ranom_file_name);
    }
}
