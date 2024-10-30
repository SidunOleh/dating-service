@include('templates.header', ['title' => 'Subscription',])

<script>
    DS.rates = {{ Js::from(cache('rates') ?? []) }}
</script>

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
                    <!-- <div class="add-coins flex red">
                        <a href="{{ route('subscription.page') }}#deposit">
                            <img src="{{ asset('/assets/img/plus.svg') }}" alt="" />
                        </a>
                    </div> -->
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
                    
                    <div 
                        class="deposit-type" 
                        data-payment_id="10" 
                        data-currency="BTC" 
                        data-network="BTC (BTC)">
                        <img src="{{ asset('/assets/img/btc.svg') }}" alt="" /> 
                        <p class="name">Bitcoin</p>
                        <p class="abbr">
                            BTC
                        </p>
                    </div>
                    <div 
                        class="deposit-type" 
                        data-payment_id="20" 
                        data-currency="ETH" 
                        data-network="ETH (ETH)">
                        <img src="{{ asset('/assets/img/eth.svg') }}" alt="" /> 
                        <p class="name">Ethereum</p>
                        <p class="abbr">
                            ETH
                        </p>
                    </div>
                    <div 
                        class="deposit-type" 
                        data-payment_id="70"
                        data-currency="USDT" 
                        data-network="USDT (ERC-20)">
                        <img src="{{ asset('/assets/img/usdt.svg') }}" alt="" /> 
                        <p class="name">Tether ERC-20</p>
                        <p class="abbr">
                            USDT
                        </p>
                    </div>
                    <div 
                        class="deposit-type" 
                        data-payment_id="71"
                        data-currency="USDT" 
                        data-network="USDT (TRC-20)">
                        <img src="{{ asset('/assets/img/usdt-trx.svg') }}" alt="" /> 
                        <p class="name">Tether TRC-20</p>
                        <p class="abbr">
                            USDT
                        </p>
                    </div>
                    <div 
                        class="deposit-type" 
                        data-payment_id="100"
                        data-currency="USDC" 
                        data-network="USDC (ERC-20)">
                        <img src="{{ asset('/assets/img/usdc.svg') }}" alt="" /> 
                        <p class="name">USDC ERC-20</p>
                        <p class="abbr">
                            USDC
                        </p>
                    </div>
                    <div 
                        class="deposit-type" 
                        data-payment_id="40"
                        data-currency="DOGE" 
                        data-network="DOGE (DOGE)">
                        <img src="{{ asset('/assets/img/doge.svg') }}" alt="" /> 
                        <p class="name">Dogecoln</p>
                        <p class="abbr">
                            DOGE
                        </p>
                    </div>
                    <div 
                        class="deposit-type" 
                        data-payment_id="130"
                        data-currency="BNB" 
                        data-network="BNB (BNB)">
                        <img src="{{ asset('/assets/img/bnb.svg') }}" alt="" /> 
                        <p class="name">BNB Chain</p>
                        <p class="abbr">
                            BNB (Binance)
                        </p>
                    </div>
                    <div 
                        class="deposit-type" 
                        data-payment_id="50"
                        data-currency="BCH" 
                        data-network="BCH (BCH)">
                        <img src="{{ asset('/assets/img/bch.svg') }}" alt="" /> 
                        <p class="name">Bitcoin Cash</p>
                        <p class="abbr">
                            BCH
                        </p>
                    </div>
                    <div 
                        class="deposit-type" 
                        data-payment_id="232"
                        data-currency="SOL" 
                        data-network="SOL (BEP20)">
                        <img src="{{ asset('/assets/img/solana.svg') }}" alt="" /> 
                        <p class="name">Solana</p>
                        <p class="abbr">
                            SOL
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

<!-- <div class="coins-wrapper">
    <div class="coins-popup">
        <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
        <p class="title">
            Buying platform coins
        </p>
        <div class="repaymant-list">
            <div class="repaymant-item red" data-amount="20">
                <div class="coins">
                    <img src="{{ asset('/assets/img/coins.svg' ) }}" alt="" /> 20
                </div>
                <div class="cost">
                    $20 USD
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="deposit-wrapper">
    <div class="deposit-popup">
        <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
        <p class="title">
            Delay up to 1 hour
        </p>
        <p class="crypto-name">
            <img src="" alt="" class="network-icon" />  <span></span>
        </p>
        <div class="qr-code" id="deposit-qr">
            <!-- <img src="" alt="" /> -->
        </div>
        <div class="crypto-rate">
            <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />1 = <span></span>
        </div>

        <div class="key">
            <span class="title"></span>
            <p class="copy btn red">Copy</p>
        </div>
    </div>

    <div class="message">
        <div class="message-body">
            Key copied! <img src="{{ asset('/assets/img/checkmark.svg') }}" alt="" />
        </div>
    </div>

</div>

@include('templates.transactions', [
    'transactions' => $creator->getTransactionList(),
])

@include('templates.footer')