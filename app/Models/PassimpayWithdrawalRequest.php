<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PassimpayWithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'address_to',
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

    public function common(): MorphOne
    {
        return $this->morphOne(WithdrawalRequest::class, 'concrete');
    }

    public function withdraw(): Transaction
    {
        $transaction = $this->common->creator->withdraw(
            'crypto', 
            $this->common->amount, 
            ['payment_id' => $this->payment_id, 'address_to' => $this->address_to,]
        );

        return $transaction;
    }
}
