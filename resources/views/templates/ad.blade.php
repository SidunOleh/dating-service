<a target="_blank" href="{{ $ad->link }}" class="users-item add" data-id="{{ $ad->id }}"> 
    <img 
        src="{{ asset('assets/img/placeholder.png') }}" 
        data-src="{{ $ad->image->getUrl() }}" 
        class="lazyload" alt="">
</a>