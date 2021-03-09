<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/nid/{nid}', function ($nid) {
    $response = Http::timeout(3)->withOptions([
        'proxy' => 'http://192.168.61.26:3128',
        //'timeout' => 3 //second
    ])->get('http://192.168.41.110:8080/tinws/getTaxpayerInfo/nid/' . $nid)->name('api.nid');
    //dd($response);

    if ($response->serverError()) {
        return back()->withErrors("ไม่สามารถเชื่อมต่อระบบ NID");
    }

    $data = $response->json();
    return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
});
