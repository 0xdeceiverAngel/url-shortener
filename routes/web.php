<?php

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

Route::get('/', function () {
    // return view('welcome');
    return view('home');
});
Route::get('/{url}', 'url_mapping@redirect');

// Route::get('/api/{url}', 'url_mapping@is_in_db');

// Route::get('foo', function () {
//     // return Redirect::to('/a', 301);
//     return redirect('https://google.com', 301, [
//         'custom-header' => 'custom value'
//     ]);
// });

Route::post('/api', 'url_mapping@creat');


// Route::get('/r', function () {

//     $array = array('foo' => 'aa', 'a' => 'bar');

//     // 返回的就是 json 响应
//     return $array;
// });



// Route::get('/a', function () {

//     $user = DB::table('tab')->get();
//     echo $user;
// });
// // sudo apt install php-pgsql
// Route::get('/in', function () {
//     DB::insert('insert into tab(a) values(?)', ['44']);
// });