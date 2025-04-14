<?php

namespace App\Services\ReferralSystem;

use App\Models\Creator;
use App\Models\Option;
use App\Models\Referral;
use Illuminate\Support\Facades\Cookie;

class ReferralSystem
{
    public function memoryReferralCode(string $code): void
    {
        Cookie::queue(Cookie::make('ref', $code));
    }

    public function createReferral(Creator $creator): ?Referral
    {
        if (
            ($code = Cookie::get('ref') and
            $referrer = Creator::firstWhere('referral_code', $code)) or 
            ($from = Cookie::get('from') and 
            $referrer = Creator::find($from))
        ) {
            $referral = Referral::create([
                'referrer_id' => $referrer->id,
                'referee_id' => $creator->id,
            ]);

            Cookie::queue(Cookie::forget('ref'));
            Cookie::queue(Cookie::forget('from'));

            return $referral;
        }

        return null;
    }

    public function payPercentForSubscription(Creator $creator): false|float
    {
        if (! $creator->referral) {
            return false;
        }

        if ($creator->subscriptions()->count() != 1) {
            return false;
        }

        $settings = Option::getSettings();
                        
        $amount = $settings['subscription_price'] * $settings['referral_percent'] / 100;

        $referrer = $creator->referral->referrer;
        $referrer->creditMoney($amount);

        return $amount;
    }
}