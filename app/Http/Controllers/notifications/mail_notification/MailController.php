<?php

namespace App\Http\Controllers\notifications\mail_notification;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\MailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class MailController extends Controller
{
    public function mail_notification()
    {

        $user = User::where('id', 1)->first();
        // you can send mail notification using only one user  
        // $user->notify(new MailNotification("Hello title"));


        // also you can send mail notification like this
        Notification::route('mail', $user->email)->notify(new MailNotification("Hello title"));
    }
}
