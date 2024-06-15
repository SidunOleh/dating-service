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
        'usd_amount',
        'status',
        'concrete_type',
        'concrete_id',
        'creator_id',
        'user_id',
    ];

    protected $cast = [
        'usd_amount' => 'float',
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
        if (! $this->creator->hasEnoughMoney($this->usd_amount)) {
            throw new Exception('Not enough money on creator\'s balance.');
        }

        $transaction = $this->concrete->withdraw();

        if ($transaction->status == 'completed') {
            $this->creator->debitMoney($this->usd_amount);
        }

        $this->user_id = Auth::id();
        $this->status = $transaction->status;
        $this->save();

        return $transaction;
    }
}
