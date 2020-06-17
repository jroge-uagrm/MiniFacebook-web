<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Exception;

class HomeController extends Controller
{
    public function index(){
        $user = Auth::user();
        $contentType="publications";
        $publications=[
            "publication A",
            "Publication B",
            "Publication C",
            "Publication D",
        ];
        return view('home.index',compact('user','contentType','publications'));
    }

    public function read(){
        $user = Auth::user();
        $contentType="profile_config";
        return view('home.profile',compact('user','contentType'));
    }

    public function update(Request $request){
        $request->validate([
            'names' => 'required',
            'paternal_surname' => 'required',
            'maternal_surname' => 'required',
            'birthday' => 'required|date',
            'email' => 'required|email',
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $user=Auth::user();
        if (Auth::attempt(['email'=>$user->email,'password'=>$request->old_password])) {
            try{
                $user->names=$request->names;
                $user->paternal_surname=$request->paternal_surname;
                $user->maternal_surname=$request->maternal_surname;
                $user->birthday=$request->birthday;
                $user->email=$request->email;
                $user->password=bcrypt($request->password);
                $user->save();
                return redirect()->route('home');
            }catch(Exception $e){
                throw AuthController::newError("email","Este correo ya ha sido registrado.");
            }
        }else{
            throw AuthController::newError("old_password","Contraseña incorrecta.");
        }
    }
}
