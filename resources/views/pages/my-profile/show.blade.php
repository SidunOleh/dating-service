@include('templates.header')

<section class="profile account">
    <div class="container">

        <div class="left-side">

            @include('templates.options')
            
            <div @class([
                'head-porfile',  
                'info-group',
                'verified' => $creator->is_verified,
                'pending' => $request->status(['name', 'age', 'location',]) == 'pending',
                'rejected' => $request->status(['name', 'age', 'location',]) == 'rejected',
                ])>

                <div class="img-card">
                    @if($creator->photos)
                    <img src="{{ $creator->gallery[0]->getUrl() }}" alt="" />
                    @else
                    <img src="{{ $request->gallery[0]->getUrl() }}" alt="" />
                    @endif

                    @include('templates.favorite', [
                        'id' => $creator->id, 
                        'count' => $creator->inFavorites()->count(),
                        'active' => $creator->hasInFavorites($creator->id),
                    ])
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

            <div class="user-info-list info-group {{ $request->status(['phone', 'telegram', 'whatsapp', 'instagram', 'snapchat', 'onlyfans', 'profile_email',]) }}">
                <p class="info-title">
                    <img src="{{ asset('/assets/img/user-card.svg') }}" alt="" /> 
                    Your сontact information
                </p>

                @if($data['phone']['value'])
                <div class="user-info-item">
                    <span class="type">Phone:</span>
                    <p class="info">
                        {{ $data['phone']['value'] }}
                    </p>
                </div>
                @endif

                @if($data['telegram']['value'])
                <div class="user-info-item">
                    <span class="type">Telegram:</span>
                    <p class="info">
                        {{ $data['telegram']['value'] }}
                    </p>
                </div>
                @endif 

                @if($data['whatsapp']['value'])
                <div class="user-info-item">
                    <span class="type">Whatsapp:</span>
                    <p class="info">
                        {{ $data['whatsapp']['value'] }}
                    </p>
                </div>
                @endif

                @if($data['instagram']['value'])
                <div class="user-info-item">
                    <span class="type">Instagram:</span>
                    <p class="info">
                        {{ $data['instagram']['value'] }}
                    </p>
                </div>
                @endif

                @if($data['snapchat']['value'])
                <div class="user-info-item">
                    <span class="type">Snapchat:</span>
                    <p class="info">
                        {{ $data['snapchat']['value'] }}
                    </p>
                </div>
                @endif

                @if($data['onlyfans']['value'])
                <div class="user-info-item">
                    <span class="type">OnlyFans:</span>
                    <p class="info">
                        {{ $data['onlyfans']['value'] }}
                    </p>
                </div>
                @endif

                @if($data['profile_email']['value'])
                <div class="user-info-item">
                    <span class="type">Email:</span>
                    <p class="info">
                        {{ $data['profile_email']['value'] }}
                    </p>
                </div>
                @endif

                @includeWhen(
                    $request->status(['phone', 'telegram', 'whatsapp', 'instagram', 'snapchat', 'onlyfans', 'profile_email',]) == 'rejected', 
                    'templates.rejected', 
                    ['comments' => $request->comments(['phone', 'telegram', 'whatsapp', 'instagram', 'snapchat', 'onlyfans', 'profile_email',]),]
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
                    {{ "{$data['location']['value']['street']}, {$data['location']['value']['city']}, {$data['location']['value']['state']} {$data['location']['value']['zip']}" }}
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
                    Your descrittion
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

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const latlng = {{ Js::from([$data['location']['value']['latitude'], $data['location']['value']['longitude']]) }}

    const map = L.map('map').setView(latlng, 15)

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

    L.marker(latlng).addTo(map)
</script>

@include('templates.footer')