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
        $plisioClient = new PlisioClient(env('PLISIO_SECRET_KEY'));

        $rate = $plisioClient->rate('USD', $this->currency);
        $amount = $rate * $this->common->usd_amount;

        $withdrawalResponse = $plisioClient->createWithdrawal(
            new WithdrawalRequest($amount, $this->currency, $this->to, 'cash_out')
        );

        $withdrawal = PlisioWithdrawal::create($withdrawalResponse->toArray());

        $transaction = $withdrawal->transaction()->create([
            'gateway' => 'plsio',
            'type' => 'withdrawal',
            'usd_amount' => $this->common->usd_amount,
            'status' => $withdrawal->status,
            'creator_id' => $withdrawal->creator_id,
        ]);

        return $transaction;
    }
}
