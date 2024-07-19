<?php

namespace App\Http\Resources\Creator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditCreatorData extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'phone' => $this->phone,
            'telegram' => $this->telegram,
            'whatsapp' => $this->whatsapp,
            'snapchat' => $this->snapchat,
            'instagram' => $this->instagram,
            'onlyfans' => $this->onlyfans,
            'profile_email' => $this->profile_email,

            'street' => $this->street,
            'zip' => $this->zip,
            'state' => $this->state,
            'city' => $this->city,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

            'photos' => $this->gallery,

            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender,
            'description' => $this->description,

            'id_photo' => $this->idPhoto,
            'street_photo' => $this->streetPhoto,
            'verification_photo' => $this->verificationPhoto,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthday' => $this->birthday?->format('Y-m-d') ?? '',
        ];
    }
}
