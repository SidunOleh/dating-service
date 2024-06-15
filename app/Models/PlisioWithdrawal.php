<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PlisioWithdrawal extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'amount',
        'currency',
        'type',
        'status',
        'source_currency',
        'source_rate',
        'fee',
        'plisio_id',
        'wallet_hash',
        'sendmany',
    ];

    protected $casts = [
        'sendmany' => 'array', 
    ];

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'details');
    }
}
