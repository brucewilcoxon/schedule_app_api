<?php

namespace App\Http\Requests\RepairTypeOption;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RepairTypeOptionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('repair_type_options', 'name'),
            ],
            'order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }
}
