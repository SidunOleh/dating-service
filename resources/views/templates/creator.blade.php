<a 
    href="{{ route('profile.page', ['creator' => $creator->id,]) }}" 
    target="_blank"
    @class(['users-item', 'profile-item', 'verified' => $creator->is_verified,])>

    <div class="user-image">

        <div class="img-slider">
            @php
            $imgs = $creator->gallery;
            $imgs = auth('web')->user()?->activeSub ? $imgs : $imgs->slice(0, 3);
            @endphp

            @foreach($imgs as $img)
                @if($lazy)
                <div class="slide">
                    <img data-src="{{ $img->getUrl() }}" class="lazyload" alt="person" />
                </div>
                @else
                <div class="slide">
                    <img src="{{ $img->getUrl() }}" alt="person" />
                </div>
                @endif
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

        @auth('web')
            @include('templates.favorite', [
                'id' => $creator->id, 
                'count' => $creator->in_favorites_count,
                'active' => auth('web')->user()->favorites->contains($creator->id),
            ])
        @endauth

    </div>

    <div class="card">
        <div class="title"><span class="user-name">{{ $creator->name }},</span> <span class="age">{{ $creator->age }}</span></div>
        <div class="place">
            {{ $creator->city }}, {{ $creator->state }}
        </div>
        <div class="about">
            {{ $creator->description }}
        </div>
    </div>
    
</a>