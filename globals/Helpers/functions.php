<?php

use App\Models\Admin;
use App\Models\Agent;
use App\Models\User;

if (!function_exists('sendMail')) {
    function sendMail(Admin|Agent|User $user, string $domain, string $notification, array $data = [])
    {
        $namespace = config("notifications.emails.{$domain}.{$notification}");
        $user->notify(new $namespace($data));
    }
}

if(!function_exists('getGuard')) {
    function getGuard(): string
    {
        if(\Auth::guard('admins')->check()) {
            return 'admins';
        }
        if(\Auth::guard('agents')->check()) {
            return 'agents';
        }
        return 'users';
    }
}

if(!function_exists('getGuardModel')) {
    function getGuardModel(): string
    {
        $guard = getGuard();
        return match($guard) {
            'admins' => \App\Models\Admin::class,
            'users' => \App\Models\User::class,
            'agents' => \App\Models\Agent::class
        };
    }
}
