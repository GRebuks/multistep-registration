<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store()
    {
        $this->validate(request(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!auth()->attempt(request(['username', 'password']))) {
            return back()->withErrors([
                'message' => 'Wrong username or password. Please try again.',
            ]);
        }
        $user = auth()->user();
        session()->put('user', $user);
        Auth::login($user);
        return redirect()->route('home');
    }

}
