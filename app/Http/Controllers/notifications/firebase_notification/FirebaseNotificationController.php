<?php

namespace App\Http\Controllers\notifications\firebase_notification;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\FirebaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class FirebaseNotificationController extends Controller
{
    public function send_notification_test(Request $request)
    {

        $all_fcm_tokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

        $customer = User::where('id', 44)->first();

        $fmc_tokens = $customer->fcm_token;

        // $image =  PromoBannerModel::where('id', 15)->first();

        //you can send push notification with firebase using only one fcm_token
        Notification::send(null, new FirebaseNotification(
            "Hello title from Alshema",
            "Hello message from Dushanbe",
            $all_fcm_tokens,
        ));


        //you can send mail notification using only one user  
        // $customer->notify(new MailNotification("Hello title", "Hello message"));


        //also you can send mail notification like this
        // Notification::route('mail', $customer->email)->notify(new MailNotification("Hello title", "Hello message", $fmc_tokens));
    }
}
