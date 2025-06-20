<?php

namespace App\Notifications;

use App\Models\LoadEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LoadInactiveNotification extends Notification
{
    use Queueable;

    protected $loadEntry;

    /**
     * Create a new notification instance.
     */
    public function __construct(LoadEntry $loadEntry)
    {
        $this->loadEntry = $loadEntry;
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
     * Get the array representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Load has been added for 12+ hours ago but have not been entry in factory - Car no: '.$this->loadEntry->vehicle_reg_number,
            'url' => route('backend.load.show', $this->loadEntry->id),
            'icon' => 'fas fa-exclamation-triangle',
            'load_id' => $this->loadEntry->id,
            'notification_date' => now()->format('Y-m-d'),
        ];
    }
}
