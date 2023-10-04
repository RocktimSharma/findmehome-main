<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
    function login1(){
        return view('login1');
    }

    function login1Post(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $credential=$request->only('email','password');

        if(Auth::attempt($credential)){
            return redirect()->intended(route('welcome'));
        }
        return redirect()->intended(route('login1'))->with("error", "Login details not valid");

    }

    function registration1(){
        return view('registration1');
    }

    function registration1Post(Request $request){
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
            return redirect()->intended(route('registration1'))->with("error", "Registration failed! Try again");
        }
        return redirect()->intended(route('login1'))->with("Registration success!", "Please login now");



    }

    function logout(){
        session()::flush();
        Auth::logout();
        return redirect(route('login'));

    }
}
?>