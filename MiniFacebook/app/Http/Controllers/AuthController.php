<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Exception;
use App\User;

class AuthController extends Controller
{
    public function index(){
        return view('auth.index');
    }

    public function login(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if(!User::where('email',$request->input('email'))->first()){
            throw AuthController::newError('email','Correo no registrado');
        }
        if (Auth::attempt($credentials,true)) {
            return redirect()->intended('home');
        }
        throw AuthController::newError('password','Contraseña incorrecta');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('authenticate');
    }

    public static function newError($key,$value){
        $error = \Illuminate\Validation\ValidationException::withMessages([
            $key=>$value
        ]);
        return $error;
    }
}
