<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PassimpayDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'amount',
        'txhash',
        'address_from',
        'address_to',
        'confirmations',
        'destination_tag',
    ];

    protected $appends = [
        'currency',
    ];

    protected function currency(): Attribute
    {
        return new Attribute(
            get: fn () => [
                10 => 'BTC (BTC)',
                20 => 'ETH (ETH)',
                70 => 'USDT (ERC-20)',
                71 => 'USDT (TRC-20)',
                100 => 'USDC (ERC-20)',
                40 => 'DOGE (DOGE)',
                130 => 'BNB (BNB)',
                50 => 'BCH (BCH)',
                232 => 'SOL (BEP29)',
            ][$this->payment_id],
        );
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'details');
    }
}
