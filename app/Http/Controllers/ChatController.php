<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Http\Requests\GetChatRequest;
use App\Http\Requests\StoreChatRequest;
use App\Models\ChatModel;
use Illuminate\Http\Request;

class ChatController extends Controller
{


    //get chats
    public function index(GetChatRequest $request)
    {
        $isPrivate = 1;

        if ($request->has('is_private')) {
            $isPrivate = (int)$request->is_private;
        }

        $chats = ChatModel::where('is_private', $isPrivate)
            ->hasParticipant($request->user()->id)
            ->whereHas('message')
            ->with('lastMessage.user', 'participants.user')
            ->latest('updated_at')->get();

        return response(['success' => true, 'chats' => $chats]);
    }


    public function store(StoreChatRequest $request)
    {

        $data = $this->prepareStoreData($request);

        if ($data['userId'] === $data['otherUserId']) {
            return response(['success' => false, 'message' => 'You can not create a chat with your own']);
        }

        $prevChat = $this->getPreviousChat($request, $data['otherUserId']);

        if (!$prevChat) {
            $chat = ChatModel::create($data['data']);

            $chat->participants()->createMany([
                [
                    'user_id' => $data['user_id']
                ],
                [
                    'user_id' => $data['otherUserId']
                ]
            ]);

            $chat->refresh()->load('lastMessage.user', 'participants.user');
            return response(['success' => true, 'chat' => $chat]);
        }

        return response(['success' => true, 'chat' => $prevChat->load('lastMessage.user', 'participants.user')]);
    }


    private function getPreviousChat(StoreChatRequest $request, int $otherUserId)
    {
        $userID = $request->user()->id;

        return ChatModel::where('is_private', 1)
            ->whereHas('participants', function ($sql) use ($otherUserId) {
                $sql->where('user_id', $otherUserId);
            })->whereHas('participants', function ($sql) use ($userID) {
                $sql->where('user_id', $userID);
            });
    }

    private function prepareStoreData(StoreChatRequest $request)
    {
        $data = $request->validate();
        $otherUserID = (int)$request->user_id;
        unset($request->user_id);
        $data['created_by'] = $request->user()->id;


        return [
            'otherUserId' => $otherUserID,
            'userId' => $request->user()->id,
            'data' => $data
        ];
    }


    //get single chat
    public function show(ChatModel $chat)
    {
        $chat->load('lastMessage.user', 'participants.user');
        return response(['success' => true, 'chat' => $chat]);
    }



    public function sendMessageController(Request $request)
    {

        if (!$request->message) {
            return response(['success' => false, 'message' => 'empty message']);
        }

        $message = $request->message;


        $user = $request->user();

        broadcast(new TestEvent($message, $user));
    }
}
