@foreach($posts as $post)
    @auth('web')
        @if($post->openForCurrentUser())
            @include('templates.posts.post-open', ['post' => $post])
        @else
            @include('templates.posts.post-close', ['post' => $post])
        @endif
    @endauth

    @guest('web')
        @include('templates.posts.post-guest', ['post' => $post])
    @endguest
@endforeach