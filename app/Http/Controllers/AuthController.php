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
use App\Report;
use Image;
use Illuminate\Support\Facades\Response;
use DB;
use PDF;
use Maatwebsite\Excel\Excel;
use App\Exports\ReportExport;
use App\Exports\StatisticsExport;

class AuthController extends Controller
{
    private $excel;

    public function __construct(Excel $e){
        $this->excel=$e;
    }

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
            /* $visit = 1;
            if(file_exists("counter.txt")) {
                $fp    = fopen("counter.txt", "r");
                $visit = fread($fp, 4);
                $visit = $visit + 1;
            }
            $fp = fopen("counter.txt", "w");
            fwrite($fp, $visit);
            fclose($fp); */
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
        $user->style="classicnormal";
        $user->created_at=Carbon::now();
        $user->save();
        /* $contact=new Contact();
        $contact->user_a=$user->id;
        $contact->user_b=$user->id;
        $contact->created_at=Carbon::now();
        $contact->save(); */
        DB::table('contacts')->insert([[
            'user_a' => $user->id,
            'user_b' => $user->id
        ]]);
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            return redirect()->route('profile',$user->id);
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
            return redirect()->back()->with(
                'success',
                'Contraseña cambiada correctamente.'
            );
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
        $publications=Publication::where('user_id',$user->id)->get();
        foreach ($publications as $publication) {
            Comment::where('publication_id',$publication->id)->delete();
            $publication->delete();
        }
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
        $report=$this->getReportInfo();
        $statistics=$this->getStatisticsInfo();
        return view('admin.index',compact('report','statistics'));
    }

    public function statisticsPdf(){
        $info=$this->getStatisticsInfo();
        $pdf = PDF::loadView('admin.pdf', compact('info'))->setPaper('a4', 'landscape');
        return $pdf->download('estadisticas.pdf');
    }

    public function statisticsExcel(){
        $data=$this->getStatisticsInfo();
        return $this->excel->download(new StatisticsExport(),'estadisticas.xlsx');
    }

    public function reportPdf(){
        $info=$this->getReportInfo();
        $pdf = PDF::loadView('admin.pdf', compact('info'))->setPaper('a4', 'landscape');
        return $pdf->download('reporte.pdf');
    }

    public function reportExcel(){
        $data=$this->getReportInfo();
        return $this->excel->download(new ReportExport(),'reports.xlsx');
    }

    public static function getStatisticsInfo(){
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

        $menUsersPorcent=$userCount!=0?$menUserCount*100/$userCount:0;
        $womenUsersPorcent=$userCount!=0?$womenUserCount*100/$userCount:0;
        $acceptedFriendRequestPorcent=$contactAndFriendRequestCount!=0?$contactCount*100/$contactAndFriendRequestCount:0;
        $pendingFriendRequestPorcent=$contactAndFriendRequestCount!=0?$friendRequestCount*100/$contactAndFriendRequestCount:0;
        $messagesPerChatAverage=$chatCount!=0?$messageCount/$chatCount:0;
        $messageSentByUserAverage=$userCount!=0?$messageCount/$userCount:0;
        $contactsPerUserAverage=$userCount!=0?$contactCount/$userCount:0;
        
        $data= [
            'Porcentaje de hombres registrados'=>round($menUsersPorcent,2)."%",
            'Porcentaje de mujeres registrados'=>round($womenUsersPorcent,2)."%",
            'Porcentaje de solicitudes aceptadas'=>round($acceptedFriendRequestPorcent,2)."%",
            'Porcentaje de solicitudes pendientes'=>round($pendingFriendRequestPorcent,2)."%",
            'Promedio de mensajes por chat'=>round($messagesPerChatAverage,2)." msjs/chat",
            'Promedio de mensajes enviados por usuario'=>round($messageSentByUserAverage,2)." msjs/usuario",
            'Promedio de contactos por usuario'=>round($contactsPerUserAverage,2)." contactos/usuario",
        ];

        Report::where([
            ['id','>','0'],
            ['type','statistic'],
        ])->delete();

        foreach ($data as $key => $value) {
            $report=new Report();
            $report->information=$key;
            $report->value=$value;
            $report->type='statistic';
            $report->save();
        }

        return $data;
    }

    public static function getReportInfo(){
        $userCount=count(User::where('role_id','<>','3')->get());
        $messageCount=count(Message::all());
        $friendRequestCount=count(FriendRequest::all());
        $contactCount=(count(DB::table('contacts')->get())-$userCount)/2;
        
        $data= [
            'Usuarios registrados'=>$userCount,
            'Mensajes enviados'=>$messageCount,
            'Solicitudes de amistad'=>$friendRequestCount,
            'Amistades'=>$contactCount,
        ];

        Report::where([
            ['id','>','0'],
            ['type','report'],
        ])->delete();

        foreach ($data as $key => $value) {
            $report=new Report();
            $report->information=$key;
            $report->value=$value;
            $report->type='report';
            $report->save();
        }

        return $data;
    }
}
