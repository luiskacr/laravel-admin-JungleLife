<?php

use App\Http\Controllers\Api\v1\BookingController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\TourController;
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


//Admin Section
Route::group([
    'prefix' => '/v1',
    'middleware'=>['auth:sanctum','throttle:api'],

],
    function(){

        Route::get('/ping',function (Request $request){
            return response()->json(['message'=> 'pong']);
        });

        Route::get('tours/all',[TourController::class, 'getAll']);
        Route::get('tours/range',[TourController::class, 'getAllRangeTours']);
        Route::get('tours/{id}',[TourController::class, 'show']);

        Route::get('products/all',[ProductController::class, 'getAll']);
        Route::get('products/{id}',[ProductController::class, 'show']);
        Route::post('booking/',[BookingController::class, 'booking']);
    }
);
