<?php

namespace App\Services\Balances;

use App\Constants\Balances;
use App\Constants\Transactions;
use App\Events\WithdrawRequestRejected;
use App\Events\WithdrawRequestSuccess;
use App\Exceptions\NotEnoughMoneyException;
use App\Exceptions\PaymentGatewayNotFoundException;
use App\Models\Balance2Transaction;
use App\Models\Creator;
use App\Models\PassimpayDeposit;
use App\Models\PassimpayWithdrawal;
use App\Models\PassimpayWithdrawalRequest;
use App\Models\PlisioWithdrawalRequest;
use App\Models\Transaction;
use App\Models\TransferRequest;
use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Services\PaymentGateways\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalancesService
{
    public function depositBalance(
        Creator $creator, 
        float $amount, 
        string $gateway, 
        array $data = []
    ): Transaction
    {
        $paymentGateway = PaymentGateway::create($gateway);

        $transaction = $paymentGateway->deposit($creator, $amount, $data);

        return $transaction;
    }

    public function handleDepositWebhook(string $gateway, Request $request): Transaction
    {
        $paymentGateway = PaymentGateway::create($gateway);

        DB::beginTransaction();

        $transaction = $paymentGateway->handleWebhook($request);

        if ($gateway == Transactions::GATEWAYS['crypto'] and 
            $transaction->status == Transactions::PASSIMPAY_DEPOSIT_STATUS['transfered']) {
            $transaction->creator->creditMoney($transaction->amount);
        }

        DB::commit();

        return $transaction;
    }

    public function createWithdrawalRequest(Creator $creator, array $data): WithdrawalRequest
    {
        if (! $creator->hasEnoughMoney($data['amount'])) {
            throw new NotEnoughMoneyException();
        }

        if ($data['gateway'] == Transactions::GATEWAYS['plisio']) {
            $details = PlisioWithdrawalRequest::create([
                'to' => $data['to'],
                'currency' => $data['currency'],
            ]);
        } elseif ($data['gateway'] == Transactions::GATEWAYS['crypto']) {
            $details = PassimpayWithdrawalRequest::create([
                'address_to' => $data['address_to'],
                'payment_id' => $data['payment_id'],
            ]);
        } else {
            throw new PaymentGatewayNotFoundException();
        }

        $request = $details->common()->create([
            'gateway' => $data['gateway'],
            'amount' => $data['amount'],
            'creator_id' => $creator->id,
            'status' => Transactions::WITHDRAWAL_REQUEST_STATUS['pending'],
        ]);

        return $request;
    }

    public function rejectWithdrawalRequest(WithdrawalRequest $request, User $user): void
    {
        $request->update([
            'user_id' => $user->id,
            'status' => Transactions::WITHDRAWAL_REQUEST_STATUS['rejected'],
        ]);

        WithdrawRequestRejected::dispatch($request);
    }

    public function withdrawBalance(Creator $creator, WithdrawalRequest $request, User $user): Transaction
    {
        if (! $creator->hasEnoughMoney($request->amount)) {
            throw new NotEnoughMoneyException();
        }

        $paymentGateway = PaymentGateway::create($request->gateway);

        DB::beginTransaction();

        $transaction = $paymentGateway->withdraw(
            $creator, 
            $request->amount, 
            $request->concrete->getData()
        );

        $creator->debitMoney($request->amount);

        $request->update([
            'user_id' => $user->id,
            'status' => Transactions::WITHDRAWAL_REQUEST_STATUS['completed'],
        ]);

        DB::commit();

        WithdrawRequestSuccess::dispatch($request);

        return $transaction;
    }

    public function updateWithdrawalStatus(Creator $creator, Transaction $transaction): void
    {
        $status = $transaction->status;

        $gateway = PaymentGateway::create($transaction->gateway);

        DB::beginTransaction();

        $gateway->updateWithdrawalStatus($transaction);

        if (
            $transaction->gataway = Transactions::GATEWAYS['crypto'] and
            $transaction->status != $status and 
            $transaction->status == Transactions::PASSIMPAY_WITHDRAWAL_STATUS['error']
        ) {
            $creator->balance += $transaction->amount;
            $creator->save();
        }

        DB::commit();
    }

    public function transferBalanceBalance2(Creator $creator, float $amount): Balance2Transaction
    {
        if (! $creator->hasEnoughMoney($amount)) {
            throw new NotEnoughMoneyException();
        }

        DB::beginTransaction();

        $creator->debitMoney($amount);
        
        $transaction = $this->creditBalance2($creator, $amount, Transactions::BALANCE_2_TYPE['transfer_balance_balance_2']);

        DB::commit();

        return $transaction;
    }

    public function balanceBalace2TransfersStat(Creator $creator, ?string $interval = null): float
    {   
        $transactions = $creator->balance2Transactions()->where([
            'type' => Transactions::BALANCE_2_TYPE['transfer_balance_balance_2'],
        ]);

        if ($interval == 'month') {
            $transactions->whereRaw("YEAR(`created_at`) = " . date('Y'))
                ->whereRaw("MONTH(`created_at`) = " . date('m'));
        }

        if ($interval == 'week') {
            $transactions->whereRaw("YEAR(`created_at`) = " . date('Y'))
                ->whereRaw("WEEK(`created_at`) = " . date('W') - 1);
        }

        if ($interval == 'day') {
            $transactions->whereRaw('YEAR(`created_at`) = ' . date('Y'))
                ->whereRaw('MONTH(`created_at`) = ' . date('m'))
                ->whereRaw('DAY(`created_at`) = ' . date('d'));
        }

        return $transactions->sum('amount');
    }

    public function autoCreditToBalance2(Creator $creator): float
    {
        if ($creator->hasEnoughMoney(Balances::AUTO_CREDIT_AMOUNT, 'balance_2_total')) {
            return 0;
        }

        DB::beginTransaction();

        $amount = Balances::AUTO_CREDIT_AMOUNT - $creator->balance_2_total;

        $creator->creditMoney($amount, 'balance_2_auto');

        Balance2Transaction::create([
            'type' => Transactions::BALANCE_2_TYPE['auto_credit'],
            'amount' => $amount,
            'creator_id' => $creator->id,
        ]);
        
        DB::commit();

        return $amount;
    }

    public function creditBalance2(Creator $creator, float $amount, string $type): Balance2Transaction
    {
        DB::beginTransaction();

        $creator->creditMoney($amount, 'balance_2');

        $transaction = Balance2Transaction::create([
            'type' => $type,
            'amount' => $amount,
            'creator_id' => $creator->id,
        ]);

        DB::commit();

        return $transaction;
    }

    public function debitBalance2(Creator $creator, float $amount, string $type): Balance2Transaction
    {   
        if (! $creator->hasEnoughMoney($amount, 'balance_2_total')) {
            throw new NotEnoughMoneyException();
        }

        DB::beginTransaction();

        $fromBalance2Auto = $creator->balance_2_auto >= $amount ? $amount : $creator->balance_2_auto;

        if ($fromBalance2Auto > 0) {
            $creator->debitMoney($fromBalance2Auto, 'balance_2_auto');
        }

        $fromBalance2 = $amount - $fromBalance2Auto;

        if ($fromBalance2 > 0) {
            $creator->debitMoney($fromBalance2, 'balance_2');
        }

        $transaction = Balance2Transaction::create([
            'type' => $type,
            'amount' => $amount,
            'creator_id' => $creator->id,
        ]);

        DB::commit();

        return $transaction;
    }

    public function createTransferRequest(Creator $creator, float $amount): TransferRequest
    {
        if (! $creator->hasEnoughMoney($amount, 'balance_2')) {
            throw new NotEnoughMoneyException();
        }

        DB::beginTransaction();

        $transferRequest = TransferRequest::create([
            'amount' => $amount,
            'status' => Transactions::TRANSFER_REQUEST_STATUS['pending'],
            'creator_id' => $creator->id,
        ]);

        $creator->debitMoney($transferRequest->amount, 'balance_2');

        DB::commit();

        return $transferRequest;
    }

    public function rejectTransferRequest(Creator $creator, TransferRequest $transferRequest): void
    {
        DB::beginTransaction();

        $transferRequest->update(['status' => Transactions::TRANSFER_REQUEST_STATUS['rejected']]);

        $creator->creditMoney($transferRequest->amount, 'balance_2');

        DB::commit();
    }

    public function transferBalance2Balance(Creator $creator, TransferRequest $transferRequest): void
    {
        if (! $creator->hasEnoughMoney($transferRequest->amount, 'balance_2')) {
            throw new NotEnoughMoneyException();
        }

        DB::beginTransaction();

        $creator->debitMoney($transferRequest->amount, 'balance_2');

        $creator->creditMoney($transferRequest->amount);

        Balance2Transaction::create([
            'type' => Transactions::BALANCE_2_TYPE['transfer_balance_2_balance'],
            'amount' => $transferRequest->amount,
            'creator_id' => $creator->id,
        ]);

        $transferRequest->update(['status' => Transactions::TRANSFER_REQUEST_STATUS['approved']]);

        DB::commit();
    }

    public function getTransactionList(Creator $creator): array
    {
        $transactions = $creator->transactions()
            ->with('details')
            ->get();
        $list = $transactions->filter(function (Transaction $transaction) {
            if ($transaction->details instanceof PassimpayDeposit) {
                return $transaction->amount > 0;
            } elseif ($transaction->details instanceof PassimpayWithdrawal)  {
                return in_array($transaction->status, [Transactions::PASSIMPAY_WITHDRAWAL_STATUS['succes'], Transactions::PASSIMPAY_WITHDRAWAL_STATUS['pending'],]);
            } else {
                return false;
            }
        });

        $withdrawalRequests = $creator->withdrawalRequests()
            ->where('status', Transactions::WITHDRAWAL_REQUEST_STATUS['pending'])
            ->with('concrete')
            ->get();
        foreach ($withdrawalRequests as $withdrawalRequest) {
            $list->push($withdrawalRequest);
        }

        $list = $list->sortByDesc('created_at');

        $formattedList = [];
        foreach ($list as $item) {
            if (
                $item instanceof Transaction and 
                $item->details instanceof PassimpayDeposit
            ) {
                $formattedItem['type'] = 'IN';
                $formattedItem['amount'] = $item->details->amount;
                $formattedItem['currency'] = $item->details->currency;
            } elseif (
                $item instanceof Transaction and 
                $item->details instanceof PassimpayWithdrawal
            ) {
                $formattedItem['type'] = $item->details->status == Transactions::PASSIMPAY_WITHDRAWAL_STATUS['succes'] ? 'OUT' : 'OUT(pending)';
                $formattedItem['amount'] = $item->details->amount;
                $formattedItem['currency'] = $item->details->currency;
            } elseif (
                $item instanceof WithdrawalRequest and 
                $item->concrete instanceof PassimpayWithdrawalRequest
            ) {
                $formattedItem['type'] = 'WITHDRAWAL REQUEST';
                $formattedItem['amount'] = $item->amount;
                $formattedItem['currency'] = 'Coin';
            } else {
                continue;
            }

            $formattedItem['date'] = $item->created_at->format('M d, Y');

            $formattedList[] = $formattedItem;
        }

        return $formattedList;
    }
}