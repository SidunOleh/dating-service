<?php

namespace App\Services\Balances;

use App\Constants\Balances;
use App\Enums\Balances as EnumsBalances;
use App\Exceptions\NotEnoughMoneyException;
use App\Models\BalancesTransfer;
use App\Models\Creator;
use Illuminate\Support\Facades\DB;

class BalancesService
{
    public function transfer(Creator $creator, float $amount): BalancesTransfer
    {
        if (! $this->hasEnoughMoney($creator, $amount)) {
            throw new NotEnoughMoneyException();
        }

        DB::beginTransaction();

        $this->debitMoney($creator, $amount);
        $this->creditMoney($creator, $amount, EnumsBalances::Balance2->value);

        $balancesTransfer = BalancesTransfer::create([
            'from' => EnumsBalances::Balance->value,
            'to' => EnumsBalances::Balance2->value,
            'amount' => $amount,
            'creator_id' => $creator->id,
        ]);

        DB::commit();

        return $balancesTransfer;
    }

    public function autoCreditMoney(Creator $creator): float
    {
        if ($this->hasEnoughMoney(
            $creator, 
            Balances::AUTO_CREDIT_AMOUNT, 
            EnumsBalances::Balance2Total->value
        )) {
            return 0;
        }

        $amount = Balances::AUTO_CREDIT_AMOUNT - $creator->{EnumsBalances::Balance2Total->value};

        $this->creditMoney($creator, $amount, EnumsBalances::Balance2Auto->value);

        return $amount;
    }

    public function hasEnoughMoney(
        Creator $creator, 
        float $amount, 
        string $balance = EnumsBalances::Balance->value
    ): bool
    {
        return $amount <= $creator->{$balance};
    }

    public function debitMoney(
        Creator $creator, 
        float $amount, 
        string $balance = EnumsBalances::Balance->value
    ): void
    {
        $creator->{$balance} -= $amount;
        $creator->save();
    }

    public function creditMoney(
        Creator $creator, 
        float $amount, 
        string $balance = EnumsBalances::Balance->value
    ): void
    {
        $creator->{$balance} += $amount;
        $creator->save();
    }

    public function transfersStat(Creator $creator, ?string $interval = null): float
    {   
        $balancesTransfers = $creator->balancesTransfers()->where([
            'from' => EnumsBalances::Balance->value,
            'to' => EnumsBalances::Balance2->value,
        ]);

        if ($interval == 'month') {
            $balancesTransfers->whereRaw("YEAR(`created_at`) = " . date('Y'))
                ->whereRaw("MONTH(`created_at`) = " . date('m'));
        }

        if ($interval == 'week') {
            $balancesTransfers->whereRaw("YEAR(`created_at`) = " . date('Y'))
                ->whereRaw("WEEK(`created_at`) = " . date('W') - 1);
        }

        if ($interval == 'day') {
            $balancesTransfers->whereRaw('YEAR(`created_at`) = ' . date('Y'))
                ->whereRaw('MONTH(`created_at`) = ' . date('m'))
                ->whereRaw('DAY(`created_at`) = ' . date('d'));
        }

        return $balancesTransfers->sum('amount');
    }
}