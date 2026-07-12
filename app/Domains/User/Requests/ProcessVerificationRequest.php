<?php

namespace App\Domains\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:approved,rejected'],
            'rejection_reason' => ['required_if:status,rejected', 'nullable', 'string', 'max:500'],
        ];
    }
}
