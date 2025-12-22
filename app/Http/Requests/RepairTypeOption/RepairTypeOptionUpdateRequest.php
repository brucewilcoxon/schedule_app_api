<?php

namespace App\Http\Requests\RepairTypeOption;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RepairTypeOptionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('repair_type_options', 'name')->ignore($id),
            ],
            'order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }
}
