<?php

namespace App\Http\Requests\RefrigerantWorkplace;

use Illuminate\Foundation\Http\FormRequest;

class RefrigerantWorkplaceDeleteRequest extends FormRequest
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
