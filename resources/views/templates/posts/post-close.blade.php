<div class="post" data-id="{{ $post->id }}">
    <div class="post__body">
        <div class="post__content with-blur">
            <div class="blur">
                <div class="blur__body">
                    <div class="blur__text">
                        Click buttons to open post
                    </div>
                    <div class="post__btns">
                        <div 
                            data-number="1"
                            @class(['btn', 'clicked' => $post->buttonClicked(1)])>
                            1
                        </div>
                        <div 
                            data-number="2"
                            @class(['btn', 'clicked' => $post->buttonClicked(2)])>
                            2
                        </div>
                        <div 
                            data-number="3"
                            @class(['btn', 'clicked' => $post->buttonClicked(3)])>
                            3
                        </div>
                    </div>
                    <div class="error"></div>
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