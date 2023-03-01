<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['worker_id', 'work_place_id', 'clock_in', 'clock_out'];

    protected $casts = [
        'clock_in'  => 'datetime:Y-m-d H:00',
        'clock_out' => 'datetime:Y-m-d H:00'
    ];

    /**
     * relationship to worker with the User class
     * 
     * @return void
     */
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id', 'id');
    }

    /**
     * relationship to workPlace
     * 
     * @return void
     */
    public function workePlace()
    {
        return $this->belongsTo(WorkPlace::class, 'work_place_id', 'id');
    }
}
