<?php

namespace App\Http\Requests\Departure;

use Illuminate\Foundation\Http\FormRequest;

class DepartureStoreRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'intra_user_id' => [
                'nullable',
                'integer'
            ],
            'start' => [
                'required',
                'date_format:Y-m-d\TH:i:sP'
            ],
            'end' => [
                'required',
                'date_format:Y-m-d\TH:i:sP'
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ];
    }
}
