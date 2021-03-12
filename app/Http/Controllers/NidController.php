<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NidController extends Controller
{
    public function getInfo($nid)
    {
        $response = Http::timeout(3)->withOptions([
            'proxy' => env('PROXY'),
            //'timeout' => 3 //second
        ])->get(env('NID_SERVICE') . $nid);

        dd(env('PROXY'),env('NID_SERVICE'));

        if ($response->serverError()) {
            return back()->withErrors("ไม่สามารถเชื่อมต่อระบบ NID");
        }

        $data = $response->json(['responseData','taxpayerNameInformation']);
        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }
}
