<?php

namespace App\Http\Requests\CalendarEvent;

use Illuminate\Foundation\Http\FormRequest;

class CalendarEventUpdateRequest extends FormRequest
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
            'start' => [
                'required',
                'date'
            ],
            'end' => [
                'nullable',
                'date',
                'after_or_equal:start'
            ],
            'vehicle_info' => [
                'nullable',
                'string',
                'max:255'
            ],
            'repair_type' => [
                'nullable',
                'string',
                'max:255'
            ],
            'workers' => [
                'nullable',
                'array',
                'max:3'
            ],
            'workers.*' => [
                'string',
                'max:255'
            ],
            'status' => [
                'nullable',
                'string',
                'in:未開始,進行中,完了'
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'is_delayed' => [
                'nullable',
                'boolean'
            ]
        ];
    }
}
