all information about how to create mail notification you can find here

2. https://www.honeybadger.io/blog/php-laravel-notifications/#:~:text=Laravel%20Notifications&text=Laravel%20provides%20support%20for%20sending,also%20customize%20the%20notification's%20details

do not forget to make your model that use notification Notifiable

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;
        .
        .//Other model definitions
        .
    }

Note: you have two-factor authentication enabled and created an App password. to put your password in env

env configuration :

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=your.email@gmail.com
    MAIL_PASSWORD=youHaveTwoFactorAuthenticationEnabledAndCreatedAnAppPassword
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=your.email@gmail.com
    MAIL_FROM_NAME="${APP_NAME}"

FOR CHANGING MAIL NOTIFICATION IMAGE URL AND OTHER STUFFLS:

    php artisan vendor:publish --tag=laravel-notifications

    php artisan vendor:publish --tag=laravel-mail
