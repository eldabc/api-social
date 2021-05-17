<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
    Route::group(['middleware' => ['role:Administrador|Oficina']], function () {

        // Products
        Route::post('/products',     'Api\ProductController@store');
        Route::put('/products/{id}', 'Api\ProductController@update');
        Route::delete('/products/{id}', 'Api\ProductController@destroy');

        // Directory
        Route::post('/directory', 'Api\DirectoryController@store');  
        Route::put('/directory/{id}', 'Api\DirectoryController@update');
        Route::delete('/directory/{id}', 'Api\DirectoryController@destroy');
    });
    
    Route::group(['middleware' => ['role:Administrador']], function () {

        // Users
        Route::get('/users', 'Api\AuthController@index');
        Route::delete('/users/{id}', 'Api\AuthController@destroy');
    });

    Route::group(['middleware' => ['role:Personal']], function () {
        Route::put('/update-create-score',  'Api\ScoreController@updateCreateScore');
    });

    Route::group(['middleware' => ['role:Administrador|Oficina|Personal']], function () {
        
        // Products
        Route::get('/products', 'Api\ProductController@index');
        Route::get('/products/{id}', 'Api\ProductController@show');
        // Users
        Route::get('/users/{id}', 'Api\AuthController@show');
        Route::put('/users/{id}', 'Api\AuthController@update');
        // Directory
        Route::get('/directory', 'Api\DirectoryController@index');
        Route::get('/directory/{id}', 'Api\DirectoryController@show');
        
    });
    
    Route::put('/forgot-password', 'Api\AuthController@emailChangePassword');
    Route::put('/change-password', 'Api\AuthController@changePassword');


    // Any user
    Route::post('/users', 'Api\AuthController@store');
    Route::post('/login', 'Api\AuthController@login');