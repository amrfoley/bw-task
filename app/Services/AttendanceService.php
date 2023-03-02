<?php

namespace App\Services;

use App\Http\Responses\Api\FailedResponse;
use App\Models\Attendance;
use App\Models\User;
use App\Repositories\AttendanceRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AttendanceService
{
    /**
     * @param AttendanceRepository $attendanceRepository
     */
    public function __construct(protected AttendanceRepository $attendanceRepository)
    {
    }

    /**
     * @param User $user
     * @param int $time
     * 
     * @return Attendance
     */
    public function clockIn(User $user, int $time): Attendance
    {
        if ($this->attendanceRepository->todayAttendance($user->id)->whereNull('clock_out')->first()) {
            throw new FailedResponse('You already clocked in today!');
        }

        return $this->attendanceRepository->create([
            'worker_id' => $user->id,
            'work_place_id' => $user->workPlace->id,
            'clock_in'  => Carbon::createFromTimestamp($time)
        ]);
    }

    /**
     * @param User $user
     * 
     * @return Collection
     */
    public function workerClockIns(User $user): Collection
    {
        return $this->attendanceRepository->attendances($user->id);
    }
}
