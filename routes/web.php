<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BookingController;
use Illuminate\Foundation\Application;
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
    Route::post('/public', [AppointmentController::class, 'public'])->name('public');

    Route::resource('bookings', BookingController::class);

    Route::get('/assignment', function () {
        return view('assignment');
    })->name('assignment');

    Route::get('/report', function () {
        return view('report');
    })->name('report');

});

Route::get('/guest/{uuid}', function () {
    return view('appointment/index');
})->name('guest');
