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
use App\Message;
use App\Chat;
use App\FriendRequest;
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

    public function admin(Request $request){
        $request->validate([
            'admin_password' => 'required',
        ]);
        if($request->admin_password===env('APP_SECRET_PASSWORD')){
            $user=Auth::user();
            $user->role_id=1;
            $user->save();
            return redirect()->back()->with(
                'success',
                'Ahora eres administrador.'
            );
        }else{
            throw AuthController::newError('admin_password','Contraseña incorrecta');
        }
    }

    public function info(){
        $userCount=count(User::where('role_id','<>','3')->get());
        $menUserCount=count(User::where([
            ['role_id','<>','3'],
            ['sex','M'],
        ])->get());
        $womenUserCount=count(User::where([
            ['role_id','<>','3'],
            ['sex','F'],
        ])->get());
        $contactCount=(count(DB::table('contacts')->get())-$userCount)/2;
        $friendRequestCount=count(FriendRequest::all());
        $contactAndFriendRequestCount=$contactCount+$friendRequestCount;
        $messageCount=count(Message::all());
        $chatCount=count(Chat::all());

        $menUsersPorcent=$menUserCount*100/$userCount;
        $womenUsersPorcent=$womenUserCount*100/$userCount;
        $acceptedFriendRequestPorcent=$contactCount*100/$contactAndFriendRequestCount;
        $pendingFriendRequestPorcent=$friendRequestCount*100/$contactAndFriendRequestCount;
        $messagesPerChatAverage=$messageCount/$chatCount;
        $messageSentByUserAverage=$messageCount/$userCount;
        $contactsPerUserAverage=$contactCount/$userCount;

        $info=[
            'Porcentaje de hombres registrados'=>$menUsersPorcent,
            'Porcentaje de mujeres registrados'=>$womenUsersPorcent,
            'Porcentaje de solicitudes aceptadas'=>$acceptedFriendRequestPorcent,
            'Porcentaje de solicitudes pendientes'=>$pendingFriendRequestPorcent,
            'Promedio de mensajes por chat'=>$messagesPerChatAverage,
            'Promedio de mensajes enviados por usuario'=>$messageSentByUserAverage,
            'Promedio de contactos por usuario'=>$contactsPerUserAverage,
        ];
        return view('admin.index',compact('info'));
    }
}
