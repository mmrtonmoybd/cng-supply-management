<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Highlight;
use Illuminate\Http\Request;

class HighlightController extends Controller
{
    public function save(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|integer',
            'module_name' => 'required|string',
            'color' => 'nullable|string',
        ]);

        $highlight = Highlight::updateOrCreate(
            ['module_name' => $request->module_name, 'module_id' => $request->module_id],
            ['color' => $request->color]
        );

        return response()->json(['success' => true, 'color' => $highlight->color]);
    }
}
