<?php

use Illuminate\Database\Seeder;
use App\Chat;
use Carbon\Carbon;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chat=new Chat();
        $chat->creator=1;
        $chat->invited=2;
        $chat->created_at=Carbon::now();
        $chat->save();

        $chat=new Chat();
        $chat->creator=3;
        $chat->invited=1;
        $chat->created_at=Carbon::now();
        $chat->save();
    }
}
