<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Invalid login >:(',
            ]);
        }
        $user = Auth::user();
        if($user->current_account === null) {
            $user->current_account = $user->accounts->first()->id;
            $user->save();
        }
        return redirect()->intended('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
