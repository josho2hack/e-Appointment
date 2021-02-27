<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\CustomerOption;
use App\Models\Round;
use App\Models\Subject;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Str;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role_id == 1) {
            $appointments = Appointment::with('office')->filter(Request::only('search'))->paginate();
        } else if (Auth::user()->role_id == 2) {
            $appointments = Appointment::with('office')->where('office_id', Auth::user()->office_id)->paginate();
        } else {
            $appointments = Appointment::with('office')->where('public', true)->paginate();
        }

        //dd($appointments);

        return Inertia::render('Appointment/Index', [
            'filters' => Request::all('search'),
            'appointments' => $appointments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Appointment/Create');
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
            'name' => 'required|unique:appointments|max:255',
            'pit' => 'required',
            'cit' => 'required',
            'worker' => 'required|min:1',
            'official' => 'required',
            'employee' => 'required',
            'mon' => 'required',
            'tue' => 'required',
            'wed' => 'required',
            'thu' => 'required',
            'fri' => 'required',
        ]);

        $request['uuid'] = (string) Str::orderedUuid();
        $request['office_id'] = Auth::user()->office_id;
        $request['user_id'] = Auth::user()->id;

        $appointment = Appointment::create($request->all());

        return redirect()->route('appointments.edit', $appointment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        return Inertia::render('Appointment/Show', [
            'appointments' => $appointment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        $data = Appointment::with('customerOptions', 'subjects', 'rounds')
            ->where('id', $appointment->id)
            ->get();
        return Inertia::render('Appointment/Edit', [
            'appointment' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'name' => 'required|unique:appointments|max:255',
            'pit' => 'required',
            'cit' => 'required',
            'worker' => 'required|min:1',
            'official' => 'required',
            'employee' => 'required',
            'mon' => 'required',
            'tue' => 'required',
            'wed' => 'required',
            'thu' => 'required',
            'fri' => 'required',
            'public' => 'required',
        ]);

        if ($request->public) {
            $request['public_user_id'] = Auth::user()->id;
        }

        $appointment->update($request->all());

        return Inertia::render('Appointment/Index');
    }

    public function public(Request $request, Appointment $appointment)
    {
        $request['public'] = !$appointment->public;
        $request['public_user_id'] = Auth::user()->id;

        $appointment->update($request->all());

        return Inertia::render('Appointment/Index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return Inertia::render('Appointment/Index');
    }
}
