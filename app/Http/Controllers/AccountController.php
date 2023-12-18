<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function registration() {
        return view('front.account.registration');
    }

    public function login() {
        
    }
}
