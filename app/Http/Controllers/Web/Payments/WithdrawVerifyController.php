<?php

namespace App\Http\Controllers\Web\Payments;

use App\Exceptions\CodeIsExpiredException;
use App\Exceptions\InvalidCodeException;
use App\Exceptions\NotEnoughMoneyException;
use App\Exceptions\TooManyAttempsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Payments\WithdrawVerifyRequest;
use App\Services\Balances\BalancesService;
use App\Services\Verification\Code;
use Illuminate\Support\Facades\Auth;

class WithdrawVerifyController extends Controller
{
    public function __construct(
        public BalancesService $balancesService
    )
    {
        
    }

    public function __invoke(WithdrawVerifyRequest $request)
    {
        try {
            $code = new Code('withdraw');
            $code->verify($request->input('code'));

            $data = $code->data();

            $creator = Auth::guard('web')->user();

            $this->balancesService->createWithdrawalRequest($creator, $data);

            $code->forget();

            return response(['message' => 'OK',]);
        } catch (TooManyAttempsException $e) {
            return response(['message' => 'Too many attemps.',], 400);
        } catch (CodeIsExpiredException $e) {
            return response(['message' => 'Code is expired.',], 400);
        } catch (InvalidCodeException $e) {
            return response(['message' => 'Invalid code.',], 400);
        } catch (NotEnoughMoneyException $e) {
            return response(['message' => 'Your balance is too low!',], 400);
        }
    }
}
