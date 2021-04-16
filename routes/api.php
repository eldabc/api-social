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
        Route::get('/list-distri-client', 'Api\AdminController@listDistriClient');
        Route::get('/detail-distri-client/{id}/{paginate}', 'Api\AdminController@detailDistriClient');
        Route::get('/list-orders-by-role/{role_id}', 'Api\AdminController@listOrdersByRole');
        Route::get('/change-status-order/{order_id}/{status_id}', 'Api\AdminController@changeStatusOrder');
        Route::get('/change-status-product/{product_id}/{status_id}', 'Api\AdminController@changeStatusProduct');
        // Products
        Route::post('/products', 'Api\ProductController@store');
        Route::put('/products/{id}', 'Api\ProductController@update');
        // User
        Route::get('/users', 'Api\AuthController@index');
        Route::delete('/users/{id}', 'Api\AuthController@destroy');
        // Orders
        Route::put('/orders/{id}', 'Api\OrderController@update');
        Route::delete('/products/{id}', 'Api\ProductController@destroy');

    });

    Route::group(['middleware' => ['role:Distribuidor']], function () {
        Route::put('/update-resale-data', 'Api\ProductController@updateResaleData');
        Route::put('/delete-product-resale/{id}', 'Api\ProductController@deleteProductResale');
    });

    Route::group(['middleware' => ['role:Administrador|Distribuidor']], function () {
        Route::delete('/orders/{id}', 'Api\OrderController@destroy');
    });

    Route::group(['middleware' => ['role:Cliente|Distribuidor']], function () {
        Route::post('/orders', 'Api\OrderController@store');
    });

    Route::group(['middleware' => ['role:Administrador|Cliente|Distribuidor']], function () {
        
        // Products
        Route::get('/products', 'Api\ProductController@index');
        Route::get('/products/{id}', 'Api\ProductController@show');
        // Users
        Route::get('/users/{id}', 'Api\AuthController@show');
        Route::put('/users/{id}', 'Api\AuthController@update');
        Route::put('/change-password', 'Api\AuthController@changePassword');
        // Orders
        Route::get('/orders', 'Api\OrderController@index');
        Route::get('/orders/{id}', 'Api\OrderController@show');
        
    });
    
    // Any user
    Route::post('/users', 'Api\AuthController@store');
    Route::post('/login', 'Api\AuthController@login');

    // Route::apiResource('/orders', 'Api\OrderController');
    // Route::apiResources([ 'users' => Api\AuthController::class, ]);
    // Route::apiResource('/products', 'Api\ProductController');
