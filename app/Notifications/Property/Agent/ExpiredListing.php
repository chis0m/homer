<?php

namespace App\Notifications\Property\Agent;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpiredListing extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = 'Listing Expired';
        $message = "We want to bring to your notice that your listing has been expired.
                    Please, do login to your dashboard and persist your listing if still valid.
                    The system expects to be perform this action within the next 24 hours to avoid this property being
                    delisted by our bot.";

        $endMessage = 'Thank you for your compliance';

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
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
