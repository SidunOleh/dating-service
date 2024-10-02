<?php

namespace App\Models;

use App\Events\CreatorSubscribed;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'starts_at',
        'ends_at',
        'status',
        'unsubscribed',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'unsubscribed' => 'boolean',
    ];

    public const PRICE = 5;

    public const MONTHS = 1;

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    public static function subscribe(Creator $creator): self
    {
        if (! $creator->debitMoney(self::PRICE)) {
            throw new Exception('Not enough Coins on Balance');
        }

        $subscription = self::create([
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addMonths(self::MONTHS),
            'creator_id' => $creator->id,
        ]);

        CreatorSubscribed::dispatch($creator);

        return $subscription;
    }

    public function unsubscribe(): bool
    {
        return $this->update(['unsubscribed' => true,]);
    }

    public function inactivate(): bool
    {
        return $this->update(['status' => 'inactive',]);
    }
}
