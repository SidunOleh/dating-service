<div class="reject">
    <p class="reason">
        @if (! $texts)
            {{ 'Rejected' }}
        @else
            @foreach($texts as $text)
                {{ $text ?: 'Rejected' }}
                <br>
                <br>
            @endforeach
        @endif
    </p>
</div>