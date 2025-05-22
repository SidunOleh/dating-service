@include('templates.header', ['title' => 'My post',])

<div class="tab tab_myprofile">
    <div class="container">
        <div class="tab__top">
            <div 
                @class(['tab__item' => true, 'open' => request()->query('tab', 'info') == 'info']) 
                data-head="info">
                <div class="arrow">
                    <img src="{{ asset('assets/img/next.svg') }}" alt="" style="rotate: 180deg;">
                </div>
                <span>Info</span>
            </div>
            <div 
                @class(['tab__item' => true, 'open' => request()->query('tab') == 'post']) 
                data-head="post">
                <span>Post</span>
                <div class="arrow">
                    <img src="{{ asset('assets/img/next.svg') }}" alt="">
                </div>
            </div>
        </div>

        <div 
            @class(['tab__left' => true, 'open' => request()->query('tab', 'info') == 'info'])
            data-tab="info">
            <div class="tab__content">
                <section class="profile account">
                    <div class="profile__container">

                        <div class="left-side">

                            @include('templates.options')
                            
                            <div @class([
                                'head-porfile',  
                                'info-group',
                                'verified' => $creator->is_verified,
                                'pending' => $request->status([
                                    'name', 
                                    'age', 
                                    'location',
                                ]) == 'pending',
                                'rejected' => $request->status([
                                    'name', 
                                    'age', 
                                    'location',
                                ]) == 'rejected',
                                ])>

                                <div class="img-card">
                                    <img src="{{ $creator->gallery->count() ? $creator->gallery[0]->getUrl() : $request->gallery[0]->getUrl() }}" alt="" />
                                </div>

                                <div class="userMain">
                                    <p class="name">
                                        {{ $data['name']['value'] }}, {{ $data['age']['value'] }}
                                    </p>
                                    <p class="city">
                                        {{ $data['location']['value']['city'] }}, {{ $data['location']['value']['state'] }}
                                    </p>
                                </div>

                                @includeWhen(
                                    $request->status(['name', 'age', 'location',]) == 'rejected', 
                                    'templates.rejected', 
                                    ['comments' => $request->comments(['name', 'age', 'location',]),]
                                )
                            </div>

                            <div class="user-info-list info-group {{ $request->status(['phone', 'telegram', 'whatsapp', 'instagram', 'snapchat', 'onlyfans', 'profile_email', 'twitter',]) }}">
                                <p class="info-title">
                                    <img src="{{ asset('/assets/img/user-card.svg') }}" alt="" /> 
                                    Your Get in Touch
                                </p>

                                @if($data['phone']['value'])
                                <div class="user-info-item">
                                    <span class="type"><img src="/assets/img/phone.svg" alt="" /> Phone:</span>
                                    <p class="info">
                                        {{ $data['phone']['value'] }}
                                    </p>
                                </div>
                                @endif

                                @if($data['telegram']['value'])
                                <div class="user-info-item">
                                    <span class="type"><img src="/assets/img/ic_outline-telegram.svg" alt="" /> Telegram:</span>
                                    <p class="info">
                                        {{ $data['telegram']['value'] }}
                                    </p>
                                </div>
                                @endif 

                                @if($data['whatsapp']['value'])
                                <div class="user-info-item">
                                    <span class="type"><img src="/assets/img/whatsapp.svg" alt="" /> Whatsapp:</span>
                                    <p class="info">
                                        {{ $data['whatsapp']['value'] }}
                                    </p>
                                </div>
                                @endif

                                @if($data['instagram']['value'])
                                <div class="user-info-item">
                                    <span class="type"><img src="/assets/img/mdi_instagram.svg" alt="" /> Instagram:</span>
                                    <p class="info">
                                        {{ $data['instagram']['value'] }}
                                    </p>
                                </div>
                                @endif

                                @if($data['snapchat']['value'])
                                <div class="user-info-item">
                                    <span class="type"><img src="/assets/img/snapchat.svg" alt="" /> Snapchat:</span>
                                    <p class="info">
                                        {{ $data['snapchat']['value'] }}
                                    </p>
                                </div>
                                @endif

                                @if($data['onlyfans']['value'])
                                <div class="user-info-item">
                                    <span class="type"><img src="/assets/img/onlyfans.svg" alt="" /> OnlyFans:</span>
                                    <p class="info">
                                        {{ $data['onlyfans']['value'] }}
                                    </p>
                                </div>
                                @endif

                                @if($data['profile_email']['value'])
                                <div class="user-info-item">
                                    <span class="type"><img src="/assets/img/mail.svg" alt="" /> Email:</span>
                                    <p class="info">
                                        {{ $data['profile_email']['value'] }}
                                    </p>
                                </div>
                                @endif

                                @if($data['twitter']['value'])
                                <div class="user-info-item">
                                    <span class="type"><img src="/assets/img/twitter.png" alt="" /> Twitter:</span>
                                    <p class="info">
                                        {{ $data['twitter']['value'] }}
                                    </p>
                                </div>
                                @endif

                                @includeWhen(
                                    $request->status(['phone', 'telegram', 'whatsapp', 'instagram', 'snapchat', 'onlyfans', 'profile_email', 'twitter',]) == 'rejected', 
                                    'templates.rejected', 
                                    ['comments' => $request->comments(['phone', 'telegram', 'whatsapp', 'instagram', 'snapchat', 'onlyfans', 'profile_email', 'twitter',]),]
                                )
                            </div>

                            <div class="info-group {{ $data['location']['status'] }}">
                                <div class="user-location">
                                    <p class="info-title">
                                        <img src="{{ asset('/assets/img/local.svg') }}" alt="" /> 
                                        Your location
                                    </p>

                                    <div id="map"></div>
                                </div>
                                
                                <div class="location-address">
                                    {{ "{$data['location']['value']['city']}, {$data['location']['value']['state']} {$data['location']['value']['zip']}" }}
                                </div>

                                @includeWhen(
                                    $data['location']['status'] == 'rejected', 
                                    'templates.rejected', 
                                    ['comments' => [$data['location']['comment'],],]
                                )
                            </div>

                            <div class="description info-group {{ $data['description']['status'] }}">
                                <p class="info-title">
                                    <img src="{{ asset('/assets/img/description.svg') }}" alt="" /> 
                                    Your Story
                                </p>

                                {{ $data['description']['value'] }}
                                
                                @includeWhen(
                                    $data['description']['status'] == 'rejected', 
                                    'templates.rejected', 
                                    ['comments' => [$data['description']['comment'],],]
                                )
                            </div>

                        </div>

                        <div class="user-photo-list">
                            @foreach($creator->gallery as $photo)
                                <a href="{{ $photo->getUrl() }}" data-fancybox="user-photos" class="user-photo-item info-group">
                                    <img src="{{ $photo->getUrl() }}" alt="" />
                                </a>
                            @endforeach

                            @foreach($request->gallery as $i => $photo)
                                @if($data['photos']['status'][$i] != 'approved')
                                <a href="{{ $photo->getUrl() }}" data-fancybox="user-photos" class="user-photo-item info-group {{ $data['photos']['status'][$i] }}">
                                    <img src="{{ $photo->getUrl() }}" alt="" />

                                    @includeWhen(
                                        $data['photos']['status'][$i] == 'rejected', 
                                        'templates.rejected', 
                                        ['comments' => [$data['photos']['comment'][$i],],]
                                    )
                                </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    @if(! $creator->hasUndoneProfileRequest())
                    <div class="edit-info-btn">
                        <a href="{{ route('my-profile.edit') }}" class="btn red">
                            Edit information
                        </a>
                    </div>
                    @endif

                    @include('modals.delete-profile')                

                </section>
            </div>
            
            <div class="tab__head" data-head="post">
                <div class="arrow">
                    <img src="{{ asset('assets/img/next.svg') }}" alt="" />
                </div>
                <span>Post</span>
            </div>
        </div>

        <div 
            @class(['tab__right' => true, 'open' => request()->query('tab') == 'post'])
            data-tab="post">
            <div class="tab__head" data-head="info">
                <div class="arrow">
                    <img src="{{ asset('assets/img/prev.svg') }}" alt="" />
                </div>
                <span>Info</span>    
            </div>

            <div class="tab__content">
                @includeWhen(!$creator->postInPending, 'templates.posts.create', ['creator' => $creator])

                @if($posts->count())
                    <section class="posts">
                        <div class="posts__container">
                            <div 
                                class="posts__list"
                                data-current-page="{{ $posts->currentPage() }}"
                                data-total-pages="{{ ceil($posts->total() / $posts->perPage()) }}">
                                @include('templates.posts.my-posts', ['posts' => $posts])
                            </div>

                            <div class="posts__loader">
                                <div class="lds-ellipsis">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </section>

                    @include('modals.delete-post')
                @endif
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const latlng = {{ Js::from([$data['location']['value']['latitude'], $data['location']['value']['longitude']]) }}

    const map = L.map('map').setView(latlng, 15)

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

    L.marker(latlng).addTo(map)
</script>

@include('templates.footer')