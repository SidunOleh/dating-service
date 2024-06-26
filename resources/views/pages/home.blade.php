@include('templates.header')

<script>
    let ads = {{ Js::from($ads) }}
    let adsSettings = {{ Js::from($adsSettings->pluck('value', 'name')) }}
</script>

<section class="users">
    <div class="container">

        @if($template->total())

            <div class="users-list">

                @foreach($template->data() as $block)

                    @if($block instanceof App\Models\Creator)
                        @include('templates.creator', [
                            'creator' => $block, 
                            'in_favorites' => $favorites->contains($block->id),
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

            @include('templates.pagination', [
                'current' => $template->getPage(), 
                'total' => $template->total(),
            ])

        @else
            No content
        @endif

    </div>
</section>

@includeWhen(!auth('web')->check(), 'modals.auth')

@include('modals.verification')
<!-- @include('modals.ad') -->
    
@include('templates.footer')