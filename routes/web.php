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

Auth::routes();

// Logged in routes
Route::group(['middleware' => 'web'], function ($router) {
    $router->get('/home', 'SpaController@index')->name('home');
    $router->get('users/current', 'UserController@current');

    $router->resource('posts', 'PostController');
});

Route::get('/{any}', 'SpaController@index')->where('any', '.*');
