<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClockInRequest;
use App\Http\Responses\Api\FailedResponse;
use App\Http\Responses\Api\SuccessResponse;
use App\Services\AttendanceService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * @param  protected
     * @param  protected
     */
    public function __construct(
        protected UserService $userService,
        protected AttendanceService $attendanceService
    ) {
    }

    public function index(Request $request)
    {
        return response()->json(['status' => 15]);
    }

    /**
     * @param ClockInRequest $request
     * 
     * @return [type]
     */
    public function clockIn(ClockInRequest $request)
    {
        $user = $this->userService->fetchfromApi($request->worker_id);

        if (!$this->userService->isCloseToWork($user, $request->latitude, $request->longitude)) {
            throw new FailedResponse('You are not close to work');
        }

        $attendance = $this->attendanceService->clockIn($user, $request->timestamp);

        if (!$attendance) {
            throw new FailedResponse('Failed to clock you in!');
        }

        return SuccessResponse::send();
    }
}
