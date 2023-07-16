<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ExchangeRateController;
use App\Http\Controllers\Admin\GuidesController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Admin\TimetablesController;
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
        Route::get('/getTableReport',[\App\Http\Controllers\Home\HomeController::class,'getTableReport'])->name('admin.tableReport');

        //Logout Route
        Route::post('/logout',[\App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

        //Profile Routes
        Route::get('/my-profile/{id}',[\App\Http\Controllers\Admin\ProfileController::class,'myProfile'])->name('myProfile.show');
        Route::put('/update-info/{id}',[\App\Http\Controllers\Admin\ProfileController::class,'updateInfo'])->name('myProfile.update');
        Route::put('/update-password/{id}',[\App\Http\Controllers\Admin\ProfileController::class,'updatePassword'])->name('myProfile.password');
        Route::put('/update-avatars/{id}',[\App\Http\Controllers\Admin\ProfileController::class,'updateImage'])->name('myProfile.avatars');

        //Configurations Routes
        Route::get('/configurations',[\App\Http\Controllers\Admin\ConfigurationController::class,'index'])->name('configurations.index');
        Route::Post('/configurations/update',[\App\Http\Controllers\Admin\ConfigurationController::class,'update'])->name('configurations.update');

        //Calendar Routes
        Route::get('calendar',[\App\Http\Controllers\Admin\CalendarController::class,'show'])->name('calendar.show');
        Route::get('calendar/tours',[\App\Http\Controllers\Admin\CalendarController::class,'getTours'])->name('calendar.get');
        Route::get('calendar/tours/info/{id}',[\App\Http\Controllers\Admin\CalendarController::class,'getInfoTour'])->name('calendar.getInfo');

        //Booking
        Route::get('booking',[\App\Http\Controllers\Admin\BookingController::class,'index'])->name('booking.index');
        Route::Post('booking',[\App\Http\Controllers\Admin\BookingController::class,'getTour'])->name('booking.Tour');
        Route::Post('booking/availableSpace/',[\App\Http\Controllers\Admin\BookingController::class,'availableSpace'])->name('booking.availableSpace');
        Route::Post('booking/createClient/',[\App\Http\Controllers\Admin\BookingController::class,'createClient'])->name('booking.createClient');
        Route::Post('booking/Client/',[\App\Http\Controllers\Admin\BookingController::class,'getClient'])->name('booking.getClient');
        Route::Post('booking/tour/',[\App\Http\Controllers\Admin\BookingController::class,'booking'])->name('booking.tour');
        Route::get('booking/thanks/{id}',[\App\Http\Controllers\Admin\BookingController::class,'thanks'])->name('booking.thanks');

        //Exchange
        Route::post('/exchange-rate/search',[ExchangeRateController::class,'searchNewExchangeRate'])->name('exchange-rate.search');

        //Approvals
        Route::get('/approvals', [\App\Http\Controllers\Admin\ApprovalController::class, 'index'])->name('approvals.index');
        Route::post('/approvals', [\App\Http\Controllers\Admin\ApprovalController::class, 'store'])->name('approvals.store');
        Route::get('/approvals/create', [\App\Http\Controllers\Admin\ApprovalController::class, 'create'])->name('approvals.create');
        Route::post('/approvals/get-tour-values', [\App\Http\Controllers\Admin\ApprovalController::class, 'getTourSpacesValues'])->name('approvals.tour-values');
        Route::get('/approvals/{id}/edit', [\App\Http\Controllers\Admin\ApprovalController::class, 'edit'])->name('approvals.edit');
        Route::post('/approvals/{id}/update', [\App\Http\Controllers\Admin\ApprovalController::class, 'update'])->name('approvals.update');

        //Invoice
        Route::resource('invoice',InvoiceController::class)->only(["index","show", "destroy","edit","update"]);
        Route::get('invoice/{id}/mail',[InvoiceController::class,'showInvoice'])->name('invoice.show-invoice');
        Route::post('invoice/{id}/send',[InvoiceController::class,'sendInvoice'])->name('invoice.send-invoice');

        //Crud's Routes
        Route::resource('type-client',ClientTypeController::class);
        Route::resource('type-guides',TypesGuidesController::class);
        Route::resource('guides',GuidesController::class);
        Route::resource('clients',ClientController::class);
        Route::resource('tours',TourController::class);
        Route::resource('tour-state',TourStateController::class);
        Route::resource('tour-type',TourTypeController::class);
        Route::resource('users',UserController::class);
        Route::resource('timetable',TimetablesController::class);
        Route::resource('product',ProductController::class);
        Route::resource('product-type',ProductTypeController::class);
        Route::resource('tour-history',HistoryController::class)->only(["index","show"]);
        Route::resource('exchange-rate',ExchangeRateController::class)->only(["index"]);

        //Tour Options
        Route::Post('/tours/{id}/guide', [\App\Http\Controllers\Admin\TourOptionsController::class,'setTourGuide'])->name('tour.guide.create');
        Route::delete('/tours/{id}/guide',[\App\Http\Controllers\Admin\TourOptionsController::class,'deleteTourGuide'])->name('tour.guide.delete');
        Route::Post('/tours/{id}/guide/create',[\App\Http\Controllers\Admin\TourOptionsController::class,'createGuide'])->name('tour.guide.make');
        Route::Post('/tours/{id}/costumer/search',[\App\Http\Controllers\Admin\TourOptionsController::class,'searchCustomer'])->name('tour.costumer.search');
        Route::Post('/tours/{id}/costumer',[\App\Http\Controllers\Admin\TourOptionsController::class,'setClientTour'])->name('tour.costumer.create');
        Route::Post('/tours/{id}/costumer/create',[\App\Http\Controllers\Admin\TourOptionsController::class,'createClient'])->name('tour.costumer.make');
        Route::Post('/tours/{id}/set/costumer-guide',[\App\Http\Controllers\Admin\TourOptionsController::class,'setGuideToCustomer'])->name('tour.costumer.guide');
        Route::Post('/tours/costumer/valid-email',[\App\Http\Controllers\Admin\TourOptionsController::class,'validateCustomerEmail'])->name('tour.costumer.email');
        Route::Post('/tours/costumer/present',[\App\Http\Controllers\Admin\TourOptionsController::class,'presentCostumer'])->name('tour.costumer.present');

        //Custom Crud Routes
        Route::put('/users/admin-reset-password/{id}',[UserController::class,'adminResetPassword'])->name('users.admin-reset');
    }
);
