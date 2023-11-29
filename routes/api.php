<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::post('auth/login', 'Auth\LoginController@index');
Route::middleware('auth:sanctum')->group(function (){
    Route::group(['namespace' => 'Post', 'prefix' => 'post'], function (){
        Route::get('gets','PostController@getPosts');
        Route::get('get/{id}','PostController@getPost');
        Route::post('add','PostController@addPost');
    }) ;
});
