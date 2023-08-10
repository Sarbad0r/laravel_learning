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

_________________________________________________________________
all information about how to create mail notification you can find here

2. https://www.honeybadger.io/blog/php-laravel-notifications/#:~:text=Laravel%20Notifications&text=Laravel%20provides%20support%20for%20sending,also%20customize%20the%20notification's%20details

do not make your model that use notification Notifiable

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;
        .
        .//Other model definitions
        .
    }

env configuration :

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=your.email@gmail.com
    MAIL_PASSWORD=yourPasswordThatCreatedForAppPasswords
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=your.email@gmail.com
    MAIL_FROM_NAME="${APP_NAME}"

FOR CHANGING MAIL NOTIFICATION IMAGE URL AND OTHER STUFFLS:

    php artisan vendor:publish --tag=laravel-notifications

    php artisan vendor:publish --tag=laravel-mail
