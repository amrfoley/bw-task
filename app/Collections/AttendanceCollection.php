<?php

namespace App\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AttendanceCollection extends ResourceCollection
{
    public function toArray($request = null)
    {
        return [
            'data' => AttendanceResource::collection($this->collection),
        ];
    }
}
