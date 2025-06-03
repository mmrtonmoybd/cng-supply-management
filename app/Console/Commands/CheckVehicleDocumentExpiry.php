<?php

namespace App\Console\Commands;

use App\Models\Boilerplate\User;
use App\Models\VehicleDocument;
use App\Notifications\VehicleDocumentExpiryNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckVehicleDocumentExpiry extends Command
{
    protected $signature = 'vehicle:check-documents';

    protected $description = 'Check vehicle documents for expiration and send notifications';

    public function handle()
    {
        $this->info('Checking vehicle documents expiry...');

        // Get documents that will expire in the next 30 days and already expired documents
        $documents = VehicleDocument::whereNotNull('expiry_date')
            ->where(function ($query) {
                $query->where(function ($q) {
                    // Documents expiring in next 30 days
                    $q->where('expiry_date', '>', Carbon::now())
                        ->where('expiry_date', '<=', Carbon::now()->addDays(30));
                })
                    ->orWhere('expiry_date', '<=', Carbon::now()); // Already expired documents
            })
            ->get();

        if ($documents->isEmpty()) {
            $this->info('No documents expiring soon or expired.');

            return 0;
        }

        // Get all admin users to notify
        $admins = User::whereIn('id', getRolePermissionUsersId('admin', 'vehicle_crud'))->get();

        foreach ($documents as $document) {
            $expiryDate = Carbon::parse($document->expiry_date);
            $isExpired = $expiryDate->isPast();
            $daysRemaining = $isExpired
                ? Carbon::now()->diffInDays($expiryDate) // Days since expiry
                : Carbon::now()->diffInDays($expiryDate); // Days until expiry

            // Check if we've already sent a notification in the last month
            $lastNotification = \DB::table('notifications')
                ->where('type', VehicleDocumentExpiryNotification::class)
                ->where('data', 'LIKE', '%"id":'.$document->id.'%')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastNotification) {
                $lastNotificationDate = Carbon::parse($lastNotification->created_at);
                if ($lastNotificationDate->diffInMonths(Carbon::now()) < 1) {
                    $status = $isExpired ? 'EXPIRED' : "expiring in $daysRemaining days";
                    $this->info("Skipping notification for document: {$document->name} ($status) - Already notified within last month");

                    continue;
                }
            }

            // Notify all admins
            foreach ($admins as $admin) {
                $admin->notify(new VehicleDocumentExpiryNotification($document, $daysRemaining, $isExpired));
            }

            $status = $isExpired ? "EXPIRED ({$daysRemaining} days ago)" : "expiring in {$daysRemaining} days";
            $this->info("Sent notification for document: {$document->name} ($status)");
        }

        $this->info('Document check completed successfully.');

        return 0;
    }
}
