@include('templates.header')

<div class="users vote">
    <div class="container">
        <div class="users-list">

            @include('templates.roulette', ['creators' => $roulette,])
        
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