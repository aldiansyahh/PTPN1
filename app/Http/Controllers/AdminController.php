<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Admin;
use Illuminate\Support\Facades\Session;



class AdminController extends Controller
{
    public function Admin()
    {
        if (Auth::check()) {
            return redirect('/login');
        } else {
            return view('Admin');
        }
    }


    public function actionAdmin(Request $request)
    {
        $data = [
            'emailAdmin' => $request->input('Email'),
            'passwordAdmin' => $request->input('Password'),
        ];
        // dd(Auth::Attempt($data));


        if (Auth::Attempt($data)) {
            return redirect('siswas');
        } else {
            Session::flash('error', 'Email atau Password Salah');
            return redirect('/login Admin');
        }
    }


    public function actionlogout()
    {
        Auth::logout();
        return redirect('');
    }
}
