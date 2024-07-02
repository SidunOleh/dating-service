@include('templates.header')

<section class="profile">
    <div class="container">
        <div class="left-side">
            <div @class(['head-porfile', 'verified' => $creator->is_verified,])>
                <div class="img-card">
                    <img src="{{ $creator->gallery->first()->getUrl() }}" alt="" />
                    <div class="likes" data-id="{{ $creator->id }}">
                        @auth('web')
                        <div @class(['btn', 'red', 'added' => $favorites->contains($creator->id),])>
                            <img src="{{ asset('assets/img/like.svg') }}" alt="" />
                        </div>
                        @endauth
                        <div class="likes-count">
                            {{ $creator->in_favorites_count }}
                        </div>
                    </div>
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
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            <script>
                const latLng = [
                    {{ $creator->latitude }},
                    {{ $creator->longitude }},
                ]

                const map = L.map('map').setView(latLng, 17)

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

                const marker = L.marker(latLng)
                marker.addTo(map)
            </script>
            
            <div class="description">
                {{ $creator->description }}
            </div>
        </div>
        <div class="user-photo-list">
            @php
            $imgs = $creator->gallery;
            $imgs = (auth('web')->check() and auth('web')->user()->subscription) ? $imgs : $imgs->slice(0, 3);
            @endphp

            @foreach($imgs as $img)
            <a href="{{ $img->getUrl() }}" data-fancybox="user-photos" class="user-photo-item">
                <img src="{{ $img->getUrl() }}" alt="" />
            </a>
            @endforeach

            @if (!auth('web')->check() or !auth('web')->user()->subscription)
            <div class="user-photo-item">
                <div class="subscribe">
                    @if(!auth('web')->check())
                    <p>Log in, to get full access!</p>
                    <div class="btn red login">
                        Log in
                    </div>
                    @else
                    <p>Subscribe, to get full access!</p>
                    <a href="/" class="btn red">
                        Subscribe
                    </a>
                    @endif
                </div>
                <img src="{{ asset('assets/img/user3.png') }}" alt="" />
            </div>
            @endif

        </div>
        <div class="other-user-list">
            @foreach($recommendations as $recommendation)
            <a 
                target="_blank" 
                href="{{ route('profile.page', ['creator' => $recommendation->id,]) }}" 
                @class(['other-user-item', 'verified' => $recommendation->is_verified,])>
                <div class="img-card">
                    <img src="{{ $recommendation->gallery->first()->getUrl() }}" alt="" />
                    <div class="likes" data-id="{{ $recommendation->id }}">
                        @auth('web')
                        <div @class(['btn', 'red', 'added' => $favorites->contains($recommendation->id),])>
                            <img src="{{ asset('assets/img/like.svg') }}" alt="" />
                        </div>
                        @endauth
                        <div class="likes-count">
                            {{ $recommendation->in_favorites_count }}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <p class="name">{{ $recommendation->name }}, {{ $recommendation->age }}</p>
                    <p class="city">{{ $recommendation->city }}, {{ $recommendation->state }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

@includeWhen(!auth('web')->check(), 'modals.auth') 
@includeWhen(!auth('web')->check(), 'modals.verification') 

@include('templates.footer')