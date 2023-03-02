<?php

namespace App\Collections;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'clock-in'  => Carbon::parse($this->clock_in)->format('d M Y H:i:s'),
        ];
    }
}
