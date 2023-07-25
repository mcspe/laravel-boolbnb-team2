<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;


class NewMessageController extends Controller
{
  public function index(Request $request) {
    $form_data = $request->all();
    $new_message = new Message();
    $new_message->fill($form_data);
    $new_message->save();

    return response()->json('Il tuo messaggio è stato inviato correttamente!');
  }
}
