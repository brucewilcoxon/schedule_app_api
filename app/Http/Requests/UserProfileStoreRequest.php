<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => $this->name ?: null,
            'gender' => $this->gender ?: null,
            'age' => $this->age ?: null,
            'introduction' => $this->introduction ?: null,
            'profile_image' => $this->profile_image ?: null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => [
                'string',
                'nullable',
                'max:255',
            ],
            "gender" => [
                'string',
                'nullable',
                'in:male,female,other',
            ],
            "age" => [
                'string',
                'nullable',
                'max:3',
            ],
            "introduction" => [
                'string',
                'nullable',
                'max:255',
            ],
            "profile_image" => [
                'string',
                'nullable'
            ]
        ];
    }
}
