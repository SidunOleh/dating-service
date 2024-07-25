<a target="_blank" href="{{ $ad->link }}" class="users-item add" data-id="{{ $ad->id }}"> 
    <img src="{{ asset('assets/img/lazy-loading.gif') }}" data-src="{{ $ad->image->getUrl() }}" cloading="lazy" alt="">
</a>