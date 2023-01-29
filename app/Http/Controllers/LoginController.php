<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' =>'Login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request)
    {
        //return $request;
        $credentials = $request->validate([
            'username'=> 'required',
            'password'=> 'required',
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            if(auth()->user()->role_id == '5')
                return redirect()->intended('/');

            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Login Gagal!, periksa kembali Username dan Password anda');

    }

    public function logout ()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect ('/');

    }

}
