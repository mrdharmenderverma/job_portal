<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{   
    // This method is used to view the file
    public function registration() {
        return view('front.account.registration');
    }

    // This method is used to save register details
    public function processRegistration(Request $request){
        
        $validate = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        // dd($validate->all());

        if ($validate->passes()) {
            
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            // dd($user->all());
            $user->save();

            session()->flash('success', 'Your registered successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ]);
            // return redirect()->back()->with('error', 'Wrong Credential');
        }
    }

    // This method is used to view the file
    public function login() {
        return view('front.account.login');
    }
}
