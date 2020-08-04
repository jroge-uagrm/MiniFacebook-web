<?php

use Illuminate\Database\Seeder;
use App\Message;
use Carbon\Carbon;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messageInformations=[
            [
                "chat_id"=>1,
                "sender"=>1,
                "receiver"=>2,
                "sender_status"=>"saved",
                "receiver_status"=>"saved",
                "content_type"=>"text",
                "file_content"=>null,
                "text_content"=>"Hola",
                "created_at"=>Carbon::now(),
            ],
            [
                "chat_id"=>1,
                "sender"=>2,
                "receiver"=>1,
                "sender_status"=>"saved",
                "receiver_status"=>"saved",
                "content_type"=>"text",
                "file_content"=>null,
                "text_content"=>"Hola, cuánto tiempo! Cómo estás?? todo bien?",
                "created_at"=>Carbon::now()->addMinutes(5),
            ],
            [
                "chat_id"=>1,
                "sender"=>1,
                "receiver"=>2,
                "sender_status"=>"saved",
                "receiver_status"=>"saved",
                "content_type"=>"text",
                "file_content"=>null,
                "text_content"=>"Sii todo bien, estaba sin celular porque me robaron hace tiempo, no tenia plata pa comprar otro asi que F, empecé a ahorrar para comprarme uno nuevo y aquí estoy jajajajaja tengo el último de Sony, la parte... :D",
                "created_at"=>Carbon::now()->addMinutes(19),
            ],
            [
                "chat_id"=>2,
                "sender"=>1,
                "receiver"=>3,
                "sender_status"=>"saved",
                "receiver_status"=>"saved",
                "content_type"=>"text",
                "file_content"=>null,
                "text_content"=>"Hola",
                "created_at"=>Carbon::now(),
            ],
        ];
        foreach ($messageInformations as $messageInformation) {
            $message=new Message();
            $message->chat_id=$messageInformation['chat_id'];
            $message->sender=$messageInformation['sender'];
            $message->receiver=$messageInformation['receiver'];
            $message->sender_status=$messageInformation['sender_status'];
            $message->receiver_status=$messageInformation['receiver_status'];
            $message->content_type=$messageInformation['content_type'];
            $message->file_content=$messageInformation['file_content'];
            $message->text_content=$messageInformation['text_content'];
            $message->created_at=$messageInformation['created_at'];
            // $message->save();
        }
    }
}
