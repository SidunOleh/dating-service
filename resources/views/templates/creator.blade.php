<a href="#" @class(['users-item', 'verified' => $creator->is_verified,])>
    <div class="user-image">
        <div class="img-slider">
            
            @php
            $imgs = $creator->photos();
            $imgs = Auth::check() ? $imgs : $imgs->slice(0, 3);
            @endphp

            @foreach($imgs as $img)
            <div class="slide">
                <img src="{{ $img->url() }}" alt="person" />
            </div>
            @endforeach
        </div>
        <div class="slider-navigation">
            <div class="arrow prev">
                <img src="{{ asset('assets/img/prev.svg') }}" alt="" />
            </div>
            <div class="arrow next">
                <img src="{{ asset('assets/img/next.svg') }}" alt="" />
            </div>
        </div>
        <div class="likes">
            @auth
            <div class="btn red">
                <img src="{{ asset('assets/img/like.svg') }}" alt="" />
            </div>
            @endauth
            <div class="likes-count">
                {{ $creator->votes }}
            </div>
        </div>
    </div>
    <div class="card">
        <div class="title">{{ $creator->name }}, <span class="age">{{ $creator->age }}</span></div>
        <div class="place">
            {{ $creator->city }}, {{ $creator->region }}
        </div>
        <div class="about">
            {{ $creator->description }}
        </div>
    </div>
</a>