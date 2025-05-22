<?php

namespace App\Http\Controllers\Backend\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
   

    public function index()
    { $this->authorize('activity_logs');
        return view('backend.activity.list');
    }

    public function show(Activity $activity)
    {
        $this->authorize('activity_logs');
        return view('backend.activity.show', compact('activity'));
    }
}
