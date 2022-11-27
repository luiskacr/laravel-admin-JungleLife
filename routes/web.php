<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\GuidesController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TypesGuidesController;
use App\Http\Controllers\Admin\ClienteTypeController;
use Illuminate\Support\Facades\Route;

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

//Login & Auth Section
Route::group([
    'middleware'=>'guest',
    ],
    function(){
        Route::get('/',[\App\Http\Controllers\Auth\LoginController::class,'show'])->name('login');
        Route::get('/login',[\App\Http\Controllers\Auth\LoginController::class,'show']);
        Route::post('/login',[\App\Http\Controllers\Auth\LoginController::class,'login']);
    }
);


//Admin Section
Route::group([
    'prefix' => '/home',
    'middleware'=>'auth',
    'name' => 'admin.',
],
    function(){
        Route::get('/',[\App\Http\Controllers\Home\HomeController::class,'show'])->name('admin.home');
        Route::post('/logout',[\App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

        //Cruds
        Route::resource('type-client',ClienteTypeController::class);
        Route::resource('type-guides',TypesGuidesController::class);
        Route::resource('guides',GuidesController::class);
        Route::resource('clients',ClientController::class);
        Route::resource('tours',TourController::class);

    }
);


