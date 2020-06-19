<?php

use Illuminate\Database\Seeder;
use App\Friend;
use Carbon\Carbon;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $friend=new Friend();
        $friend->sender=2;
        $friend->receiver=3;
        $friend->created_at=Carbon::now();
        $friend->save();
    }
}
