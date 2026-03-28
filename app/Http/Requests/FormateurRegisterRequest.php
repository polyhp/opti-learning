<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormateurRegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'string', 'in:male,female'],
            'birth_date' => ['required', 'date'],
            'birth_place' => ['required', 'string', 'max:255'],
            'expertise_domain' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted'],
            'diploma_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'id_card_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'certificate_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }
}
