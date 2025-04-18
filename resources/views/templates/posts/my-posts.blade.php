@foreach($posts as $post)
    @include('templates.posts.my-post', ['post' => $post])
@endforeach