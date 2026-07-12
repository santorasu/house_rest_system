<?php

namespace App\Domains\User\Requests;

use App\Domains\User\DTOs\Inputs\UpdateProfileData;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorized via controller/policy
    }

    public function rules(): array
    {
        return [
            'phone' => ['nullable', 'string', 'max:20', 'unique:user_profiles,phone,'.$this->user()->profile?->id],
            'address' => ['nullable', 'string', 'max:500'],
            'avatar_url' => ['nullable', 'url', 'max:255'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function toDTO(): UpdateProfileData
    {
        return new UpdateProfileData(
            phone: $this->validated('phone'),
            address: $this->validated('address'),
            avatar_url: $this->validated('avatar_url'),
            emergency_contact_name: $this->validated('emergency_contact_name'),
            emergency_contact_phone: $this->validated('emergency_contact_phone'),
        );
    }
}
