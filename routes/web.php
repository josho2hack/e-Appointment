<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Laravel\Socialite\Facades\Socialite;

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

Route::view('/', 'welcome');

Route::get('/lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/assignment', function () {
    return view('assignment');
})->middleware(['auth'])->name('assignment');

Route::get('/report', function () {
    return view('report');
})->middleware(['auth'])->name('report');

Route::get('/appointment', function () {
    return view('appointment');
})->middleware(['auth'])->name('appointment');

Route::get('/booking', function () {
    return view('booking');
})->middleware(['auth'])->name('booking');

require __DIR__ . '/auth.php';
