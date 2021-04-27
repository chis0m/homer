<?php

namespace App\Notifications\Property\Agent;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ListingDeactivated extends Notification
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
        $subject = 'Listing Deactivated';
        $message = "We are sorry to inform you that your listing has been deactivated.
                    However you can login and activate it. Please, do ensure the property
                    is still available for rent/lease.";
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
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
