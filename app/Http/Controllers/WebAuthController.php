<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends Controller
{

    public function index(){
        return view('chat.auth.login',[
            'title' => 'Authentication'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if(Auth::attempt($credentials))
        {
            // dd(auth()->check());
            $request->session()->regenerate();
            return redirect()->intended('/livechat');
        }else{
            return back()->withErrors('loginFailed','Masukkan kembali data dengan benar');
        }

    }

    public function logout(Request $request)
    {
        $request->sesion()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
