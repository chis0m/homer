<?php

if (!function_exists('tester')) {
    function sendMail($user, $domain, $notification, $data = [])
    {
        $namespace = config("notifications.emails.{$domain}.{$notification}");
        $user->notify(new $namespace($data));
    }
}
