<?php

namespace App\Models;

use App\Models\WithdrawalRequest as ModelsWithdrawalRequest;
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

    public function getData(): array
    {
        return ['currency' => $this->currency, 'to' => $this->to,];
    }
}
