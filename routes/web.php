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
Route::post('/api', 'url_mapping@creat_url')->Middleware('g-recaptcha')->Middleware('check_is_login');
Route::post('/img_api', 'url_mapping@img_creat')->Middleware('g-recaptcha')->Middleware('check_is_login');
Route::get('/db1', function () {
    return DB::table('mapping')->get();
});
Route::get('/db2', function () {
    return DB::table('users')->get();
});
Route::get('/img', function () {
    return view('img_password');
});

Route::post('delete','url_manage@delete_url')->Middleware('check_is_login');
Route::post('login', 'LoginCon@login');
Route::post('register', 'LoginCon@register');
Route::get('logout', 'LoginCon@logout');
Route::get('dashboard', 'LoginCon@dashboard')->Middleware('check_is_login');
Route::get('/','LoginCon@home')->Middleware('check_is_login');
Route::get('/{url}', 'url_mapping@redirect');
Route::post('/{url}', 'url_mapping@redirect');
