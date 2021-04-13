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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResources([
    'users' => Api\AuthController::class,
]);

Route::post('/login', 'Api\AuthController@login');
Route::put('/change-password', 'Api\AuthController@changePassword');


    Route::apiResource('/products', 'Api\ProductController');
    Route::put('/update-resale-data', 'Api\ProductController@updateResaleData');
    Route::apiResource('/orders', 'Api\OrderController');

    // Route::group(['middleware' => 'can:detail-distri-client'], function () {
    // Route::group(['middleware' => ['role:Cliente']], function () {
    
        // Admin routes
        Route::get('/list-distri-client', 'Api\AdminController@listDistriClient');
        Route::get('/detail-distri-client/{id}', 'Api\AdminController@detailDistriClient');
        Route::get('/list-orders-by-role/{role_id}', 'Api\AdminController@listOrdersByRole');
        Route::get('/change-status-order/{order_id}/{status_id}', 'Api\AdminController@changeStatusOrder');
        Route::get('/change-status-product/{product_id}/{status_id}', 'Api\AdminController@changeStatusProduct');
    
    // });