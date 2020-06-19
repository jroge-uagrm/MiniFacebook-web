<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userInformations=[
            [
                "names"=>"Jorge Rodrigo",
                "paternal_surname"=>"Torrez",
                "maternal_surname"=>"Aramayo",
                "full_name"=>"Jorge Rodrigo Torrez Aramayo",
                "birthday"=>Carbon::createFromDate(1998, 12, 26, 'America/La_Paz'),
                "email"=>"jorgerodrigotorrez@gmail.com"
            ],
            [
                "names"=>"Jhafeth",
                "paternal_surname"=>"Cadima",
                "maternal_surname"=>"Barrero",
                "full_name"=>"Jhafeth Cadima Barrero",
                "birthday"=>Carbon::createFromDate(1998, 12, 26, 'America/La_Paz'),
                "email"=>"jhafethcadima@gmail.com"
            ],
            [
                "names"=>"Jose Carlos",
                "paternal_surname"=>"Mendoza",
                "maternal_surname"=>"ASDFGHJK",
                "full_name"=>"Jose Carlos Mendoza ASDFGHJK",
                "birthday"=>Carbon::createFromDate(1998, 12, 26, 'America/La_Paz'),
                "email"=>"josecarlosmendoza@gmail.com"
            ],
        ];
        foreach ($userInformations as $userInformation) {
            $user=new User();
            $user->names=$userInformation['names'];
            $user->paternal_surname=$userInformation['paternal_surname'];
            $user->maternal_surname=$userInformation['maternal_surname'];
            $user->full_name=$userInformation['full_name'];
            $user->birthday=$userInformation['birthday'];
            $image=Intervention\Image\Facades\Image::make(base_path('public/images/pp-default.jpeg'));
            $image->resize(300,300);
            Response::make($image->encode('jpeg'));
            $user->profile_picture=$image;
            $user->email=$userInformation['email'];
            $user->password=bcrypt(env('APP_SECRET_PASSWORD'));
            $user->created_at=Carbon::now();
            $user->updated_at=Carbon::now();
            $user->save();
        }
    }
}
