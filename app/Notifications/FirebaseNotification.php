<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class FirebaseNotification extends Notification
{
    use Queueable;


    public $title;
    public $body;
    public $firebaseTokens;

    /**
     * Create a new notification instance.
     */
    public function __construct($title = null, $body = null, $firebaseTokens = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->firebaseTokens = $firebaseTokens;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['firebase'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toFirebase(object $notifiable): MailMessage
    {
        return (new FirebaseMessage)
            ->withTitle(['title' => $this->title, "body" => $this->body])
            // ->withBody($this->message)
            ->withPriority('high')->asMessage($this->firebaseTokens);
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
