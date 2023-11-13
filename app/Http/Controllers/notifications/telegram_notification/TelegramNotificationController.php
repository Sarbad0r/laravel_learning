<?php

namespace App\Http\Controllers\notifications\telegram_notification;

use App\Http\Controllers\Controller;
use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TelegramNotificationController extends Controller
{
    public function sendTelegramNotification()
    {

        //for getting channel or group id -> https://youtu.be/UPC5Ck1oU6k?si=BUyK_m6pBaLKm84o

        // docs -> https://github.com/laravel-notification-channels/telegram

        // https://medium.com/modulr/send-telegram-notifications-with-laravel-9-342cc87b406

        Notification::route('telegram', env('TELEGRAM_CHAT_ID'))->notify(new TelegramNotification(
            "Hello there!",
            "Your invoice has been *PAID*",
            "Thank you!",
        ));
    }
}
