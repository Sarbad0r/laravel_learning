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



configuration for Firebase Topic (in order to use firebase-topic you should install the "Firebase Admin SDK for php"):

first of all just check out the official web-site of this package:
1. https://firebase-php.readthedocs.io/en/stable/setup.html#google-service-account

for installing run this command:
    
    composer require kreait/firebase-php

if this command throws a package error try to fix that by fixing their versions in composer.json

    require: {
         "guzzlehttp/promises": "^2.0",
         "kreait/firebase-php": "^7.9",
    }

and run 

    composer update --ignore-platform-req=ext-sodium

how to create service account is wrote in this page

1. https://developers.google.com/identity/protocols/oauth2/service-account?hl=ru

then go to the Google Cloud -> select your created firebase project -> IAM & ADMIN -> Service Accounts

you can create a new key by clicking "+Create Service Account" on the top of the page

after creating service account click on the created accound go to the "KEYS" and create new key if you don't have any key

save downloaded key somewhere in file which this file is added in gitignor in order to hide your key  

