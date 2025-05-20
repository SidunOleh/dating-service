<div class="other-user-list">
    @foreach($recommends as $i => $recommend)
    <a 
    
        href="{{ route('profile.page', ['creator' => $recommend->id,]) }}" 
        @class(['other-user-item', 'verified' => $recommend->is_verified, 'onlyMobile' => $i + 1 > $showOnDesctopCount,])>
        <div class="img-card">
            <img
                src="{{ $recommend->gallery->first()->getUrl() }}"
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