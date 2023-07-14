<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Apartment;


class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = config("messages");

        foreach($messages as $message){
            $new_message = new Message();
            $new_message->apartment_id = Apartment::inRandomOrder()->first()->id;
            $new_message->sender_name = $message["sender_name"];
            $new_message->sender_lastname = $message["sender_lastname"];
            $new_message->sender_email = $message["sender_email"];
            $new_message->text = $message["text"];
            $new_message->save();

        }
    }
}
