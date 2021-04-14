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

    });


    Route::group(['middleware' => ['role:Distribuidor']], function () {
    
        Route::apiResources([
            'users' => Api\AuthController::class,
        ]);
    });

    Route::group(['middleware' => ['role:Cliente']], function () {
    
    });

    Route::group(['middleware' => ['role:Administrador|Cliente|Distribuidor']], function () {
        
        Route::put('/change-password', 'Api\AuthController@changePassword');
        
    });
    
    

    Route::post('/login', 'Api\AuthController@login');

    Route::apiResource('/products', 'Api\ProductController');
    Route::put('/update-resale-data', 'Api\ProductController@updateResaleData');
    Route::apiResource('/orders', 'Api\OrderController');