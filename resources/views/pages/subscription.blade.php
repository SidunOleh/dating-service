@include('templates.header')

<section class="subscribe">
    <div class="container">
        <div class="subscribe-card">

            <div class="top">
                <div class="open-transaction">
                    Transaction list
                </div>
                <div class="coins">
                    <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />
                    <span>{{ $creator->balance }}</span>
                    <div class="add-coins flex red">
                        <a href="{{ route('subscription.page') }}#deposit">
                            <img src="{{ asset('/assets/img/plus.svg') }}" alt="" />
                        </a>
                    </div>
                </div>
            </div>

            @if($creator->activeSub and ! $creator->activeSub->unsubscribed)
            <p class="renewal">
                Renewal Date: <span>{{ $creator->activeSub->ends_at->format('d.m.Y') }}</span>
            </p>
            @endif

            @if($creator->activeSub and $creator->activeSub->unsubscribed)
            <div class="end-date">
                Subscription end date: <span>{{ $creator->activeSub->ends_at->format('d.m.Y') }}</span>
            </div>
            @endif

            <div @class([
                'subscribe-Btn btn red', 
                'none' => $creator->activeSub and ! $creator->activeSub->unsubscribed,
                'after' => $creator->activeSub and $creator->activeSub->unsubscribed,
            ])>
                Subscribe
                <img src="{{ asset('assets/img/chery.svg') }}" alt="" />
                <div class="loader"><img src="./img/btn-loader.svg" alt="" /></div>
                <div class="sub-cost">
                    Subscription for 1 month:
                    <span>
                        <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />
                        {{ App\Models\Subscription::PRICE }}
                    </span>
                </div>
            </div>

            @if($creator->activeSub and ! $creator->activeSub->unsubscribed)
            <div class="un-subscribe-Btn btn">
                Unsubscribe
                <img src="{{ asset('/assets/img/chery.svg') }}" alt="" />
            </div>
            @endif

            <div class="text-error"></div>
            
            <div class="terms">
                <div class="title">
                    Subscription terms and conditions
                </div>
                <ol>
                    <li>Subscription is paid and costs a lot of money</li>
                    <li>Subscription is paid and costs a lot of money</li>
                    <li>Subscription is paid and costs a lot of money</li>
                    <li>Subscription is paid and costs a lot of money</li>
                    <li>Subscription is paid and costs a lot of money</li>
                </ol>
            </div>

            <div class="deposit" id="deposit">
                <p class="title">
                    Deposit methods
                </p>
                <div class="cost">
                    <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />
                    1 = 1 USD
                </div>
                <a class="duposit-rules">
                    Deposit rules
                </a>
                <div class="deposit-types">
                    
                    <div class="deposit-type" data-currency="BTC">
                        <img src="{{ asset('/assets/img/btc.svg') }}" alt="" /> 
                        <p class="name">Bitcoin</p>
                        <p class="abbr">
                            BTC
                        </p>
                    </div>
                    <div class="deposit-type" data-currency="ETH">
                        <img src="{{ asset('/assets/img/eth.svg') }}" alt="" /> 
                        <p class="name">Ethereum</p>
                        <p class="abbr">
                            ETH
                        </p>
                    </div>
                    <div class="deposit-type" data-currency="USDT">
                        <img src="{{ asset('/assets/img/usdt.svg') }}" alt="" /> 
                        <p class="name">Tether ERC-20</p>
                        <p class="abbr">
                            USDT
                        </p>
                    </div>
                    <div class="deposit-type" data-currency="USDT_TRX">
                        <img src="{{ asset('/assets/img/usdt-trx.svg') }}" alt="" /> 
                        <p class="name">Tether TRC-20</p>
                        <p class="abbr">
                            USDT_TRX
                        </p>
                    </div>
                    <div class="deposit-type" data-currency="USDC">
                        <img src="{{ asset('/assets/img/usdc.svg') }}" alt="" /> 
                        <p class="name">USDC ERC-20</p>
                        <p class="abbr">
                            USDC
                        </p>
                    </div>
                    <div class="deposit-type" data-currency="DOGE">
                        <img src="{{ asset('/assets/img/doge.svg') }}" alt="" /> 
                        <p class="name">Dogecoln</p>
                        <p class="abbr">
                            DOGE
                        </p>
                    </div>
                    <div class="deposit-type" data-currency="BNB">
                        <img src="{{ asset('/assets/img/bnb.svg') }}" alt="" /> 
                        <p class="name">BNB Chain</p>
                        <p class="abbr">
                            BNB
                        </p>
                    </div>
                    <div class="deposit-type" data-currency="BCH">
                        <img src="{{ asset('/assets/img/bch.svg') }}" alt="" /> 
                        <p class="name">Bitcoin Cash</p>
                        <p class="abbr">
                            BCH
                        </p>
                    </div>
                    <div class="deposit-type" data-currency="BUSD">
                        <img src="{{ asset('/assets/img/busd.svg') }}" alt="" /> 
                        <p class="name">BUSD (BEP-20)</p>
                        <p class="abbr">
                            BUSD
                        </p>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</section>

<div class="unsubcribe-wrapper">
    <div class="unsubcribe-card">
        <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
        <p class="text">
            Your subscription will be active until <span>xx.xx.xxxx.</span> After this date, you will be able to renew your subscription.
        </p>
        <div class="btn red">
            Confirm
        </div>
    </div>
</div>

<div class="coins-wrapper">
    <div class="coins-popup">
        <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
        <p class="title">
            Buying platform coins
        </p>
        <div class="repaymant-list">
            <div class="repaymant-item red" data-amount="2">
                <div class="coins">
                    <img src="{{ asset('/assets/img/coins.svg' ) }}" alt="" /> 2
                </div>
                <div class="cost">
                    $2 USD
                </div>
            </div>
        </div>
    </div>
</div>

<div class="deposit-wrapper">
    <div class="deposit-popup">
        <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
        <p class="title">
            Deposit takes up to 5 minutes. <br />You can check transactions list
        </p>
        <div class="qr-code">
            <img src="" alt="" />
        </div>
        <div class="deposit-info">
            <div class="network title">
                Сrypto network: <span class="type"></span>
            </div>
            <div class="course">Current course: <span></span></div>
        </div>

        <div class="key">
            <span class="title"></span>
            <img src="{{ asset('/assets/img/copy.svg') }}" alt="" class="copy" />
        </div>
    </div>

    <div class="message">
        <div class="message-body">
            Key copied! <img src="{{ asset('/assets/img/checkmark.svg') }}" alt="" />
        </div>
    </div>

</div>

@include('templates.transactions', [
    'transactions' => $transactions,
])

@include('templates.footer')