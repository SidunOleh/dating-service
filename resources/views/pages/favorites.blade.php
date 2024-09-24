@include('templates.header', ['title' => 'Favorites',])

<script>
    DS.ads = {}
    DS.ads.data = {{ Js::from($popupAds) }}
    DS.ads.settings = {{ Js::from($settings) }}
</script>

<section class="users">
    <div class="container">

        @if($template->total())
            <div class="users-list">

                @foreach($template->data() as $block)

                    @if($block instanceof App\Models\Creator)
                        @include('templates.creator', ['creator' => $block,])
                    @endif

                    @if($block instanceof App\Models\Ad)
                        @include('templates.ad', ['ad' => $block,])
                    @endif

                    @if(is_array($block))
                        @include('templates.roulette', ['pair' => $block,])
                    @endif

                @endforeach

            </div>

            @includeWhen($template->total() > 1, 'templates.pagination', [
                'current' => $template->getPage(), 
                'total' => $template->total(),
                'route' => 'favorites.page',
            ])
        @else
            <section class="noResults">
                <div class="container">
                    <div class="title">
                        No search results found!
                    </div>
                    <p class="text">
                        Please try configuring the filters again
                    </p>
                    <img src="{{ asset('/assets/img/noRes.svg') }}" alt="" />
                </div>
            </section>
        @endif

    </div>
</section>

@include('modals.ad')
    
@include('templates.footer')