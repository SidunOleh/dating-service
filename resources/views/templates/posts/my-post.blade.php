<div 
    @class(['post', 'pending' => $post->status == 'pending', 'rejected' => $post->status == 'rejected'])
    data-id="{{ $post->id }}">
    <div class="post__body">
        <div class="post__content">
            <div class="post__imagesbox">
                <div class="post__images">
                    @foreach($post->imagesModels as $image)
                    <div class="slide">
                        <a href="{{ $image->getUrl() }}" data-fancybox="post-{{ $post->id }}">
                            <img src="{{ $image->getUrl() }}" alt="">
                        </a>
                    </div>
                    @endforeach
                </div>

                <div class="arrow prev">
                    <img src="{{ asset('assets/img/prev.svg') }}" alt="" />
                </div>
                <div class="arrow next">
                    <img src="{{ asset('assets/img/next.svg') }}" alt="" />
                </div>
            </div>
            <div class="post__card">
                @if($post->text)
                <div class="post__text">
                    {{ $post->text }}
                </div>
                @endif
                <div class="post__date">
                    {{ $post->created_at->format('d M, Y') }}
                </div>
            </div>
        </div>

        @if ($post->status == 'approved')
        <div class="post__close btn red">
            <img src="{{ asset('assets/img/close.svg') }}" alt="" />
        </div>
        @endif
    </div>

    @includeWhen(
        $post->status == 'rejected', 
        'templates.rejected', 
        ['comments' => [$post->approve_comment]]
    )
</div>

<script>
    window[`postSlider{{ $post->id }}Ini`] = () => {
        if ($('[data-id={{ $post->id }}] .slide').length < 2) {
            $('[data-id={{ $post->id }}] .arrow').hide()
            return
        }

        $('[data-id={{ $post->id }}] .post__images').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: $('[data-id={{ $post->id }}]').find('.prev'),
            nextArrow: $('[data-id={{ $post->id }}]').find('.next'),
            infinite: false,
        })
    }

    if (typeof $ !== 'undefined') {
        window[`postSlider{{ $post->id }}Ini`]()
    } else {
        document.addEventListener('DOMContentLoaded', () => window[`postSlider{{ $post->id }}Ini`]())
    }
</script>