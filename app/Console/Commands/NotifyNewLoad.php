<?php

namespace App\Console\Commands;

use App\Models\Boilerplate\User;
use App\Models\LoadEntry;
use App\Notifications\LoadAddNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotifyNewLoad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loads:notify-new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification for newly created loads';

    /**
     * Execute the console command.
     */
    public function handle()
    {        // Get loads created in the last 2 minutes that haven't been notified yet
        $newLoads = LoadEntry::where('created_at', '>=', now()->subMinutes(2))
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('notifications')
                    ->whereRaw('data LIKE CONCAT(\'%"load_id":\', load_entries.id, \'%\')')
                    ->where('type', LoadAddNotification::class);
            })
            ->get();

        if ($newLoads->isEmpty()) {
            $this->info('No new loads found to notify about.');

            return;
        }

        // Get users with admin role and load_crud permission
        $users = User::whereIn('id', getRolePermissionUsersId('admin', 'load_crud'))->get();

        foreach ($newLoads as $load) {
            $this->info("Sending notification for new load ID: {$load->id} - Car No: {$load->vehicle_reg_number}");
            Notification::send($users, new LoadAddNotification($load));
        }

        $this->info('Notifications sent successfully.');
    }
}
