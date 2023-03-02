<?php

namespace App\Http\Responses\Api;

class SuccessResponse
{
    public static function send(array $data = [], int $code = 200)
    {
        $response['status'] = true;
        if (!empty($data)) {
            $response['data'] = $data['data'] ?: $data;
        }

        return response()->json($response);
    }
}
