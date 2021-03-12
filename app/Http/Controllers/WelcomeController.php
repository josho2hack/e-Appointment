<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Models\Appointment;
use Illuminate\Support\Facades\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('office')->filter(Request::only('search'))->where('public', true)->paginate();
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canLoginEmployee' => Route::has('login.employee'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'appointments' => $appointments,
            'filters' => Request::all('search'),
        ]);
    }
}
