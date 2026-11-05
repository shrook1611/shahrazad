<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class sessionController extends Controller
{
   
    public function create()
    {
        return view('Auth.login');
    }


    public function logout()
    {
        auth()->logout();
        return redirect('login')->with('success', 'Logged out successfully.');
    }



    public function login(Request $request)

    {
    
    $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
     

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard')
                ->with('success', 'Logged in successfully.');
        }

        return redirect()->route('home')
            ->with('success', 'Logged in successfully.');
    }

      
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
