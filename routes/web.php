<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerOptionController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\NidController;
use App\Http\Controllers\OfficeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//------------------Blade Components--------------------------
/*
Route::view('/', 'welcome');
Route::get('/lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

*/
//------------------End Blade Components--------------------------

//------------------Inertia Vue-------------------------------
Route::get('/', [WelcomeController::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/booking/{date}', [BookingController::class, 'getAllDay'])->name('bookingAllDay');
Route::get('/guest/{uuid}', [BookingController::class, 'guest'])->name('guest');
Route::post('/guest', [BookingController::class, 'guestStore'])->name('guest.store');

Route::get('/nid/{nid}', [NidController::class, 'getInfo'])->name('nid');
Route::get('/holiday/{date}', [HolidayController::class, 'getInfo'])->name('holiday.getInfo');
Route::get('/booking/{booking}/{office}', [BookingController::class, 'editOffice'])->name('booking.editOffice');

require __DIR__ . '/auth.php';

Route::get('/language/{language}', function ($language) {
    Session()->put('locale', $language);

    return redirect()->back();
})->name('language');

Route::middleware('auth')->group(function () {
    Route::resource('appointments', AppointmentController::class);
    Route::put('public/{appointment}', [AppointmentController::class, 'public'])->name('public');
    Route::resource('rounds', RoundController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('customerOptions', CustomerOptionController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('offices', OfficeController::class);
    Route::get('/booking-create/{appointment}', [BookingController::class, 'createBooking'])->name('booking.create');
    Route::get('/booking/assign', [BookingController::class, 'assign'])->name('booking.assignment');

    Route::get('/assignment', function () {
        return view('assignment');
    })->name('assignment');

    Route::get('/report', function () {
        //return view('report');
        $url = 'https://interapp2.rd.go.th/e-app-graph';
        return Inertia::location($url);
    })->name('report');

});
