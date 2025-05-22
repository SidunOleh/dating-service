<?php

namespace App\Constants;

class Referral
{
    public const PCTS = [
        0.125, 
        0.075, 
        0.05,
    ];

    public const REWARD_STATUS = [
        'pending' => 'pending',
        'completed' => 'completed',
        'rejected' => 'rejected',
    ];
}