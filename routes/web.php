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

Route::get('/', function () {
    return view('welcome');
});

Route::get('imagick', 'IMagickController@index');

Route::get('dart', 'DartController@index');
Route::get('dart/{key}', 'DartController@show');
Route::post('dart/sync', 'DartController@sync');
