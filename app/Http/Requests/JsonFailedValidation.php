<?php
namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

trait JsonFailedValidation
{
    /**
     * @param Validator $validator
     * 
     * @throws FailedResponse
     */
    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'status'    => false,
            'errors'     => $validator->errors()
        ], 422);
        
        throw new ValidationException($validator, $response);
    }
}