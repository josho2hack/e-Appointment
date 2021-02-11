<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    public function createEmployee()
    {
        return view('auth.login-employee');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        if ($request->username) {
            $this->handleEOfficeCallback($request);
        }

        $request->authenticate();

        $request->session()->regenerate();

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Get remember_me Locale
        $rememberLocale = App::getLocale();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //Set remember_me Locale
        Session::put('applocale', $rememberLocale);

        return redirect('/');
    }

    //e-Office Redirect
    public function handleEOfficeCallback(LoginRequest $request)
    {
        $response = Http::post(env('EOFFICE_AUTH'), [
            'checkUser' => env('EOFFICE_CHKUSER'),
            'checkPass' => env('EOFFICE_CHKPASS'),
            'uid' => Str::upper($request->username),
            'password' => $request->password
        ]);

        $user = $response->body();
        dd($user);
        $this->_registerOrLoginUserEOffice($user);

        //Return Home Affter Login
        return redirect()->route('dashboard');
    }

    //Google Redirect
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $this->_registerOrLoginUserGoogle($user);

        //Return Home Affter Login
        return redirect()->route('dashboard');
    }

    //Facebook Redirec
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $this->_registerOrLoginUserFacebook($user);

        //Return Home Affter Login
        return redirect()->route('dashboard');
    }

    protected function _registerOrLoginUserEOffice($data)
    {
        $user = User::where('email', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->first_name = $data->user['given_name'];
            $user->last_name = $data->user['family_name'];
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }

    protected function _registerOrLoginUserGoogle($data)
    {
        $user = User::where('email', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->first_name = $data->user['given_name'];
            $user->last_name = $data->user['family_name'];
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }

    protected function _registerOrLoginUserFacebook($data)
    {
        $user = User::where('email', $data->email)->first();
        if (!$user) {
            $user = new User();

            $name = explode(" ", $data->name);

            $user->first_name = $name[0];
            $user->last_name = $name[1];
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();

            // $fileContents = file_get_contents($user->avatar);
            // Storage::put('public/uploads/profile/' . $user->id . ".jpg", $fileContents);
        }

        Auth::login($user);
    }
}
