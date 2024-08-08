@php
$comments = array_filter($comments, fn ($comment) => $comment);
@endphp 

<div class="reject">
    <p class="reason">
        @if (! $comments)
            {{ 'Rejected' }}
        @endif

        @foreach($comments as $i => $comment)
            {{ $comment }}
            
            @if ($i != count($comments)-1)
                <br><br>
            @endif
        @endforeach
    </p>
</div>