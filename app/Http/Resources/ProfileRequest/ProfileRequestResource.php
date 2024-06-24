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
            $photos['value'] = $this->gallery->map(fn ($img) => [
                'id' => $img->id, 
                'url' => $img->url(),
            ]);
        }
        
        if ($verificationPhoto = $this->verification_photo) {
            $verificationPhoto['value'] = ($photo = $this->verificationPhoto) ? [
                'id' => $photo->id,
                'url' => $photo->url(),
            ] : null; 
        }

        if ($idPhoto = $this->id_photo) {
            $idPhoto['value'] = ($photo = $this->idPhoto) ? [
                'id' => $photo->id,
                'url' => $photo->url(),
            ] : null; 
        }

        if ($streetPhoto = $this->street_photo) {
            $streetPhoto['value'] = ($photo = $this->streetPhoto) ? [
                'id' => $photo->id,
                'url' => $photo->url(),
            ] : null; 
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
