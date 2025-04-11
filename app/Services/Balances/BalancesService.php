<?php

namespace App\Services\Balances;

use App\Constants\Balances;
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
        $this->creditMoney($creator, $amount, Balances::Balance2);

        $balancesTransfer = BalancesTransfer::create([
            'from' => Balances::Balance,
            'to' => Balances::Balance2,
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
            Balances::Balance2Total
        )) {
            return 0;
        }

        $amount = Balances::AUTO_CREDIT_AMOUNT - $creator->{Balances::Balance2Total};

        $this->creditMoney($creator, $amount, Balances::Balance2Auto);

        return $amount;
    }

    public function hasEnoughMoney(
        Creator $creator, 
        float $amount, 
        string $balance = Balances::Balance
    ): bool
    {
        return $amount <= $creator->{$balance};
    }

    public function debitMoney(
        Creator $creator, 
        float $amount, 
        string $balance = Balances::Balance
    ): void
    {
        $creator->{$balance} -= $amount;
        $creator->save();
    }

    public function creditMoney(
        Creator $creator, 
        float $amount, 
        string $balance = Balances::Balance
    ): void
    {
        $creator->{$balance} += $amount;
        $creator->save();
    }

    public function transfersStat(Creator $creator, ?string $interval = null): float
    {   
        $balancesTransfers = $creator->balancesTransfers()->where([
            'from' => Balances::Balance,
            'to' => Balances::Balance2,
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