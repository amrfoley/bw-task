<?php

namespace App\Repositories;

use App\Models\Attendance;

class AttendanceRepository extends BaseRepository
{
    public function __construct(Attendance $attendance)
    {
        parent::__construct($attendance);
    }
}
