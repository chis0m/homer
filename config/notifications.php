<?php

return [
    'emails' => [
        'auth' => [
            'UserWelcome' => Notifications\User\Auth\UserWelcome::class,
            'AdminWelcome' => Notifications\Admin\Auth\AdminWelcome::class,
            'AgentWelcome' => Notifications\Agent\Auth\AgentWelcome::class
        ],
        'peer' => [],
        'property-listing' => []
    ]
];
