<?php

namespace App\Models;

use App\Models\WithdrawalRequest as ModelsWithdrawalRequest;
use App\PaymentGateways\Plisio\PlisioClient;
use App\PaymentGateways\Plisio\Withdrawal\WithdrawalRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PlisioWithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency',
        'to',
    ];

    public function common(): MorphOne
    {
        return $this->morphOne(ModelsWithdrawalRequest::class, 'concrete');
    }

    public function withdraw(): Transaction
    {
        $transaction = $this->common->creator->withdraw(
            'plisio', 
            $this->common->amount, 
            ['currency' => $this->currency, 'to' => $this->to,]
        );

        return $transaction;
    }
}
