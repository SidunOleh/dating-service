<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PassimpayWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'address_to',
        'amount',
        'transaction_id',
        'txhash',
        'confirmations',
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
            ][$this->payment_id],
        );
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'details');
    }
}
