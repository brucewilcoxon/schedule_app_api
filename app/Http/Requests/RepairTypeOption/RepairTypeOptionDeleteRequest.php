<?php

namespace App\Http\Requests\RepairTypeOption;

use Illuminate\Foundation\Http\FormRequest;

class RepairTypeOptionDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}

