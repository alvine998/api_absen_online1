<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function login(Request $req)
    {
        $req->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $req->only('nik', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("/")->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}
