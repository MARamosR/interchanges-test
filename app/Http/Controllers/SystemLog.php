<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemLog as SystemLogModel;

class SystemLog extends Controller
{
    public function index()
    {
        $logs = SystemLogModel::all();
        return view('logs.index', compact('logs'));
    }
}
