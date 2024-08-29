<?php

namespace App\Http\Controllers\Auth;

use App\Events\Auth\UserLoginSuccess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember_me;
        
        Cache::flush();

     
        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1], $remember)) {
            $request->session()->regenerate();

            event(new UserLoginSuccess($request, auth()->user()));

            $user = Auth::user();
    
            if ($user->hasRole('user')) {
                if (auth()->user()->email_verified_at === null) {
                    Auth::logout();
                    return redirect()->back()->withErrors([
                        'email' => 'You need to verify your email address before logging in.',
                    ]);
                }

               return redirect()->intended(RouteServiceProvider::USERHOME);
            }
            else{
                return redirect()->intended(RouteServiceProvider::HOME); 
            }
            //return redirect()->intended(RouteServiceProvider::HOME);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // public function store(LoginRequest $request)
    // {
    //     $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     $email = $request->email;
    //     $password = $request->password;
    //     $remember = $request->remember_me;
        
    //     Cache::flush();

    //     if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1, 'email_verified_at' => ['!=', null]], $remember)) {
    //         $request->session()->regenerate();

    //         event(new UserLoginSuccess($request, auth()->user()));

    //         $user = Auth::user();
    
    //         if ($user->hasRole('user')) {
    //         return redirect()->intended(RouteServiceProvider::USERHOME);
    //         }
    //         else{
    //             return redirect()->intended(RouteServiceProvider::HOME); 
    //         }

    //     }else {
    //         // Handle the case where the login fails due to unverified email
    //         if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
    //             if (auth()->user()->email_verified_at === null) {
    //                 Auth::logout();
    //                 return redirect()->back()->withErrors([
    //                     'email' => 'You need to verify your email address before logging in.',
    //                 ]);
    //             }
    //         }
   
    //         Auth::logout();
    //         return back()->withErrors([
    //             'email' => 'The provided credentials do not match our records.',
    //         ])->onlyInput('email');
    //     }
    // }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
