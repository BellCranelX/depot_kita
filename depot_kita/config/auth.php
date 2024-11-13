<?php
return [

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'customer' => [
            'driver' => 'session',
            'provider' => 'customer', // Correctly points to 'customer' provider
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'customer' => [
            'driver' => 'eloquent',
            'model' => App\Models\Customer::class, // Points to Customer model
        ],
    ],

];
