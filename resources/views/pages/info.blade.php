@include('templates.header', ['title' => 'Info',])

<section class="swaps">
    <div class="container">
        <div class="swaps-card">
            <div class="top">
                <div class="coins">
                    <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />
                    <span class="balance-1">{{ $creator->balance }}</span>
                    <div class="add-coins flex red">
                        <a href="{{ route('subscription.page') }}#deposit">
                            <img src="{{ asset('/assets/img/plus.svg') }}" alt="" />
                        </a>
                    </div>
                </div>
            </div>

            <div class="statistic">
                <div class="title">Your Swap Stats</div>
                <p class="subtitle">Track your swaps and activity through real-time swap stats:</p>
                <div class="statistic-list">
                    <div class="statistic-item">
                        <span>Daily:</span> {{ $transfersStat['day'] }}
                    </div>
                    <div class="statistic-item">
                        <span>Weekly:</span> {{ $transfersStat['week'] }}
                    </div>
                    <div class="statistic-item">
                        <span>Monthly:</span> {{ $transfersStat['month'] }}
                    </div>
                </div>
                <div class="title per">
                    Here, you can swap your tokens for Meow.
                </div>
                <div class="title per">
                    Just a heads up, you can’t withdraw or exchange Meow back — it's strictly for in-game fun!
                </div>
                <div class="swap">
                    <div class="swap__coins">
                        <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />
                        <span class="balance-1">{{ $creator->balance }}</span>
                    </div>  
                    <div class="swap__arrow">
                        ➜
                    </div>
                    <div class="swap__coins">
                        <span class="balance-2">{{ format_price($creator->balance_2_total) }}</span>
                        <span>Meow</span>
                    </div>  
                    <div 
                        class="swap__btn btn red"
                        data-balance-1="{{ $creator->balance }}"
                        data-balance-2="{{ $creator->balance_2_total }}">
                        BUY +1
                    </div>
                </div>
                <div class="title per">
                    Meow is automatically added every day up to 5.00, so you can try out how it works!
                </div>
                @if (! $creator->transferRequestInPending)
                <div class="swap__transfer">
                    <div class="swap__exchange btn">
                        Exchange Meow
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="exchange-wrapper">
    <div class="exchange-popup">
        <div class="exchange-form">
            <img src="{{ asset('/assets/img/close.svg') }}" alt="" class="close" />
            <p class="title">
                Exchange Meow
            </p>
            <div class="amount-input">
                <img src="{{ asset('/assets/img/coins.svg') }}" alt="" class="input-label" />
                <input 
                    id="amount" 
                    type="number" 
                    placeholder="Enter the amount" 
                    min="1" 
                    max="{{ $creator->balance_2_total }}" />
                <p class="max-amount">Max</p>
                <p class="error-text"></p>
            </div>
            <div class="btn-box">
                <div class="btn red">
                    Exchange
                </div>
            </div>
            <div class="text-error"></div>
        </div>
        
        <div class="exchange-msg">
            <p class="title">
                Your exchange request will be processed within 72 hours. <br /> You will receive a notification by email.
            </p>
            <div class="btn-box">
                <div class="btn red btn-close">
                    Close
                </div>
            </div>
        </div>
    </div>
</div>

@include('templates.meow-btn')

@include('templates.footer')