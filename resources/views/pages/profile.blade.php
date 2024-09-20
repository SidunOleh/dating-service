@include('templates.header', ['title' => 'My post',])

<section class="profile">
    <div class="container">

        <div class="left-side">

            <div @class(['head-porfile', 'verified' => $creator->is_verified,])>
                <div class="img-card">
                    <img
                        src="{{ asset('assets/img/placeholder.png') }}"  
                        data-src="{{ $creator->gallery->first()->getUrl() }}" 
                        class="lazyload"
                        alt="" />

                    @auth('web')
                        @include('templates.favorite', [
                            'id' => $creator->id, 
                            'count' => $creator->inFavorites()->count(),
                            'active' => auth('web')->user()->favorites->contains($creator->id),
                        ])
                    @endauth
                </div>
                <div class="userMain">
                    <p class="name">{{ $creator->name }}, {{ $creator->age }}</p>
                    <p class="city">{{ $creator->city }}, {{ $creator->state }}</p>
                </div>
            </div>

            <div class="user-info-list">
                @if($creator->phone)
                <div class="user-info-item">
                    <span class="type">Phone:</span>
                    <p class="info">{{ $creator->phone }}</p>
                </div>
                @endif
                @if($creator->instagram)
                <div class="user-info-item">
                    <span class="type">Instagram:</span>
                    <p class="info">{{ $creator->instagram }}</p>
                </div>
                @endif
                @if($creator->telegram)
                <div class="user-info-item">
                    <span class="type">Telegram:</span>
                    <p class="info">{{ $creator->telegram }}</p>
                </div>
                @endif
                @if($creator->snapchat)
                <div class="user-info-item">
                    <span class="type">Snapchat:</span>
                    <p class="info">{{ $creator->snapchat }}</p>
                </div>
                @endif
                @if($creator->onlyfans)
                <div class="user-info-item">
                    <span class="type">OnlyFans:</span>
                    <p class="info">{{ $creator->onlyfans }}</p>
                </div>
                @endif
                @if($creator->profile_email)
                <div class="user-info-item">
                    <span class="type">Email:</span>
                    <p class="info">{{ $creator->profile_email }}</p>
                </div>
                @endif
            </div>

            <div class="user-location">
                <div id="map"></div>
            </div>
            
            <div class="description">
                {{ $creator->description }}
            </div>
        </div>
        
        <div class="user-photo-list">
            @php
            $imgs = $creator->gallery;
            $imgs = auth('web')->user()?->activeSub ? $imgs : $imgs->slice(0, 3);

            $blur = scandir(public_path('assets/img/blur'));
            $blur = array_filter($blur, fn ($file) => ! in_array($file, ['.', '..',]));
            shuffle($blur);
            $blur = array_slice($blur, 0, $creator->gallery->count() - $imgs->count());
            @endphp

            @foreach($imgs as $img)
                <a href="{{ $img->getUrl() }}" data-fancybox="user-photos" class="user-photo-item">
                    <img 
                        src="{{ asset('assets/img/placeholder.png') }}" 
                        data-src="{{ $img->getUrl() }}" 
                        class="lazyload" 
                        alt="" />
                </a>
            @endforeach

            @foreach($blur as $img)
                <div class="user-photo-item">
                    <div class="subscribe">
                        @if(!auth('web')->check())
                            <p>Log in, to get full access!</p>
                            <div class="btn red login">
                                Log in
                            </div>
                        @else
                            <p>Subscribe, to get full access!</p>
                            <a href="{{ route('subscription.page') }}" class="btn red">
                                Subscribe
                            </a>
                        @endif
                    </div>
                    <img
                        src="{{ asset('assets/img/placeholder.png') }}" 
                        data-src="{{ asset("assets/img/blur/{$img}") }}" 
                        class="lazyload"
                        alt="" />
                </div>
            @endforeach

        </div>
    
        <div class="other-user-list">
            @foreach($recommends as $recommend)
            <a 
                target="_blank" 
                href="{{ route('profile.page', ['creator' => $recommend->id,]) }}" 
                @class(['other-user-item', 'verified' => $recommend->is_verified,])>
                <div class="img-card">
                    <img
                        src="{{ asset('assets/img/placeholder.png') }}" 
                        data-src="{{ $recommend->gallery->first()->getUrl() }}"
                        class="lazyload"
                        alt="" />
                </div>
                
                <div class="card">
                    <p class="name">
                        {{ mb_strlen($recommend->name) > 5 ? mb_substr($recommend->name, 0, 5) . '...' : $recommend->name }}, {{ $recommend->age }}
                    </p>
                    <p class="city">
                        {{ $recommend->city }}, {{ $recommend->state }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    
    </div>
</section>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const latlng = [
        {{ $creator->latitude + 0.001 }},
        {{ $creator->longitude + 0.001 }},
    ]

    const map = L.map('map').setView(latlng, 15)

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

    L.circle(latlng, {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 250,
    }).addTo(map)
</script>

@includeWhen(!auth('web')->check(), 'modals.auth') 
@includeWhen(!auth('web')->check(), 'modals.verification') 

@include('templates.footer')