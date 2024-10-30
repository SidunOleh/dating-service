<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
<!-- # @lang('Hello!') -->
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

<br>

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
<div style="text-align: center;">Best, Cherry21 team.</div>
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
<div style="text-align: center;">
@lang(
    "If you’re having trouble with the \":actionText\" button, copy and paste this URL into your browser: :actionUrl",
    [
        'actionText' => $actionText,
        'actionUrl' => $actionUrl,
    ]
)
</div>
</x-slot:subcopy>
@endisset
</x-mail::message>
