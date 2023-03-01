<?php

namespace App\Models;

use App\Enums\WorkPlaceStatus;
use App\Enums\WorkPlaceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkPlace extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'type'   => WorkPlaceType::class,
        'status' => WorkPlaceStatus::class
    ];

    public function Workers()
    {
        return $this->hasMany(User::class, 'work_place_id', 'id');
    }
}