<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewayWebhookLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway',
        'url',
        'ip',
        'headers',
        'body',
        'exception',
    ];

    protected $casts = [
        'headers' => 'array',
        'body' => 'array',
        'exception' => 'array',
    ];
}
