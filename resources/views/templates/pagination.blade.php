@php
$detect = new Detection\MobileDetect();
$detect->setUserAgent(request()->header('User-Agent'));

$endSize = $detect->isMobile() ? 1 : 2;
$midSize = $detect->isMobile() ? 1 : 3;
$step = $detect->isMobile() ? false : 10;
@endphp

<div class="pagination">

    @if($current > 1)
    <a href="{{ route($route, ['page' => $current - 1, ...request()->query(),]) }}" class="prev">
        <img src="{{ asset('assets/img/prev.svg') }}" alt="" aria-label="Previous page"/>
    </a>
    @endif
    
    <ul class="pagination-list">

        @for($i=1; $i <= $endSize; $i++)
            @if($i < $current - $midSize)
            <li>
                <a href="{{ route($route, ['page' => $i, ...request()->query(),]) }}">
                    {{ $i }}
                </a>
            </li>
            @endif
        @endfor

        @if($endSize+1 < $current-$midSize and $step)
        <li>
            <a href="{{ route($route, ['page' => $current-$step <= 0 ? 1 : $current-$step, ...request()->query(),]) }}">
                ...
            </a>
        </li>
        @endif

        @for($i=$current-$midSize; $i < $current; $i++)
            @if($i > 0)
            <li>
                <a href="{{ route($route, ['page' => $i, ...request()->query(),]) }}">
                    {{ $i }}
                </a>
            </li>
            @endif
        @endfor

        <li>
            <a class="current" href="{{ route($route, ['page' => $current, ...request()->query(),]) }}">
                {{ $current }}
            </a>
        </li>

        @for($i=$current+1; $i <= $current+$midSize; $i++)
            @if($i <= $total)
            <li>
                <a href="{{ route($route, ['page' => $i, ...request()->query(),]) }}">
                    {{ $i }}
                </a>
            </li>
            @endif
        @endfor

        @if($current+$midSize < $total-$endSize and $step)
        <li>
            <a href="{{ route($route, ['page' => $current+$step > $total ? $total : $current+$step, ...request()->query(),]) }}">
                ...
            </a>
        </li>
        @endif

        @for($i=$total-$endSize+1; $i <= $total; $i++)
            @if($i > $current + $midSize)
            <li>
                <a href="{{ route($route, ['page' => $i, ...request()->query(),]) }}">
                    {{ $i }}
                </a>
            </li>
            @endif
        @endfor

    </ul>

    @if($total > $current)
    <a href="{{ route($route, ['page' => $current + 1, ...request()->query(),]) }}" class="next">
        <img src="{{ asset('assets/img/next.svg') }}" alt="" aria-label="Next page" />
    </a>
    @endif

</div>