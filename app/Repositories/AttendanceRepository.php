<?php

namespace App\Repositories;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AttendanceRepository extends BaseRepository
{
    /**
     * @param Attendance $attendance
     */
    public function __construct(Attendance $attendance)
    {
        parent::__construct($attendance);
    }

    /**
     * @param int $workerId
     * 
     * @return Collection
     */
    public function todayAttendance(int $workerId): Collection
    {
        return $this->model->where('worker_id', $workerId)->whereDate('clock_in', Carbon::today())->get();
    }
}
