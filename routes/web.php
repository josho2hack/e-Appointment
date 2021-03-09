<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerOptionController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\SubjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

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
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canLoginEmployee' => Route::has('login.employee'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//------------------End Inertia Vue---------------------------

require __DIR__ . '/auth.php';

Route::get('/language/{language}', function ($language) {
    Session()->put('locale', $language);

    return redirect()->back();
})->name('language');

Route::middleware('auth')->group(function () {
    Route::resource('appointments', AppointmentController::class);
    Route::put('/public/{appointment}', [AppointmentController::class, 'public'])->name('public');
    Route::resource('rounds', RoundController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('customerOptions', CustomerOptionController::class);
    Route::resource('bookings', BookingController::class);
    Route::get('/create-booking/{appointment}', [BookingController::class, 'createBooking'])->name('booking.create');

    Route::get('/assignment', function () {
        return view('assignment');
    })->name('assignment');

    Route::get('/report', function () {
        return view('report');
    })->name('report');

});

Route::get('/guest/{uuid}', [BookingController::class, 'guest'])->name('guest');
Route::post('/guest', [BookingController::class, 'guestStore'])->name('guestStore');

Route::get('/nid/{nid}', function ($nid) {
    $response = Http::timeout(3)->withOptions([
        'proxy' => 'http://192.168.61.26:3128',
        //'timeout' => 3 //second
    ])->get('http://192.168.41.110:8080/tinws/getTaxpayerInfo/nid/' . $nid);
    //dd($response);

    if ($response->serverError()) {
        return back()->withErrors("ไม่สามารถเชื่อมต่อระบบ NID");
    }

    $data = $response->json();
    return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
})->name('nid');
