<?php
return [
    /*
    |--------------------------------------------------------------------------
    | FCM Server Key
    |--------------------------------------------------------------------------
    |
    | This is the Firebase Cloud Messaging server key that you can get
    | from the Firebase console. This will be used to send push notifications
    | to Android and iOS devices.
    |
    */
    'key' => env('FCM_SERVER_KEY'),

    /*
    |--------------------------------------------------------------------------
    | FCM Retry Time (Optional)
    |--------------------------------------------------------------------------
    |
    | Define how long the channel should wait before retrying to send a push
    | notification when there are failures. Default is 5 seconds.
    |
    */
    'retry' => 5000,
];