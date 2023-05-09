<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Http\Requests\GetChatRequest;
use App\Http\Requests\StoreChatRequest;
use App\Models\ChatModel;
use Illuminate\Http\Request;

class ChatController extends Controller
{


    public function sendMessageController(Request $request)
    {

        if (!$request->message || !$request->channel_name) {
            return response(['success' => false, 'message' => 'empty message']);
        }

        $message = $request->message;

        $channel_name = $request->channel_name;

        $user = $request->user();

        broadcast(new TestEvent($message, $user, $channel_name, $request->user_id));
    }
}
