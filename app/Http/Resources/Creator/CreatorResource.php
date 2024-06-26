<?php

namespace App\Http\Resources\Creator;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_banned' => $this->is_banned,
            'show_on_site' => $this->show_on_site,
            'play_roulette' => $this->play_roulette,

            'email' => $this->email,

            'photos' => $this->gallery,

            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender,
            'description' => $this->description,

            'phone' => $this->phone,
            'profile_email' => $this->profile_email, 
            'instagram' => $this->instagram,
            'telegram' => $this->telegram,
            'snapchat' => $this->snapchat,
            'onlyfans' => $this->onlyfans,
            'whatsapp' => $this->whatsapp,

            'full_address' => $this->full_address,
            'country' => $this->country,
            'region' => $this->region,
            'city' => $this->city,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthday' => $this->birthday?->format('Y-m-d'),
            'verification_photo' => $this->verificationPhoto,
            'id_photo' => $this->idPhoto,
            'street_photo' => $this->streetPhoto,

            'balance' => $this->balance,
            'referral_link' => url("/?ref={$this->referral_code}"),
            'referrals' => $this->referrals()
                ->orderBy('created_at', 'DESC')
                ->get()
                ->map(fn ($referral) => [
                        'id' => $referral->referee_id,
                        'email' => $referral->referee->email,
                        'reward' => $referral->reward,
                        'created_at' => $referral->created_at,
                ]),

            'transactions' => $this->transactions()
                ->orderBy('created_at', 'DESC')
                ->get()
                ->map(fn ($transaction) => [
                    'id' => $transaction->id,
                    'gateway' => $transaction->gateway,
                    'type' => $transaction->type,
                    'usd_amount' => $transaction->usd_amount,
                    'status' => $transaction->status,
                    'creator' => $transaction->creator ? [
                        'id' => $transaction->creator->id,
                        'email' => $transaction->creator->email,
                    ] : null,
                    'created_at' => $transaction->created_at,
                    'details' => $transaction->details,
                ]),
        ];
    }
}
