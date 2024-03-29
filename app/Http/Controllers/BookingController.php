<?php

namespace App\Http\Controllers;

use App\Mail\Booking as MailBooking;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Booking;
use App\Models\CustomerOption;
use App\Models\Office;
use App\Models\Role;
use App\Models\Round;
use App\Models\Subject;
use App\Models\User;
use App\Notifications\Booking as NotificationsBooking;
use App\Notifications\Assignment as NotificationsAssignment;
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

    public function assign()
    {
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

        //dd($bookings);

        return Inertia::render('Booking/Assign', [
            'filters' => \Illuminate\Support\Facades\Request::all('search'),
            'bookings' => $bookings
        ]);
    }

    public function getAllDay($date)
    {
        $data = Booking::with('employee')->where('date', $date)->get();
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
                'officeId' => $booking->employee != null ? $booking->employee->office->code : $booking->appointment->office->code,
            ]);

            //dd($booking->employee,$booking->employee->office->code,$booking->appointment->office->code);

            $user = $response->json("DataUser");

            if ($booking->appointment->official && !$booking->appointment->employee) {
                $user_filter = array_filter($user, function ($obj) {
                    //dd($obj,$obj['EMPTYPE']);
                    if (isset($obj['EMPTYPE'])) {
                        if (Auth::user()->level == 3) {
                            if ($obj['EMPTYPE'] == '1' && $obj['LEVEL'] >= Auth::user()->level && $obj['GROUPNAME'] == Auth::user()->groupname) return true;
                        } else if (Auth::user()->level <= 2 || Auth::user()->office->code == '00013000') {
                            if ($obj['EMPTYPE'] == '1' && $obj['LEVEL'] >= Auth::user()->level) return true;
                        } else return false;
                    }
                });
            } else if (!$booking->appointment->official && $booking->appointment->employee) {
                $user_filter = array_filter($user, function ($obj) {
                    //dd($obj,$obj['EMPTYPE']);
                    if (isset($obj['EMPTYPE'])) {
                        if ($obj['EMPTYPE'] != '1') return true;
                        else return false;
                    }
                });
            } else {
                $user_filter = array_filter($user, function ($obj) {
                    //dd($obj,$obj['EMPTYPE']);
                    if (isset($obj['EMPTYPE'])) {
                        if (Auth::user()->level == 3) {
                            if ($obj['LEVEL'] >= Auth::user()->level) return true;
                        } else if (Auth::user()->level <= 2 || Auth::user()->office->code == '00013000') {
                            if ($obj['LEVEL'] >= Auth::user()->level) return true;
                        } else return false;
                    }
                });
            }
        }

        //dd($user, $user_filter);

        $offices = Office::where('code', 'like', '%000')->get();

        return Inertia::render('Booking/Edit', [
            'appointment' => $booking->appointment,
            'round' => $booking->round,
            'subjects' => $booking->subjects,
            'customerOption' => $booking->customerOption,
            'employee' => $booking->employee,
            'employees' => isset($user_filter) ? $user_filter : "",
            'booking' => $booking,
            'office' => $booking->employee ? $booking->employee->office : $booking->appointment->office,
            'offices' => $offices,
        ]);
    }

    public function editOffice(Booking $booking,Office $office)
    {
        if ((substr(Auth::user()->office->code, 5, 3) == '000' && Auth::user()->level == 3) || Auth::user()->level <= 2) {
            $response = Http::post(env('EOFFICE_EMP'), [
                'checkUser' => env('EOFFICE_CHKUSER'),
                'checkPass' => env('EOFFICE_CHKPASS'),
                'officeId' => $office->code,
            ]);
            $user = $response->json("DataUser");

            //dd($user);
            //dd($booking);
            $appointment = Appointment::where('id',$booking->appointment_id)->first();

            if ($appointment->official && !$appointment->employee) {
                $user_filter = array_filter($user, function ($obj) {
                    //dd($obj,$obj['EMPTYPE']);
                    if (isset($obj['EMPTYPE'])) {
                        if (Auth::user()->level == 3) {
                            if ($obj['EMPTYPE'] == '1' && $obj['LEVEL'] >= Auth::user()->level) return true;
                        } else if (Auth::user()->level <= 2 || Auth::user()->office->code == '00013000') {
                            if ($obj['EMPTYPE'] == '1' && $obj['LEVEL'] >= Auth::user()->level) return true;
                        } else return false;
                    }
                });
            } else if (!$appointment->official && $appointment->employee) {
                $user_filter = array_filter($user, function ($obj) {
                    //dd($obj,$obj['EMPTYPE']);
                    if (isset($obj['EMPTYPE'])) {
                        if ($obj['EMPTYPE'] != '1') return true;
                        else return false;
                    }
                });
            } else {
                $user_filter = array_filter($user, function ($obj) {
                    //dd($obj,$obj['EMPTYPE']);
                    if (isset($obj['EMPTYPE'])) {
                        if (Auth::user()->level == 3) {
                            if ($obj['LEVEL'] >= Auth::user()->level) return true;
                        } else if (Auth::user()->level <= 2 || Auth::user()->office->code == '00013000') {
                            if ($obj['LEVEL'] >= Auth::user()->level) return true;
                        } else return false;
                    }
                });
            }
        }

        $employees = isset($user_filter) ? $user_filter : "";
        //dd($employees);
        return response()->json($employees, 200, []);
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
        //dd($request['employee']['lsk'], $request['lsk_old']);
        if ($request['employee']['lsk'] != $request['lsk_old']) {
            $request['assign_user_id'] = Auth::user()->id;
            $request['status'] = 0;

            $user = User::where('lsk', $request['employee']['lsk'])->first();

            if (!$user) {
                $role = Role::where('name', 'employee')->first();
                $user = new User();
                $user->role_id = $role->id;
            }

            $user->title = $request['employee']['title'];
            $user->first_name = $request['employee']['first_name'];
            $user->last_name = $request['employee']['last_name'];
            $user->email = $request['employee']['email'];
            $user->lsk = $request['employee']['lsk'];
            $user->uid = $request['employee']['uid'];
            $user->position = $request['employee']['position'];
            $user->class = $request['employee']['class'];
            $user->position_action = $request['employee']['position_action'];
            $user->groupname = $request['employee']['groupname'];
            $user->level = $request['employee']['level'];
            $user->employee_type = $request['employee']['employee_type'];
            $user->office_id = $request['employee']['office_id'];
            $user->save();

            $request['employee_id'] = $user->id;
        }
        //dd($request->all(),$user);

        $temp = $request->all();
        unset($request["employee"]);
        unset($request["lsk_old"]);
        unset($request["meeting_old"]);

        $booking->update($request->all());

        if ($temp['meeting_old'] != $temp['meeting_online']) {
            Mail::to($booking->email)->send(new MailBooking($booking));
        }
        if ($temp['lsk_old'] != $temp['employee']['lsk']) {
            Mail::to($booking->email)->send(new MailBooking($booking));
            $user->notify(new NotificationsAssignment($booking));
        }
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
