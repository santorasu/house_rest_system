<?php

namespace App\Domains\User\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // $this->resource is expected to be a UserProfileResponseData DTO
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'phone' => $this->resource->phone,
            'address' => $this->resource->address,
            'avatar_url' => $this->resource->avatar_url,
            'emergency_contact_name' => $this->resource->emergency_contact_name,
            'emergency_contact_phone' => $this->resource->emergency_contact_phone,
            'is_profile_completed' => $this->resource->is_profile_completed,
            'created_at' => $this->resource->created_at,
        ];
    }
}
