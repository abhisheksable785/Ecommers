<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function notification()
    {
        return view('Settings.settings-notifications');
    }
}
