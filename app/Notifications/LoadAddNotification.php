<?php

namespace App\Notifications;

use App\Models\LoadEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Sebastienheyd\Boilerplate\Models\User;

class LoadAddNotification extends Notification
{
    use Queueable;

    protected $loadEntry;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(LoadEntry $loadEntry, $user)
    {
        $this->loadEntry = $loadEntry;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'New load added for Car no: '. $this->loadEntry->vehicle_reg_number . ' and input by ' . $this->user->first_name . ' ' . $this->user->last_name,
            'url' => route('backend.load.show', $this->loadEntry->id),
            'icon' => 'fas fa-truck-loading',
        ];
    }
}
