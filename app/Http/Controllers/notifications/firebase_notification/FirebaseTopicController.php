<?php

namespace App\Http\Controllers\notifications\firebase_notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseTopicController extends Controller
{
    public function send_topic()
    {

        // the path of your dowloaded key from Google Cloude -> Service Account 
        $factory = (new Factory)->withServiceAccount(storage_path('/firebase_admin_key/sign-in-firebase_admin.json'));

        $messaging = $factory->createMessaging();

        $notification = json_encode([
            'weather' => 1,
            "type" => "C",
            "city" => "Dushanbe"
        ]);


        $message = CloudMessage
            ::withTarget('topic', 'name_of_your_any_topic')
            ->withData(['notification' => $notification]);

        $messaging->send($message);
    }
}
