<?php

namespace App\Notifications\Auth\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserWelcome extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        echo 'hello';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = 'Welcome';
        $message = 'We are happy to have you at homer';

        $endMessage = "<span></span>";

        return (new MailMessage)->markdown(
            'emails.general.template',
            [
                'message' => $message,
                'end_message' => $endMessage,
                'user' => $notifiable,
                'button_text' => 'LOGIN',
                'url' =>  config('api.app_url') . '/login',
            ]
        )->subject($subject);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
