<?php

namespace App\Http\Controllers;

use App\Models\CustomerOption;
use Illuminate\Http\Request;

class CustomerOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'require_pin' => 'required',
            'appointment_id' => 'required',
        ]);

        CustomerOption::create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerOption  $customerOption
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerOption $customerOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerOption  $customerOption
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerOption $customerOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerOption  $customerOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerOption $customerOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerOption  $customerOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerOption $customerOption)
    {
        $customerOption->delete();

        return back();
    }
}
