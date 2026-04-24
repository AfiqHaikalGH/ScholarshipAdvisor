<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone_num' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'marital_status' => ['nullable', 'string', 'in:single,married,divorced,widowed'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'birth_state' => ['nullable', 'string', 'max:100'],
            'dob' => ['nullable', 'date'],
            'place_of_study' => ['nullable', 'string', 'max:255'],
            'study_location' => ['nullable', 'string', 'in:Local,Overseas'],
            'study_country' => ['nullable', 'string', 'max:100'],
            'is_top_100_university' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }
}
