<?php

namespace App\Domains\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document_type' => ['required', 'string', 'in:passport,national_id,driving_license,property_deed,business_license'],
            'document' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // Max 5MB
        ];
    }
}
