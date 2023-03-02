<?php

namespace App\Http\Requests;

use App\Rules\Timestamp;
use Illuminate\Foundation\Http\FormRequest;

class ClockInRequest extends FormRequest
{
    use JsonFailedValidation;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'worker_id' => ['required', 'int'],
            'timestamp' => ['required', 'numeric', new Timestamp],
            'latitude'  => ['required', 'decimal:-90,90'],
            'longitude' => ['required', 'decimal:-180,180'],
        ];
    }
}
