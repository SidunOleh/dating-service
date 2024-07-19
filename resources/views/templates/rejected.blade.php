@php
$comments = array_filter($comments, fn ($comment) => $comment);
@endphp 

<div class="reject">
    <p class="reason">
        @if (! $comments)
            {{ 'Rejected' }}
        @endif

        @foreach($comments as $comment)
            {{ $comment }}
            <br>
            <br>
        @endforeach
    </p>
</div>