<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClockInRequest;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function clockIn(ClockInRequest $request)
    {
        return response()->json(['status' => 15]);
    }
}
