<?php

namespace App\Domains\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestTenancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'owner_id' => ['required', 'integer', 'exists:users,id'],
            'property_id' => ['nullable', 'integer'], // No properties table yet
            'lease_start_date' => ['required', 'date'],
        ];
    }
}
