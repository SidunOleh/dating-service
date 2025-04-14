<?php

namespace App\Services\Verification;

use App\Exceptions\CodeIsExpiredException;
use App\Exceptions\CodeNotFoundException;
use App\Exceptions\InvalidCodeException;
use App\Exceptions\TooFastException;
use App\Exceptions\TooManyAttempsException;
use App\Notifications\VerificationCode as NotificationsVerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class Code
{
    private string $action;

    private array $data;

    public function __construct(string $action)
    {
        if (! $data = session($action)) {
            throw new CodeNotFoundException();
        }

        $this->action = $action;

        $this->data = $data;
    }

    public function send(string $email): void
    {
        Notification::route('mail', $email)->notify(new NotificationsVerificationCode($this->data['code']));
    }

    public function resend(string $email): void
    {
        if (now()->lessThan(Carbon::createFromTimestamp($this->data['created_at'] + 60))) {
            throw new TooFastException();
        }

        $this->data['code'] = rand(100000, 999999);
        $this->data['created_at'] = time();
        $this->data['expire_at'] = time() + 60 * 10;
        $this->data['attemps'] = 0;

        Notification::route('mail', $email)->notify(new NotificationsVerificationCode($this->data['code']));
    }

    public function verify(string $code): bool
    {
        $this->data['attemps']++;

        if ($this->data['attemps'] > 3) {
            throw new TooManyAttempsException();
        }

        if (now()->greaterThan(Carbon::createFromTimestamp($this->data['expire_at']))) {
            throw new CodeIsExpiredException();
        }

        if ($this->data['code'] != $code) {
            throw new InvalidCodeException();
        }

        return true;
    }

    public function data(): array
    {
        return $this->data['data'];
    }

    public function forget(): void
    {
        $this->data = [];
    }

    public function __destruct()
    {
        session([$this->action => $this->data,]);   
    }

    public static function create(string $action, array $data = []): self
    {
        session([$action => [
            'code' => rand(100000, 999999),
            'created_at' => time(),
            'expire_at' => time() + 60 * 10,
            'attemps' => 0,
            'data' => $data,
        ],]);

        return new self($action);
    }
}