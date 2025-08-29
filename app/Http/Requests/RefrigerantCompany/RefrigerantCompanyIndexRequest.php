<?php

namespace App\Http\Requests\RefrigerantCompany;

use Illuminate\Foundation\Http\FormRequest;

class RefrigerantCompanyIndexRequest extends FormRequest
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