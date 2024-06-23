@include('templates.header')

<section class="users">
    <div class="container">

        <div class="users-list">

            @php
            $favorites = auth()->user() ? auth()->user()->favorites->pluck('id')->all() : []
            @endphp

            @foreach($template->data() as $block)

                @if($block instanceof App\Models\Creator)
                    @include('templates.creator', [
                        'creator' => $block, 
                        'in_favorites' => in_array($block->id, $favorites),
                    ])
                @endif

                @if($block instanceof App\Models\Ad)
                    @include('templates.ad', ['ad' => $block,])
                @endif

                @if(is_array($block))
                    @include('templates.roulette', ['creators' => $block,])
                @endif

            @endforeach

        </div>

        @includeWhen($template->total() > 1, 'templates.pagination', [
            'current' => $template->getPage(), 
            'total' => $template->total(),
        ])

    </div>
</section>

<!-- @include('modals.ad') -->

@includeWhen(!Auth::check(), 'modals.auth')
@includeWhen(!Auth::check(), 'modals.verification')
    
@include('templates.footer')