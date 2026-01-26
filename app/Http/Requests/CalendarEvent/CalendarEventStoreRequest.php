<?php

namespace App\Http\Requests\CalendarEvent;

use Illuminate\Foundation\Http\FormRequest;

class CalendarEventStoreRequest extends FormRequest
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
                'date',
            ],
            'end' => [
                'nullable',
                'date',
                'after_or_equal:start',
            ],
            'time_period' => [
                'nullable',
                'string',
                'in:午前,午後',
            ],
            'vehicle_info' => [
                'nullable',
                'string',
                'max:255',
            ],
            'repair_type' => [
                'nullable',
                'array',
                'max:7',
            ],
            'repair_type.*' => [
                'string',
                'max:255',
            ],
            'work_type' => [
                'nullable',
                'string',
                'in:入庫作業,出張作業',
            ],
            'workers' => [
                'nullable',
                'array',
                'max:3',
            ],
            'workers.*' => [
                'string',
                'max:255',
            ],
            'status' => [
                'nullable',
                'string',
                'in:未開始,作業中,見積り保留中,部品待ち保留中,完了,連絡済み',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'is_delayed' => [
                'nullable',
                'boolean',
            ],
            'images' => [
                'nullable',
                'array',
                'max:10',
            ],
            'images.*' => [
                'string',
                'max:255',
            ],
        ];
    }
}
