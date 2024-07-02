@if($ad)
<a target="_blank" href="{{ $ad->link }}" class="advertising-banner" data-id="{{ $ad->id }}">
    <img src="{{ $ad->image->getUrl() }}" alt="" />
    <p>{{ $ad->name }}</p>
</a>
@endif