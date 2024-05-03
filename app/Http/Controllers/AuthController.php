<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }


    public function login(LoginRequest $request){
        $user = $request->validated();
        if(!Auth::attempt($user)){
            return to_route('login')->withErrors([
                'email' => 'Email invalide',
                'password' => 'mot de passe invalide'
            ]);
        }

        session()->regenerate();
        return redirect()->intended(route('bon'));
    }

    public function logout(){
        Auth::logout();
        return redirect()->back();
    }
}
