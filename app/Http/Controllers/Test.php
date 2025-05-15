<?php

namespace App\Http\Controllers;

use App\Models\Boilerplate\User;

class Test extends Controller
{
    public function index()
    {
        $aduser = User::whereHasRole('admin')->get('id')->pluck('id')->toArray();
        $permissionuser = User::whereHasPermission('load_index')->get('id')->pluck('id')->toArray();

        $maketogether = array_unique(array_merge($aduser, $permissionuser));

        $user = User::whereIn('id', $maketogether)->get();
        dd($aduser, $permissionuser, $maketogether, $user);
    }
}
