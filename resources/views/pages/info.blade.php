@include('templates.header', ['title' => 'Info',])

<section class="swaps">
    <div class="container">
        <div class="swaps-card">
            <div class="top">
                <div class="coins">
                    <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />
                    <span class="balance-1">
                        {{ format_price($creator->balance) }}
                    </span>
                    <div class="add-coins flex red">
                        <a href="{{ route('subscription.page') }}#deposit">
                            <img src="{{ asset('/assets/img/plus.svg') }}" alt="" />
                        </a>
                    </div>
                </div>
            </div>

            <div class="statistic">
                <div class="title per">
                    Free Daily Sample:
                </div>
                <div class="title per boost">
                    <p>Every day we boost your balance to</p>
                    <p><img src="{{ asset('/assets/img/MeowIcon.png') }}" class="meowicon" alt="" />  5.00!</p>
                </div>
                <div class="buy-meow-btn">
                    <img 
                        class="buy"
                        data-balance-1="{{ $creator->balance }}"
                        data-balance-2="{{ $creator->balance_2_total }}"
                        src="{{ asset('/assets/img/buyOneCoin22.png') }}" alt="" />
                </div>
                <div class="swap">
                    <div class="swap__coins">
                        <img src="{{ asset('/assets/img/coins.svg') }}" alt="" />
                        <span class="balance-1">{{ format_price($creator->balance) }}</span>
                    </div>  
                    <div class="swap__arrow">
                        ➜
                    </div>
                    <div class="swap__coins">
                        <img src="{{ asset('/assets/img/MeowIcon.png') }}" class="meowicon" alt="" />
                        <span class="balance-2">{{ format_price($creator->balance_2_total) }}</span>
                    </div>  
                </div>
                <div class="title per">
                    Important:
                    <br>
                    Meow - is just a game token, so you can't exchange or withdraw it. You can only use it within our project.
                </div>
            </div>
        </div>
    </div>
</section>

@include('templates.meow-btn')

@include('templates.footer')