<?php

namespace App\Http\Responses\Api;

use Exception;
use Throwable;

class FailedResponse extends Exception
{
    public function __construct(string $message = "", int $code = 422, Throwable|null $previous = null)
    {
        $message = !empty($message) ? $message : 'Can\'t proccess your request';
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        return response()->json([
            'status' => false,
            'errors' => [
                'message' => [$this->message]
            ]
        ], $this->code);
    }
}
