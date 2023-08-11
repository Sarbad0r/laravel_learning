all information about how to create firebase notification you can find

1. https://techvblogs.com/blog/firebase-push-notification-laravel

Install Larafirebase Package:

    composer require kutia-software-company/larafirebase

Copy Config:

    php artisan vendor:publish --provider="Kutia\Larafirebase\Providers\LarafirebaseServiceProvider"

Add Firebase Server Key (you can get key from firebase project settings->cloud messaging->Cloud Messaging API (Legacy)) to .env:

    FIREBASE_SERVER_KEY=XXXXXXXXXXXXXXXXXXXXX

Configure config/larafirebase.php:

    return [
        'authentication_key' => env('FIREBASE_SERVER_KEY')
    ];

First Create Notification using following command:

    php artisan make:notification SendPushNotification

do not forget to make your model that use notification Notifiable

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;
        .
        .//Other model definitions
        .
    }
