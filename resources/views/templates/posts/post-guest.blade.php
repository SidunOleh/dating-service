<div class="post" data-id="{{ $post->id }}">
    <div class="post__body">
        <div class="post__content with-blur">
            <div class="blur">
                <div class="blur__body">
                    <div class="blur__text">
                        Log In, to see Post
                    </div>
                    <div class="btn red login">
                        Log In
                    </div>
                </div>
            </div>
            <img src="{{ get_random_photo() }}" alt="" class="post__image">
            <div class="post__card">
                <div class="post__text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident porro ducimus repudiandae in, obcaecati error ullam unde explicabo modi quis architecto repellat iste magnam rerum excepturi exercitationem pariatur debitis! Perspiciatis, sequi! Atque nobis eum minima assumenda pariatur impedit facere numquam aut! Nisi autem dolore sit repellat quaerat neque vero excepturi!
                </div>
                <div class="post__date">
                    {{ date('d M, Y') }}
                </div>
            </div>
        </div>
    </div>
</div>