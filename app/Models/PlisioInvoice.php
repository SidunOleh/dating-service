<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Log;

class PlisioInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'txn_id',
        'invoice_url',
        'amount',
        'received',
        'currency',
        'wallet_hash',
        'source_amount',
        'source_currency',
        'source_rate',
        'invoice_sum',
        'invoice_commission',
        'invoice_total_sum',
        'qr_code',
        'expire_at_utc',
        'order_number',
        'order_name',
        'status',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'order_number');
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'details');
    }

    public function creator(): Creator
    {
        return $this->transaction->creator;
    }

    public function webhookCallback(array $data): void
    {
        $this->update([
            'received' => $data['amount'],
            'status' => $data['status'],
        ]);

        $this->transaction->update([
            'status' => $data['status'],
        ]);

        Log::info('', $data);

        Log::info('', [$this->transaction->creator->email]);

        if (in_array($data['status'], ['expired', 'completed', 'mismatch',])) {
            Log::info('sum', [[$this->transaction->creator->balance + (float) $data['amount'] / (float) $data['source_rate']]]);
            $this->transaction->creator->balance += 
                (float) $data['amount'] / (float) $data['source_rate'];
            $this->transaction->creator->save();
        }
    }
}
