<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=new User();
        $user->names="Usuario";
        $user->last_names="Oculto";
        $user->email="usuario_oculto@mail.com";
        $user->birthday=Carbon::now();
        $user->sex="M";
        $user->password=bcrypt(env('APP_SECRET_PASSWORD'));
        $user->role_id=2;
        $user->created_at=Carbon::now();
        $user->updated_at=Carbon::now();
        $user->save();
    }
}
