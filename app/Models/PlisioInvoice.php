<?php

namespace App\Models;

use App\PaymentGateways\Plisio\Invoice\InvoiceRequest;
use App\PaymentGateways\Plisio\PlisioClient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

class PlisioInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'txn_id',
        'invoice_url',
        'amount',
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

    public static function makeTransaction(string $currency, float $amount): Transaction
    {
        $creator = Auth::guard('web')->user();

        $plisioClient = new PlisioClient(env('PLISIO_SECRET_KEY'));

        $invoiceRequest = new InvoiceRequest(
            uniqid($creator->id, true), 
            'deposit', 
            currency: $currency,
            sourceAmount: $amount, 
            sourceCurrency: 'USD'
        );
        $invoiceResponse = $plisioClient->createWhiteLabelInvoice($invoiceRequest);

        $plisioInvoice = self::create($invoiceResponse->toArray());
        
        $transaction = Transaction::create([
            'gateway' => 'plisio',
            'type' => 'invoice',
            'usd_amount' => $amount,
            'status' => 'new',
            'details_type' => self::class,
            'details_id' => $plisioInvoice->id,
            'creator_id' => $creator->id,
        ]);

        return $transaction;
    }

    public function change(array $data): void
    {
        $this->amount = $data['amount'];
        $this->status = $data['status'];
        $this->save();
        
        $this->transaction->status = $data['status'];
        $this->transaction->save();

        if (in_array($data['status'], ['expired', 'completed', 'mismatch',])) {
            $this->creator->balance += 
                (float) $data['amount'] / (float) $data['source_rate'];
            $this->creator->save();
        }
    }
}
