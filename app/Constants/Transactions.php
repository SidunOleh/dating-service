<?php

namespace App\Constants;

class Transactions
{
    public const GATEWAYS = [
        'plisio' => 'plisio',
        'crypto' => 'crypto',
    ];

    public const PLISIO_TYPES = [
        'invoice' => 'invoice',
        'withdrawal' => 'withdrawal',
    ];

    public const PASSIMPAY_TYPES = [
        'deposit' => 'deposit',
        'withdrawal' => 'withdrawal',
    ];

    public const PLISIO_INVOICE_STATUS = [
        'new' => 'new',
        'expired' => 'expired', 
        'completed' => 'completed', 
        'mismatch' => 'mismatch',
    ];

    public const PASSIMPAY_DEPOSIT_STATUS = [
        'new' => 'new',
        'transfered' => 'transfered',
    ];

    public const WITHDRAWAL_REQUEST_STATUS = [
        'pending' => 'pending',
        'rejected' => 'rejected',
        'completed' => 'completed',
    ];

    public const PLISIO_WITHDRAWAL_STATUS = [
        'pending' => 'pending',
    ];

    public const PASSIMPAY_WITHDRAWAL_STATUS = [
        'pending' => 'pending',
        'error' => 'error',
        'succes' => 'success',
    ];

    public const BALANCE_2_TYPE = [
        'transfer_balance_balance_2' => 'transfer_balance_balance_2',
        'auto_credit' => 'auto_credit',
        'blog_open_credit' => 'blog_open_credit',
        'blog_open_debit' => 'blog_open_debit',
    ];
}