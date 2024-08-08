@php
$endSize = 2;
$midSize = 3;
$step = 10;
@endphp

<div class="pagination">

    @if($current > 1)
    <div class="prev">
        <a href="{{ route($route, ['page' => $current - 1, ...request()->query(),]) }}">
            <img src="{{ asset('assets/img/prev.svg') }}" alt="" />
        </a>
    </div>
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

        @if($endSize+1 < $current-$midSize)
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

        @if($current+$midSize < $total-$endSize)
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
        <div class="next">
            <a href="{{ route($route, ['page' => $current + 1, ...request()->query(),]) }}">
                <img src="{{ asset('assets/img/next.svg') }}" alt="" />
            </a>
        </div>
    @endif

</div>