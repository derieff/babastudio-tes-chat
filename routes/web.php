<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'ViewController@welcome');

Route::get('form-login', 'ViewController@login');
Route::get('form-register', 'ViewController@register');

Route::post('process-login', 'ProcessController@login_process');

Route::post('process-register', 'ProcessController@register_process');

Route::get('logout', 'ProcessController@logout_process');