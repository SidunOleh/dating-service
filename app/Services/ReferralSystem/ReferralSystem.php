<?php

namespace App\Services\ReferralSystem;

use App\Constants\Referral as ConstantsReferral;
use App\Models\Creator;
use App\Models\Option;
use App\Models\Post;
use App\Models\Referral;
use App\Models\Subscription;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

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

    public function payPercentSubscription(Creator $creator, Subscription $subscription): void
    {
        DB::beginTransaction();

        $settings = Option::getSettings();

        $earnAmount = $settings['subscription_price'] * $settings['referral_percent'] / 100;
        $restAmount = $settings['subscription_price'] - $earnAmount;

        $referrer = $creator->referral?->referrer;
        for ($i=0; $i < 3; $i++) { 
            if (! $referrer) {
                break;
            }

            $referrer->creditMoney($restAmount * ConstantsReferral::PCTS[$i], 'balance_earn');

            $referrer = $referrer->referral?->referrer;
        }

        DB::commit();
    }

    public function payPercentPostOpen(Creator $creator, Post $post, float $amount): void
    {
        DB::beginTransaction();

        $settings = Option::getSettings();

        $earnAmount = $amount * $settings['referral_percent'] / 100;
        $restAmount = $amount - $earnAmount;

        $post->creator->creditMoney($earnAmount, 'balance_earn');

        $referrer = $post->creator->referral?->referrer;
        for ($i=0; $i < 3; $i++) { 
            if (! $referrer) {
                break;
            }

            $referrer->creditMoney($restAmount * ConstantsReferral::PCTS[$i], 'balance_earn');

            $referrer = $referrer->referral?->referrer;
        }

        $referrer = $creator->referral?->referrer;
        for ($i=0; $i < 3; $i++) { 
            if (! $referrer) {
                break;
            }

            $referrer->creditMoney($restAmount * ConstantsReferral::PCTS[$i], 'balance_earn');

            $referrer = $referrer->referral?->referrer;
        }

        DB::commit();
    }
}