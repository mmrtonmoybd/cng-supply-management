<?php

namespace App\Notifications;

use App\Models\VehicleDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VehicleDocumentExpiryNotification extends Notification
{
    use Queueable;

    protected $document;

    protected $daysRemaining;

    protected $isExpired;

    public function __construct(VehicleDocument $document, int $daysRemaining, bool $isExpired = false)
    {
        $this->document = $document;
        $this->daysRemaining = $daysRemaining;
        $this->isExpired = $isExpired;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $message = $this->isExpired
            ? "Vehicle document '{$this->document->name}' for vehicle {$this->document->vehicle->vehicle_number} has EXPIRED ({$this->daysRemaining} days ago)"
            : "Vehicle document '{$this->document->name}' for vehicle {$this->document->vehicle->vehicle_number} will expire in {$this->daysRemaining} days";

        return [
            'message' => $message,
            'url' => route('backend.vehicle.vehicle.show', $this->document->vehicle_id),
            'icon' => 'fas fa-exclamation-triangle',
            'id' => $this->document->id,
        ];
    }
}
