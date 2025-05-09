<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['database']; // Only store in database
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You Lol!',
            'url' => url('/backend/userprofile') // or any route you want
        ];
    }
}
