<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
    function login(){
        return view('login');
    }

    function loginPost(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $credential=$request->only('email','password');

        if(Auth::attempt($credential)){
            return redirect('/');
        }
        return redirect()->intended(route('login'))->with("error", "Login details not valid");

    }

    function registration(){
        return view('registration');
    }

    function registrationPost(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        if(!$user){
            return redirect()->intended(route('registration'))->with("error", "Registration failed! Try again");
        }
        return redirect()->intended(route('login'))->with("Registration success!", "Please login now");



    }

    function logout(){
        session()::flush();
        Auth::logout();
        return redirect(route('login'));

    }
}
?>