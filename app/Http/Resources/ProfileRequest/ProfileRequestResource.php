<?php

namespace App\Http\Resources\ProfileRequest;

use App\Http\Resources\Creator\CreatorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {        
        if ($photos = $this->photos) {
            $photos['value'] = $this->gallery; 
        }

        if ($verificationPhoto = $this->verification_photo) {
            $verificationPhoto['value'] = $this->verificationPhoto; 
        }

        if ($idPhoto = $this->id_photo) {
            $idPhoto['value'] = $this->idPhoto; 
        }

        if ($streetPhoto = $this->street_photo) {
            $streetPhoto['value'] = $this->streetPhoto; 
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'profile_email' => $this->profile_email,
            'instagram' => $this->instagram,
            'telegram' => $this->telegram,
            'snapchat' => $this->snapchat,
            'onlyfans' => $this->onlyfans,
            'whatsapp' => $this->whatsapp,
            'twitter' => $this->twitter,
            'description' => $this->description,
            'photos' => $photos,
            'location' => $this->location,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthday' => $this->birthday,
            'verification_photo' => $verificationPhoto,
            'id_photo' => $idPhoto,
            'street_photo' => $streetPhoto,
            'status' => $this->status,
            'creator' => new CreatorResource($this->creator),
            'created_at' => $this->created_at,
        ];
    }
}
