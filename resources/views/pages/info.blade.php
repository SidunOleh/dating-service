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
                <div class="title">
                    Free Daily Sample:
                </div>
                <div class="lucky-text boost">
                    <p>Every day we boost your balance to</p>
                    <p class="amount"><img src="{{ asset('/assets/img/MeowIcon.png') }}" class="meowicon" alt="" />  5.00</p>
                    <p>for <b>FREE!</b></p>
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
                        <span>1.00</span>
                    </div>  
                    <div class="swap__arrow">
                        =
                    </div>
                    <div class="swap__coins">
                        <img src="{{ asset('/assets/img/MeowIcon.png') }}" class="meowicon" alt="" />
                        <span>1.00</span>
                    </div>  
                </div>
                <div class="text-error"></div>
                <div class="swap__bottom ">
                    <div class="title">
                        Important:
                    </div>
                    <div class="lucky-text">
                        Meow - is just a game token, so you can't exchange or withdraw it. You can only use it within our project.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('templates.meow-btn')

@include('templates.footer')