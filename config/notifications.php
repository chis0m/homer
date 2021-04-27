<?php

return [
    'emails' => [
        'auth' => [
            'admin' => [
                'Welcome' => App\Notifications\Auth\Admin\AdminWelcome::class,
            ],
            'agent' => [
                'Welcome' => App\Notifications\Auth\Agent\AgentWelcome::class
            ],
            'user' => [
                'Welcome' => App\Notifications\Auth\User\UserWelcome::class,
            ],
        ],
        'peer' => [],
        'property' => [
            'admin' => [

            ],
            'agent' => [
                'ExpiredListing' => App\Notifications\Property\Agent\ExpiredListing::class,
                'ListingDeactivated' => App\Notifications\Property\Agent\ListingDeactivated::class,
            ],
            'user' => [

            ]
        ]
    ]
];
