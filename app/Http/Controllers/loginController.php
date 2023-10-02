<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index(){
        return view('login.index', [
            'title' => 'login'
        ]);
    }


    public function authentication(Request $request){
        $autentikasiData = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($autentikasiData)){
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Login Failed!!');
        }
    
}
