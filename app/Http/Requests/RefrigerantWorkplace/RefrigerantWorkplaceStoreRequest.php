<?php

namespace App\Http\Requests\RefrigerantWorkplace;

use Illuminate\Foundation\Http\FormRequest;

class RefrigerantWorkplaceStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business' => 'required|string|max:255',
            'residence' => 'nullable|string|max:255',
            'vehicle_registration_number' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'machine_type' => 'nullable|string|max:255',
            'gas_type' => 'nullable|string|max:255',
            'initial_fill_amount' => 'nullable|numeric|min:0',
            'is_selected' => 'boolean',
        ];
    }
}
