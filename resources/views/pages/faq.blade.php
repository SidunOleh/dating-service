@include('templates.header', ['title' => 'FAQ',])

<section class="faq">
    <div class="container">
        <div class="sidebar">
            <p class="title">FAQ</p>

            <ul class="sidebar-menu">

                @foreach ($faq as $item)
                    @if (! $item['children'])
                        <li class="sidebar-menu-item" data-target="{{ Str::slug($item['title']) }}">
                            {{ $item['title'] }}
                        </li>
                    @else
                        <li class="sidebar-menu-item accordion">
                            <p class="accordion-open">
                                {{ $item['title'] }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M12.7064 15.7073C12.5188 15.8948 12.2645 16.0001 11.9994 16.0001C11.7342 16.0001 11.4799 15.8948 11.2924 15.7073L5.63537 10.0503C5.53986 9.9581 5.46367 9.84775 5.41126 9.72575C5.35886 9.60374 5.33127 9.47252 5.33012 9.33974C5.32896 9.20696 5.35426 9.07529 5.40454 8.95239C5.45483 8.82949 5.52908 8.71784 5.62297 8.62395C5.71686 8.53006 5.82852 8.4558 5.95141 8.40552C6.07431 8.35524 6.20599 8.32994 6.33877 8.33109C6.47155 8.33225 6.60277 8.35983 6.72477 8.41224C6.84677 8.46465 6.95712 8.54083 7.04937 8.63634L11.9994 13.5863L16.9494 8.63634C17.138 8.45418 17.3906 8.35339 17.6528 8.35567C17.915 8.35795 18.1658 8.46312 18.3512 8.64852C18.5366 8.83393 18.6418 9.08474 18.644 9.34694C18.6463 9.60914 18.5455 9.86174 18.3634 10.0503L12.7064 15.7073Z"
                                    fill="white"
                                    />
                                </svg>
                            </p>
                            <ul class="accordion-pannel">
                                @foreach ($item['children'] as $item)
                                    <li class="accordion-item" data-target="{{ Str::slug($item['title']) }}">
                                        {{ $item['title'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>

        </div>
        <div class="main">

            <div class="open-faq btn red">
                Show categories
            </div>

            <div class="top">
                <div class="search-wrapper">
                    <div class="input-wrapper">
                        <input type="text" class="search-input" placeholder="Search" />
                        <img src="{{ asset('/assets/img/search.svg') }}" alt="" />
                    </div>
                    <div class="result-wrapper">
                        <div class="search-result"></div>
                    </div>
                </div>
            </div>

            <div class="content">

                @foreach ($faq as $item)
                    @if (! $item['children'])
                        <div class="faq-content" id="{{ Str::slug($item['title']) }}">
                            <h2>
                                {{ $item['title'] }}
                            </h2>
                            <p>
                                {!! $item['text'] ? convert_quill_flat_lists_to_nested($item['text']) : '' !!}
                            </p>
                        </div>
                    @else
                        @foreach ($item['children'] as $item)
                            <div class="faq-content" id="{{ Str::slug($item['title']) }}">
                                <h2>
                                    {{ $item['title'] }}
                                </h2>
                                <p>
                                    {!! $item['text'] ? convert_quill_flat_lists_to_nested($item['text']) : '' !!}
                                </p>
                            </div>
                        @endforeach
                    @endif
                @endforeach

            </div>
            <div class="faq-navigation">
                <div class="faq-prev red"><img src="{{ asset('/assets/img/prev.svg') }}" alt="" /></div>
                <div class="faq-next red"><img src="{{ asset('/assets/img/next.svg') }}" alt="" /></div>
            </div>
        </div>
    </div>
</section>

<script>
    if (window.location.hash) {
        document.querySelector(`[data-target=${window.location.hash.substring(1)}]`)
            .classList.add('open')
        document.querySelector(window.location.hash)
            .style.display = 'block'
    } else {
        document.querySelector('[data-target]')
            .classList.add('open')
        document.querySelector('.faq-content')
            .style.display = 'block'
    }
</script>

@includeWhen(!auth('web')->check(), 'modals.auth')
@includeWhen(!auth('web')->check(), 'modals.verification')

@include('templates.footer')