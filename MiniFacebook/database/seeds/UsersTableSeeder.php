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
        $user->names="Jorge Rodrigo";
        $user->paternal_surname="Torrez";
        $user->maternal_surname="Aramayo";
        $user->birthday=Carbon::createFromDate(1998, 12, 26, 'America/La_Paz');
        $user->email="jorgerodrigotorrez@gmail.com";
        $user->password=bcrypt(env('APP_SECRET_PASSWORD'));
        $user->created_at=Carbon::now();
        $user->updated_at=Carbon::now();
        $user->save();
    }
}
