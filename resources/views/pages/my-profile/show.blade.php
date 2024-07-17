@include('templates.header')

<section class="profile account">
    <div class="container">

        <div class="left-side">

            @include('templates.options')
            
            <div @class([
                'head-porfile',  
                'info-group',
                'verified' => $creator->is_verified,
                'pending' => $request->sectionStatus('info') == 'pending',
                'rejected' => $request->sectionStatus('info') == 'rejected',
                ])>

                <div class="img-card">
                    @if($creator->gallery->count())
                    <img src="{{ $creator->gallery[0]->getUrl() }}" alt="" />
                    @else
                    <img src="{{ $request->gallery[0]->getUrl() }}" alt="" />
                    @endif
                </div>

                <div class="userMain">
                    <p class="name">
                    {{ $request->name['value'] ?? $creator->name }}, {{ $request->age['value'] ?? $creator->age }}
                    </p>
                    <p class="city">
                        {{ $request->gender['value'] ?? $creator->gender }}
                    </p>
                </div>

                @includeWhen(
                    $request->sectionStatus('info') == 'rejected', 
                    'templates.rejected', 
                    ['texts' => $request->sectionComments('info'),]
                )
            </div>

            <div class="user-info-list info-group {{ $request->sectionStatus('contacts') }}">
                <p class="info-title">
                    <img src="{{ asset('/assets/img/user-card.svg') }}" alt="" /> 
                    Your сontact information
                </p>

                @if($request->phone['value'] ?? $creator->phone)
                <div class="user-info-item">
                    <span class="type">Phone:</span>
                    <p class="info">
                        {{ $request->phone['value'] ?? $creator->phone }}
                    </p>
                </div>
                @endif

                @if($request->telegram['value'] ?? $creator->telegram)
                <div class="user-info-item">
                    <span class="type">Telegram:</span>
                    <p class="info">
                        {{ $request->telegram['value'] ?? $creator->telegram }}
                    </p>
                </div>
                @endif 

                @if($request->whatsapp['value'] ?? $creator->whatsapp)
                <div class="user-info-item">
                    <span class="type">Whatsapp:</span>
                    <p class="info">
                        {{ $request->whatsapp['value'] ?? $creator->whatsapp }}
                    </p>
                </div>
                @endif

                @if($request->instagram['value'] ?? $creator->instagram)
                <div class="user-info-item">
                    <span class="type">Instagram:</span>
                    <p class="info">
                        {{ $request->instagram['value'] ?? $creator->instagram }}
                    </p>
                </div>
                @endif

                @if($request->snapchat['value'] ?? $creator->snapchat)
                <div class="user-info-item">
                    <span class="type">Snapchat:</span>
                    <p class="info">
                        {{ $request->snapchat['value'] ?? $creator->snapchat }}
                    </p>
                </div>
                @endif

                @if($request->onlyfans['value'] ?? $creator->onlyfans)
                <div class="user-info-item">
                    <span class="type">OnlyFans:</span>
                    <p class="info">
                        {{ $request->onlyfans['value'] ?? $creator->onlyfans }}
                    </p>
                </div>
                @endif

                @if($request->profile_email['value'] ?? $creator->profile_email)
                <div class="user-info-item">
                    <span class="type">Email:</span>
                    <p class="info">
                        {{ $request->profile_email['value'] ?? $creator->profile_email }}
                    </p>
                </div>
                @endif

                @includeWhen(
                    $request->sectionStatus('contacts') == 'rejected', 
                    'templates.rejected', 
                    ['texts' => $request->sectionComments('contacts'),]
                )
            </div>

            <div class="info-group {{ $request->location['status'] ?? '' == 'rejected' }}">
                <div class="user-location">
                    <p class="info-title">
                        <img src="{{ asset('/assets/img/local.svg') }}" alt="" /> 
                        Your location
                    </p>

                    <div id="map"></div>
                </div>
                
                <div class="location-address">
                    {{ $request->fullAddress() ?: $creator->fullAddress() }}
                </div>

                @includeWhen(
                    $request->location['status'] ?? '' == 'rejected', 
                    'templates.rejected', 
                    ['texts' => [$request->location['comment'] ?? ''],]
                )
            </div>

            <div class="description info-group {{ $request->description['status'] ?? '' }}">
                <p class="info-title">
                    <img src="{{ asset('/assets/img/description.svg') }}" alt="" /> 
                    Your descrittion
                </p>

                {{ $request->description['value'] ?? $creator->description }}
                
                @includeWhen(
                    $request->description['status'] ?? '' == 'rejected', 
                    'templates.rejected', 
                    ['texts' => [$request->description['comment'] ?? ''],]
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
            
                @if($request->photos['status'][$i] != 'approved')
                <a href="{{ $photo->getUrl() }}" data-fancybox="user-photos" class="user-photo-item info-group {{ $request->photos['status'][$i] }}">
                    <img src="{{ $photo->getUrl() }}" alt="" />

                    @includeWhen(
                        $request->photos['status'][$i] == 'rejected', 
                        'templates.rejected', 
                        ['texts' => [$request->photos['comment'][$i]],]
                    )
                </a>
                @endif
                
            @endforeach
        </div>
    </div>

    @if(! $creator->profileRequests()->where('status', 'undone')->count())
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
    const latlng = {{ Js::from($request->coordinates() ?: $creator->coordinates()) }}

    const map = L.map('map').setView(latlng, 15)

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map)

    L.marker(latlng).addTo(map)
</script>

@include('templates.footer')