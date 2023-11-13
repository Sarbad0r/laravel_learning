<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramLocation;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification
{
    use Queueable;

    protected $content;
    protected $firstLine;
    protected $secondLine;

    /**
     * Create a new notification instance.
     */
    public function __construct($content, $firstLine, $secondLine)
    {
        $this->content = $content;
        $this->firstLine = $firstLine;
        $this->secondLine = $secondLine;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toTelegram(object $notifiable)
    {
        // u can find more in https://github.com/laravel-notification-channels/telegram

        // TelegramFile
        // TelegramContact
        // TelegramPoll
        // TelegramMessage
        // TelegramLocation
        return TelegramLocation::create()
            // ->content("$this->content")
            // ->line("$this->firstLine")
            // ->line("$this->secondLine")
            // ->photo('https://cdn-images-1.medium.com/max/1200/1*5-aoK8IBmXve5whBQM90GA.png')
            ->latitude(38.568408)
            ->longitude(68.761184)
            ->button(
                'Check out our app',
                "https://play.google.com/store/apps/details?id=com.new_planned_app_bundle.planned_chat_flutter"
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
