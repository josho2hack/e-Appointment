<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Booking;
use App\Models\CustomerOption;
use App\Models\Round;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::with('round')->get();
        return Inertia::render('Booking/Index', [
            'bookings' => $bookings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBooking(Appointment $appointment)
    {
        $rounds = Round::where('appointment_id', $appointment->id)->get();
        $subjects = Subject::where('appointment_id', $appointment->id)->get();
        $customerOptions = CustomerOption::where('appointment_id', $appointment->id)->get();
        return Inertia::render('Booking/Create', [
            'appointment' => $appointment,
            'rounds' => $rounds,
            'subjects' => $subjects,
            'customerOptions' => $customerOptions
        ]);
    }

    public function guest($uuid)
    {
        $appointment = Appointment::with('customerOptions', 'subjects', 'rounds')->where('uuid', $uuid)->get();
        return Inertia::render('Booking/Guest', [
            'appointment' => $appointment
        ]);
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
            //'name' => 'required|max:255',
            //'phone' => 'required',
            //'email' => 'required',
            //'detail' => 'required',
            //'date' => 'required',
            //'appointment_id' => 'required',
        ]);

        if ($request->nid) {
            $request->validate([
                'nid' => 'required|min:13',
            ]);
        }

        dd($request->all());

        Booking::create($request->all());

        return redirect()->route('bookings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
