<?php

namespace App\Http\Controllers;

use App\Models\Boilerplate\User;
use Carbon\Carbon;

class Test extends Controller
{
    public function index()
    {
        // Get Server (PHP) Timezone and Time
        $serverTimezone = date_default_timezone_get();
        $serverTime = date('Y-m-d H:i:s');
        
        // Get Laravel Application Timezone and Time
        $laravelTimezone = config('app.timezone');
        $laravelTime = Carbon::now()->format('Y-m-d H:i:s');
        
        // Convert both times to timestamps for comparison
        $serverTimestamp = strtotime($serverTime);
        $laravelTimestamp = Carbon::now()->timestamp;
        
        // Calculate the difference in hours
        $timeDifferenceInSeconds = abs($serverTimestamp - $laravelTimestamp);
        $timeDifferenceInHours = $timeDifferenceInSeconds / 3600;
        
        $data = [
            'Server Timezone' => $serverTimezone,
            'Server Time' => $serverTime,
            'Laravel Timezone' => $laravelTimezone,
            'Laravel Time' => $laravelTime,
            'Time Difference (Hours)' => $timeDifferenceInHours,
            'Timezones Match' => $serverTimezone === $laravelTimezone ? 'Yes' : 'No',
            'Times Match' => $timeDifferenceInHours === 0 ? 'Yes' : 'No'
        ];
        
        return response()->json($data);
    }
}
