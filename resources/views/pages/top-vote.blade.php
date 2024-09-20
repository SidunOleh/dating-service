@include('templates.header', ['title' => 'Top vote',])

<div class="users vote">
    <div class="container">
        <div class="users-list">

            @includeWhen($roulette->count() == 2, 'templates.roulette', ['pair' => $roulette,])
        
        </div>
    </div>
</div>

<section class="users">
    <div class="container">
        <div class="users-list">
           
            @foreach($topVote as $creator)
                @include('templates.creator', ['creator' => $creator,])
            @endforeach

        </div>
    </div>
</section>

@include('templates.footer')
