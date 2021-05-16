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
    Route::group(['middleware' => ['role:Administrador']], function () {

        // Admin routes
        Route::get('/list-distri-client/{paginate}', 'Api\AdminController@listDistriClient');
        Route::get('/detail-distri-client/{id}', 'Api\AdminController@detailDistriClient');
        Route::get('/change-status-product/{product_id}/{status_id}', 'Api\AdminController@changeStatusProduct');
        // Products
        Route::post('/products',     'Api\ProductController@store');
        Route::put('/products/{id}', 'Api\ProductController@update');
        // User
        Route::get('/users', 'Api\AuthController@index');
        Route::delete('/users/{id}', 'Api\AuthController@destroy');

        Route::delete('/products/{id}', 'Api\ProductController@destroy');

    });

    Route::group(['middleware' => ['role:Distribuidor']], function () {
        Route::put('/update-resale-data', 'Api\ProductController@updateResaleData');
        Route::put('/delete-product-resale/{id}', 'Api\ProductController@deleteProductResale');
    });

    Route::group(['middleware' => ['role:Cliente|Distribuidor']], function () {
        Route::put('/update-create-score',  'Api\ScoreController@updateCreateScore');
    });

    Route::group(['middleware' => ['role:Administrador|Oficina|Personal']], function () {
        
        // Products
        Route::get('/products', 'Api\ProductController@index');
        Route::get('/products/{id}', 'Api\ProductController@show');
        // Users
        Route::get('/users/{id}', 'Api\AuthController@show');
        Route::put('/users/{id}', 'Api\AuthController@update');
        
    });
    
    Route::put('/forgot-password', 'Api\AuthController@emailChangePassword');
    Route::put('/change-password', 'Api\AuthController@changePassword');


    // Any user
    Route::post('/users', 'Api\AuthController@store');
    Route::post('/login', 'Api\AuthController@login');
