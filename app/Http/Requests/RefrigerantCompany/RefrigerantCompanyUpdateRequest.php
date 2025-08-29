<?php

namespace App\Http\Requests\RefrigerantCompany;

use Illuminate\Foundation\Http\FormRequest;

class RefrigerantCompanyUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item' => 'required|string|max:255',
            'process_type' => 'required|in:collection,filling,collection_filling',
            'delivery_date' => 'required|date',
            'is_selected' => 'boolean',
            'owner' => 'nullable|string|max:255',
            'manager_id' => 'nullable|exists:user_profiles,id',
            'residence' => 'nullable|string|max:255',
        ];
    }
} 