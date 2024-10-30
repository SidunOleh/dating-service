@include('templates.header', ['title' => 'Earn with us',])

<script>
    DS.rates = {{ Js::from(cache('rates') ?? []) }}
</script>

<section class="refferals">
    <div class="container">
        <div class="refferals-card">
            
            <div class="top">
                <div class="open-transaction">Transaction list:</div>
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

            <div class="statistic">
                <p class="subtitle">Earn with Cherry!</p>
                <div class="title">Your Referral Stats</div>
                <p class="subtitle">Track your earnings and activity through real-time referral stats:</p>
                <div class="statistic-list">
                    <div class="statistic-item">
                        <span>Daily:</span> {{ $creator->referralsCount('day') }}
                    </div>
                    <div class="statistic-item">
                        <span>Weekly:</span> {{ $creator->referralsCount('week') }}
                    </div>
                    <div class="statistic-item">
                        <span>Monthly:</span> {{ $creator->referralsCount('month') }}
                    </div>
                    <div class="statistic-item">
                        <span>All time:</span> {{ $creator->referralsCount() }}
                    </div>
                </div>
                <div class="title per">
                    You earn <span>{{ $settings['referral_percent'] }}%</span> for every new subscriber who signs up using your referral link.
                </div>
            </div>

            <div class="sub-link">
                
                <div class="title" style="margin-bottom: 8px;">
                    Your Personal Cherry Link
                </div>
                <p class="subtitle">Share your personal referral link with friends, fans, and followers!</p>
                <div class="link-body">
                    <p class="link">
                        {{ route('home.index', ['ref' => $creator->referral_code,]) }}
                    </p>
                    <div class="btn red copy-link" style="white-space: nowrap;">Copy Link</div>
                    <div class="message">
                        <div>
                            Link copied 
                            <img src="{{ asset('/assets/img/checkmark.svg') }}" alt="" />
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('faq.page') }}" class="btn red earn">
                How to Earn (Tips & Tricks)
            </a>
            <p class="subtitle" style="margin-bottom: 32px">Maximize your earnings with our easy-to-follow tips and strategies.</p>
            <div class="deposit">
                <p class="title">Withdrawal Options</p>
                <p class="subtitle">Withdraw your earnings directly to your crypto wallet using any of our supported options:</p>
                <div class="deposit-types">

                    <div 
                        class="referral-out" 
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
                        class="referral-out"
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
                        class="referral-out" 
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
                        class="referral-out" 
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
                        class="referral-out" 
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
                        class="referral-out" 
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
                        class="referral-out" 
                        data-payment_id="130"
                        data-currency="BNB" 
                        data-network="BNB (BNB)">
                        <img src="{{ asset('/assets/img/bnb.svg') }}" alt="" /> 
                        <p class="name">BNB Chain</p>
                        <p class="abbr">
                            BNB
                        </p>
                    </div>
                    <div 
                        class="referral-out" 
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
                        class="referral-out" 
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

            <div class="referal">
                <p class="title">Referral list</p>

                <table class="referal-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Email</th>
                            <th>Subscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($referrals as $i => $referral)
                            <tr @class(['referal-item', 'none' => $i > 9,])>
                                <td class="date">
                                    {{ $referral->created_at->format('M d, Y') }}
                                </td>
                                <td class="email">
                                    <span>
                                        {{ mb_substr($referral->referee->email, 0, 3) }}...
                                    </span>
                                </td>
                                <td class="sum">
                                    {{ $referral->reward }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                @if ($creator->referrals()->count() > 10)
                <div class="load-more">
                    Load more
                    <img src="{{ asset('/assets/img/reload.svg') }}" alt="" />
                </div>
                @endif

            </div>

        </div>
    </div>
</section>

<div class="referral-out-wrapper">

    <div class="crypto-address card active">
        <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
        <p class="title red">
            Delay up to 1 hour
        </p>
       
        <p class="crypto-name">
            <img src="" alt="" class="network-icon" />  <span></span>
        </p>
        <div class="crypto-address-input">
            <div>
                <input 
                    type="text" 
                    placeholder="Enter address" 
                    id="cryptoAddress" />
                <p class="paste" id="pasteButton">Paste</p>
            </div>
            <p class="error-text"></p>
        </div>
        <div class="amount-input">
            <img src="{{ asset('/assets/img/coins.svg') }}" alt="" class="input-label" />
            <input 
                id="amount" 
                type="number" 
                placeholder="Enter the amount" 
                min="1" 
                max="{{ $creator->balance }}" />
            <p class="max-amount">Max</p>
            <p class="error-text"></p>
        </div>
        <div class="crypto-rate">
            <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />1 = <span></span>
        </div>
        <div class="referral-out-navigation">
            <div class="back btn white">Back</div>
            <div class="next btn red">Next</div>
        </div>
    </div>

    <!-- <div class="withdrawn-details card">
        <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
        <p class="title">
            Details of the withdrawal request
        </p>
        <div class="details-list">
            <div class="datails-item">
                <span>To:</span> 
                <span class="to"></span>
            </div>
            <div class="datails-item">
                <span>Crypto network:</span> 
                <span class="currency"></span>
            </div>
            <div class="datails-item">
                <span>Total: </span> 
                <span class="amount"></span>
            </div>
        </div>
        <div class="referral-out-navigation">
            <div class="back btn white">Back</div>
            <div class="next btn red">Next</div>
        </div>
    </div> -->

    <div class="withdrawn-final card">
        <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
        <p class="title">
            Your withdrawal request will be processed within 72 hours. <br /> You will receive a notification by email.
        </p>
        <div class="btn red">Close</div>
    </div>

</div>

@include('templates.transactions', [
    'transactions' => $creator->getTransactionList(),
])

@include('modals.verification')

@include('templates.footer')