<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway',
        'amount',
        'status',
        'concrete_type',
        'concrete_id',
        'creator_id',
        'user_id',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function concrete(): MorphTo
    {
        return $this->morphTo();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function withdraw(): Transaction
    {
        if (! $this->creator->hasEnoughMoney($this->amount)) {
            throw new Exception('Your balance is too low!');
        }

        $transaction = $this->concrete->withdraw();

        $this->creator->debitMoney($this->amount);

        $this->user_id = Auth::guard('admin')->id();
        $this->status = 'completed';
        $this->save();

        return $transaction;
    }

    public static function createRequest(array $data): self
    {
        switch ($data['gateway']) {
            case 'plisio':
                $request = PlisioWithdrawalRequest::create([
                    'to' => $data['to'],
                    'currency' => $data['currency'],
                ]);
            break;
            case 'crypto':
                $request = PassimpayWithdrawalRequest::create([
                    'address_to' => $data['address_to'],
                    'payment_id' => $data['payment_id'],
                ]);
            break;
            default:
                throw new Exception("Not found gateway {$data['gateway']}.");
        }

        return $request->common()->create([
            'gateway' => $data['gateway'],
            'amount' => $data['amount'],
            'creator_id' => Auth::guard('web')->id(),
        ]);
    }
}
