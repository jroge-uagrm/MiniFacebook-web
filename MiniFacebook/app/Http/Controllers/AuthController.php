<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Exception;
use App\User;
use App\Contact;
use App\Publication;
use App\Comment;
use Image;
use Illuminate\Support\Facades\Response;
use DB;

class AuthController extends Controller
{
    public function index(){
        return view('auth.index');
    }

    public function login(Request $request){
        $request->validate([
            'email_' => 'required|email',
            'password_' => 'required',
        ]);
        if(!User::where('email',$request->email_)->first()){
            throw AuthController::newError('email_','Correo no registrado');
        }
        if (Auth::attempt(['email'=>$request->email_,'password'=>$request->password_])) {
            $visit = 1;
            if(file_exists("counter.txt")) {
                $fp    = fopen("counter.txt", "r");
                $visit = fread($fp, 4);
                $visit = $visit + 1;
            }
            $fp = fopen("counter.txt", "w");
            fwrite($fp, $visit);
            fclose($fp);
            return redirect()->intended('home');
        }
        throw AuthController::newError('password_','Contraseña incorrecta');
    }

    public function register(Request $request){
        $request->validate([
            'names' => 'required',
            'last_names' => 'required',
            'email' => 'required|email|unique:users',
            'sex' => 'required',
            'password' => 'required|confirmed',
        ]);
        $user=new User();
        $user->names=$request->names;
        $user->last_names=$request->last_names;
        // $user->full_name=$request->names.' '.$request->last_names;
        $user->birthday=Carbon::now();
        $user->email=$request->email;
        $user->sex=$request->sex;
        $user->password=bcrypt($request->password);
        $user->profile_picture_path="/images/pp-default.jpeg";
        $user->role_id=2;
        $user->created_at=Carbon::now();
        $user->save();
        $contact=new Contact();
        $contact->user_a=$user->id;
        $contact->user_b=$user->id;
        $contact->created_at=Carbon::now();
        $contact->save();
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            return redirect()->route('home');
        }
        return redirect()->route('authenticate');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('authenticate');
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $user=Auth::user();
        if (Auth::attempt(['email'=>$user->email,'password'=>$request->old_password])) {
            $user->password=bcrypt($request->password);
            $user->save();
        }else{
            throw AuthController::newError("old_password","Contraseña incorrecta.");
        }
    }

    public function delete(){
        $user=Auth::user();
        $user->names="Usuario";
        $user->last_names="Eliminado";
        $user->email="usuario_eliminado_".Auth::id()."@mail.com";
        $user->birthday=Carbon::now();
        $user->sex="M";
        $user->password=bcrypt(env('APP_SECRET_PASSWORD'));
        $user->role_id=3;
        $user->created_at=Carbon::now();
        $user->updated_at=Carbon::now();
        $user->save();
        Auth::logout();
        return redirect()->route('authenticate')->with(
            'success',
            'Cuenta eliminada exitosamente'
        );
    }

    public static function newError($key,$value){
        $error = \Illuminate\Validation\ValidationException::withMessages([
            $key=>$value
        ]);
        return $error;
    }
}
