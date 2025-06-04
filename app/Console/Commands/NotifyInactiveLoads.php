<?php

namespace App\Console\Commands;

use App\Models\Boilerplate\User;
use App\Models\LoadEntry;
use App\Notifications\LoadInactiveNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotifyInactiveLoads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loads:check-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for loads that have been inactive for more than 6 hours and notify users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sixHoursAgo = Carbon::now()->subHours(6);

        // Get inactive loads created more than 6 hours ago
        $inactiveLoads = LoadEntry::where('status', 0)
            ->where('created_at', '<=', $sixHoursAgo)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('notifications')
                    ->whereRaw('data LIKE CONCAT(\'%"load_id":\', load_entries.id, \'%\')')
                    ->whereRaw('DATE(created_at) = CURDATE()');
            })
            ->get();

        if ($inactiveLoads->isEmpty()) {
            $this->info('No inactive loads found that require notification.');

            return;
        }

        // Get users with admin role and load_crud permission
        $users = User::whereIn('id', getRolePermissionUsersId('admin', 'load_crud'))->get();

        foreach ($inactiveLoads as $load) {
            $this->info("Notifying about inactive load ID: {$load->id} - Car No: {$load->vehicle_reg_number}");
            Notification::send($users, new LoadInactiveNotification($load));
        }

        $this->info('Notifications sent successfully.');
    }
}
