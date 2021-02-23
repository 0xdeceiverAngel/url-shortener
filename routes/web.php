<?php
// use App\Http\Middleware\check_is_login; already set in kernel.php
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['g-recaptcha']], function () {
    Route::post('/api', 'url_mapping@creat_url');
    Route::post('/img_api', 'url_mapping@img_creat');
});
Route::group(['middleware' => ['check_is_login']], function () {
    Route::get('dashboard', 'LoginCon@dashboard');//find all save to redis
    Route::post('delete', 'url_manage@delete_url');
    Route::post('change_pw', 'url_manage@change_pw');
});

Route::get('/db1', function () {
    return DB::table('mapping')->get();
});
Route::get('/db2', function () {
    return DB::table('users')->get();
});
Route::get('/php', function () {
    return view('php');
});

Route::get('ajax-file-upload-progress-bar', 'ProgressBarUploadFileController@index');
Route::post('store', 'ProgressBarUploadFileController@store');



Route::post('login', 'LoginCon@login');
Route::post('register', 'LoginCon@register');
Route::get('logout', 'LoginCon@logout');
Route::get('/','LoginCon@index');
Route::get('/{hash}', 'url_mapping@redirect')->middleware('check_url_cache');
Route::post('/{hash}/verify', 'url_mapping@img_pw_verify');


