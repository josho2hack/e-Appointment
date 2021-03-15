<?php

namespace App\Http\Controllers;

use App\Mail\Booking as MailBooking;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Booking;
use App\Models\CustomerOption;
use App\Models\Round;
use App\Models\Subject;
use App\Notifications\Booking as NotificationsBooking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role_id == 1) {
            $bookings = Booking::with(
                'appointment',
                'user',
                'employee',
                'round',
                'customerOption',
                'subjects'
            )->filter(\Illuminate\Support\Facades\Request::only('search'))->latest()->paginate();
        } else if (Auth::user()->role_id == 2 && Auth::user()->level < 4) {
            $bookings = Booking::with(
                'appointment',
                'user',
                'employee',
                'round',
                'customerOption',
                'subjects'
            )->filter(\Illuminate\Support\Facades\Request::only('search'))->whereHas('appointment', function ($query) {
                return $query->where('office_id', '=', Auth::user()->office_id);
            })->latest()->paginate();
        } else if (Auth::user()->role_id == 2 && Auth::user()->level >= 4) {
            $bookings = Booking::with(
                'appointment',
                'user',
                'employee',
                'round',
                'customerOption',
                'subjects'
            )->filter(\Illuminate\Support\Facades\Request::only('search'))->whereHas('employee', function ($query) {
                return $query->where('id', '=', Auth::user()->id);
            })->latest()->paginate();
        } else {
            $bookings = Booking::with(
                'appointment',
                'user',
                'employee',
                'round',
                'customerOption',
                'subjects'
            )->filter(\Illuminate\Support\Facades\Request::only('search'))->whereHas('user', function ($query) {
                return $query->where('id', '=', Auth::user()->id);
            })->latest()->paginate();
        }

        //dd($appointments);

        return Inertia::render('Booking/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search'),
            'bookings' => $bookings
        ]);
    }

    public function getAllDay($date)
    {
        $data = Booking::where('date', $date)->get();
        return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBooking(Appointment $appointment) //default create not send parameter GET	/bookings/create bookings.create
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
        $appointment = Appointment::with('customerOptions', 'subjects', 'rounds')->where('uuid', $uuid)->first();
        return Inertia::render('Booking/Guest', [
            'appointment' => $appointment,
            'rounds' => $appointment->rounds,
            'subjects' => $appointment->subjects,
            'customerOptions' => $appointment->customerOptions,
            'canLogin' => Route::has('login'),
            'canLoginEmployee' => Route::has('login.employee'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guestStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required',
            'email' => 'required',
            'detail' => 'required',
            'date' => 'required',
            'appointment_id' => 'required',
            'round_id' => 'required',
        ]);

        if ($request->nid) {
            $request->validate([
                'nid' => 'required|min:13',
            ]);
        }

        //dd($request->type);

        if ($request->type === null) {
            $app = Appointment::find($request->appointment_id);
            if ($app->pit || $app->cit) {
                return back()->with('error', 'ไม่พบหมายเลขผู้เสียภาษี');
            }
        }

        $booking = $request->all();
        unset($booking["subjects"]);
        unset($booking["worker"]);

        $bookings = Booking::where('date', '=', $request->date)->whereHas('round', function ($query) use ($request) {
            return $query->where('id', '=', $request->round_id);
        })->get();
        //dd(count($bookings));
        if ($request->worker <= count($bookings)) {
            return back()->with('error', 'รอบนัดหมายเต็ม โปรดเลือกรอบใหม่');
        }

        $result = Booking::create($booking);
        $result->subjects()->attach($request->subjects);
        //dd($result->id);
        Mail::to($result->email)->send(new MailBooking($result));
        return redirect()->route('index')->with('success', 'ระบบบันทึกข้อมูลการจองนัดหมายของท่านแล้ว โปรดตรวจสอบอีเมล์');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required',
            'email' => 'required',
            'detail' => 'required',
            'date' => 'required',
            'appointment_id' => 'required',
            'round_id' => 'required',
        ]);

        if ($request->nid) {
            $request->validate([
                'nid' => 'required|min:13',
            ]);
        }

        /*
        $booking = new Booking();
        $booking->nid = $request->nid;
        $booking->type = $request->type;
        $booking->name = $request->name;
        $booking->phone = $request->phone;
        $booking->email = $request->email;
        $booking->facebook = $request->facebook;
        $booking->line_id = $request->line_id;
        $booking->detail = $request->detail;
        $booking->date = $request->date;
        $booking->appointment_id = $request->appointment_id;
        $booking->round_id = $request->round_id;
        $booking->user_id = $request->user_id;
        $booking->customer_option_id = $request->customer_option_id;
        $booking->save();
        */

        if ($request->type === null) {
            $app = Appointment::find($request->appointment_id);
            if ($app->pit || $app->cit) {
                return back()->with('error', 'ไม่พบหมายเลขผู้เสียภาษี');
            }
        }

        $booking = $request->all();
        unset($booking["subjects"]);
        unset($booking["worker"]);

        $bookings = Booking::where('date', '=', $request->date)->whereHas('round', function ($query) use ($request) {
            return $query->where('id', '=', $request->round_id);
        })->get();
        //dd($request->worker,$request->round_id,count($bookings));
        if ($request->worker <= count($bookings)) {
            return back()->with('error', 'รอบนัดหมายเต็ม โปรดเลือกรอบใหม่');
        }

        $result = Booking::create($booking);
        $result->subjects()->attach($request->subjects);
        Auth::user()->notify(new NotificationsBooking($result));
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
        return Inertia::render('Booking/Show', [
            'appointment' => $booking->appointment,
            'round' => $booking->round,
            'subjects' => $booking->subjects,
            'customerOption' => $booking->customerOption,
            'employee' => $booking->employee,
            'booking' => $booking,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        if ((substr(Auth::user()->office->code, 5, 3) == '000' && Auth::user()->level == 3) || Auth::user()->level <= 2) {
            $response = Http::post(env('EOFFICE_EMP'), [
                'checkUser' => env('EOFFICE_CHKUSER'),
                'checkPass' => env('EOFFICE_CHKPASS'),
                'officeId' => Auth::user()->office->code,
            ]);
            $user = $response['DataUser']->json();
        }

        $user_filter = array_filter($user, function($v, $k) {
            return $k == 'EMPTYPE' || $v == 1;
        }, ARRAY_FILTER_USE_BOTH);
        dd($user);

        return Inertia::render('Booking/Edit', [
            'appointment' => $booking->appointment,
            'round' => $booking->round,
            'subjects' => $booking->subjects,
            'customerOption' => $booking->customerOption,
            'employee' => $booking->employee,
            'employees' => $user_filter,
            'booking' => $booking,
        ]);
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
        if ($request->employee) {
            $request->assign_user_id = Auth::user()->id;
        }

        $booking->update($request->all());
        return redirect()->route('bookings.index');
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
