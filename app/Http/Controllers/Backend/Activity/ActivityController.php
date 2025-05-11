<?php

namespace App\Http\Controllers\Backend\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ActivityController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('ability:admin,activity_logs', ),
        ];
    }
    public function index()
    {
        return view('backend.activity.list');
    }

    public function show(Activity $activity)
    
    {
        return view('backend.activity.show', compact('activity'));
    }
}
