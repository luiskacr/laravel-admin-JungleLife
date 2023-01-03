<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\GuidesController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TypesGuidesController;
use App\Http\Controllers\Admin\ClientTypeController;
use App\Http\Controllers\Admin\TourStateController;
use App\Http\Controllers\Admin\TourTypeController;
use App\Http\Controllers\Admin\UserController;
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
        //Login Routes
        Route::get('/',[\App\Http\Controllers\Auth\LoginController::class,'show'])->name('login');
        Route::post('/login',[\App\Http\Controllers\Auth\LoginController::class,'login'])->name('login.post');

        //Password Reset Routes
        Route::get('password/reset',[\App\Http\Controllers\Auth\ResetPasswordController::class,'show'])->name('password.request');
        Route::post('password/email',[\App\Http\Controllers\Auth\ResetPasswordController::class,'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}',[\App\Http\Controllers\Auth\ResetPasswordController::class,'showReset'])->name('password.reset');
        Route::post('password/reset',[\App\Http\Controllers\Auth\ResetPasswordController::class,'resetPassword']);

        //New User Password Create
        Route::get('password/new-user/{token}',[\App\Http\Controllers\Auth\NewUserController::class,'show'])->name('password.new-user');
        Route::post('password/new-user/',[\App\Http\Controllers\Auth\NewUserController::class,'resetPassword'])->name('password.new-user.reset');
    }
);

//Admin Section
Route::group([
    'prefix' => '/home',
    'middleware'=>'auth',
    'name' => 'admin.',
],
    function(){
        //Home Route
        Route::get('/',[\App\Http\Controllers\Home\HomeController::class,'show'])->name('admin.home');
        //Logout Route
        Route::post('/logout',[\App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

        //Profile Routes
        Route::get('/my-profile/{id}',[\App\Http\Controllers\Admin\ProfileController::class,'myProfile'])->name('myProfile.show');
        Route::put('/update-info/{id}',[\App\Http\Controllers\Admin\ProfileController::class,'updateInfo'])->name('myProfile.update');
        Route::put('/update-password/{id}',[\App\Http\Controllers\Admin\ProfileController::class,'updatePassword'])->name('myProfile.password');
        Route::put('/update-avatars/{id}',[\App\Http\Controllers\Admin\ProfileController::class,'updateImage'])->name('myProfile.avatars');

        //Crud's Routes
        Route::resource('type-client',ClientTypeController::class);
        Route::resource('type-guides',TypesGuidesController::class);
        Route::resource('guides',GuidesController::class);
        Route::resource('clients',ClientController::class);
        Route::resource('tours',TourController::class);
        Route::resource('tour-state',TourStateController::class);
        Route::resource('tour-type',TourTypeController::class);
        Route::resource('users',UserController::class);

        //Custom Crud Routes
        Route::put('/users/admin-reset-password/{id}',[UserController::class,'adminResetPassword'])->name('users.admin-reset');
    }
);


