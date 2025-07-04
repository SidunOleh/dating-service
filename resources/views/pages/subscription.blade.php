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
                    <span>{{ format_price($creator->balance) }}</span>
                    <!-- <div class="add-coins flex red">
                        <a href="{{ route('subscription.page') }}#deposit">
                            <img src="{{ asset('/assets/img/plus.svg') }}" alt="" />
                        </a>
                    </div> -->
                </div>
            </div>

            @if($creator->activeSub and ! $creator->activeSub->unsubscribed)
            <p class="renewal">
                Renewal Date: <span>{{ $creator->activeSub->ends_at->format('M d, Y') }}</span>
            </p>
            @endif

            @if($creator->activeSub and $creator->activeSub->unsubscribed)
            <div class="end-date">
                Subscription end date: <span>{{ $creator->activeSub->ends_at->format('M d, Y') }}</span>
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
                    1-Month Subscription:
                    <span>
                        <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />
                        {{ $price }}
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
                    Cherry21 Subscription Details
                </div>
                <ol>
                    <li><b>Monthly Subscription:</b> Your subscription is valid for one month and cannot be canceled early. No refunds will be issued.</li>
                    <li><b>Access Exclusive Content:</b>  Enjoy special content available only to subscribers.</li>
                    <li><b> Auto-Renewal:</b> Your subscription will renew automatically unless you unsubscribe or your balance is low.</li>
                </ol>
            </div>

            <div class="deposit" id="deposit">
                <p class="title">
                    Deposit Methods
                </p>
                <div class="cost">
                    <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />
                    1 = 1 USDT
                </div>
                <a href="{{ route('faq.page', ['target' => 'how-to-deposit']) }}" class="duposit-rules">
                    How to Deposit
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
                            USDT (Coinbase)
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
                    <!-- <div 
                        class="deposit-type" 
                        data-payment_id="50"
                        data-currency="BCH" 
                        data-network="BCH (BCH)">
                        <img src="{{ asset('/assets/img/bch.svg') }}" alt="" /> 
                        <p class="name">Bitcoin Cash</p>
                        <p class="abbr">
                            BCH
                        </p>
                    </div> -->
                    <div 
                        class="deposit-type" 
                        data-payment_id="246"
                        data-currency="PYUSD" 
                        data-network="PYUSD (ERC20)">
                        <img src="{{ asset('/assets/img/pyusd.svg') }}" alt="" /> 
                        <p class="name">PayPal USD</p>
                        <p class="abbr">
                            PYUSD
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
            Your subscription is active until: <span>xx.xx.xxxx.</span> <br> Cancel your renewal?
        </p>
        <div class="btn red">
            Cancel
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
            Up to 1-hour delay
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
    'transactions' => $transactionsList,
])

@include('templates.footer')