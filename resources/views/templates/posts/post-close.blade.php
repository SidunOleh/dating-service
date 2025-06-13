<div class="post" data-id="{{ $post->id }}">
    <div class="post__body">
        <div class="post__content with-blur">
            <div class="blur">
                <div class="blur__body">
                    <div class="alert success">
                        <div class="blur__text">MY WINNER!</div>
                        <div class="blur__text unlock">
                            <div>Free unlock </div>
                            <div class="price">+<img src="{{ asset('/assets/img/MeowIcon.svg') }}" class="meowicon" alt="" /> 1</div>
                            <div>Your bonus!</div>
                        </div>
                    </div>
                    <div class="alert fail">
                        <div class="blur__text">Missed! Try another one!</div>
                        <div class="blur__text price">-<img src="{{ asset('/assets/img/MeowIcon.svg') }}" class="meowicon" alt="" /> 1</div>
                    </div>
                    <div class="blur__text" style="margin-bottom: 20px;">
                        Choose Your Lucky Paw! 
                    </div>
                    <div class="lucky-text" style="margin-bottom: 10px;">
                        First guess right? 
                        <br>
                        You get a double bonus and a free unlock!
                    </div>
                    <div class="post__btns">
                        <div 
                            data-number="1"
                            @class(['paw-btn', 'clicked' => $post->buttonClicked(1)])>
                            <img src="{{ asset('/assets/img/buPaw1.svg') }}" alt="">
                        </div>
                        <div 
                            data-number="2"
                            @class(['paw-btn', 'clicked' => $post->buttonClicked(2)])>
                            <img src="{{ asset('/assets/img/buPaw2.svg') }}" alt="">
                        </div>
                        <div 
                            data-number="3"
                            @class(['paw-btn', 'clicked' => $post->buttonClicked(3)])>
                            <img src="{{ asset('/assets/img/buPaw3.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="lucky-text unlock">
                        <p>Unlock price:</p>
                        <p class="price"><img src="{{ asset('/assets/img/MeowIcon.svg') }}" class="meowicon" alt="" /> 1</p>
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