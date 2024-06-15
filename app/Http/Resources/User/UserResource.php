<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        $data['id'] = $this->id;
        $data['email'] = $this->email;
        $data['permissions'] = $this
            ->getAllPermissions()
            ->map(fn ($permission) => $permission->name);
        
        return $data;
    }
}
