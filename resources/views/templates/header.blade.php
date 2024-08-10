<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PXXCB3JB');</script>
    <!-- End Google Tag Manager -->

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ env('APP_NAME') }}">

    <title>{{ env('APP_NAME') }}</title>

    @embedstyles(Route::currentRouteName() == 'profile.page', 'assets/css/fancybox.css')
    @embedstyles(true, 'assets/css/main.css')
</head>

<body @class(['height' => Route::currentRouteName() == 'settings.page',])>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PXXCB3JB"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <script>
        const DS = {}
    </script>

    @guest('web')
    <header class="header" id="header">

        <div class="header-wrapper">
            @includeWhen(isset($topAd), 'templates.top-ad', ['ad' => $topAd ?? null,]) 

            <div class="header-body">
                <div class="left">
                    <a href="{{ route('home.index') }}" class="btn red">
                        <img src="{{ asset('assets/img/tabler_cherry-filled.svg') }}" alt="" />
                    </a>
                </div>
                
                <a href="{{ route('home.index') }}" class="logo">
                    {{ env('APP_NAME') }}
                </a>

                <div class="right">
                    <div class="btn red login">
                        Log in
                    </div>
                    <div class="btn signup">
                        Sign up
                    </div>
                </div>

                <div class="header-burger">
                    <img src="{{ asset('assets/img/burger.svg') }}" alt="" />
                </div>
            </div>
        </div>
        
    </header>
    @endguest

    @auth('web')
    <header class="header" id="header">
        
        @includeWhen(isset($topAd), 'templates.top-ad', ['ad' => $topAd ?? null,]) 
        
        <div class="header-wrapper">

            <div class="header-menu">

                <div class="head">
                    <div class="user-mail">
                        {{ auth('web')->user()->email }}
                    </div>
                    <div class="close red flex">
                        <img src="{{ asset('assets/img/close.svg') }}" alt="" />
                    </div>
                </div>

                <div class="coins">
                    <img src="{{ asset('assets/img/coins.svg') }}" alt="" />
                    <span>
                        {{ auth('web')->user()->balance }}
                    </span>
                    <div class="add-coins flex red">
                        <a href="{{ route('subscription.page') }}#deposit">
                            <img src="{{ asset('/assets/img/plus.svg') }}" alt="" />
                        </a>
                    </div>
                </div>

                <div class="search-container">
                    <form action="/" method="GET">
                        <input 
                            type="text" 
                            name="s"
                            class="search-input" 
                            placeholder="Search" 
                            value="{{ request()->query('s') }}"/>
                        <button type="submit" class="search-button">
                            <img src="{{ asset('assets/img/search.svg') }}" alt="Search" />
                        </button>
                    </form>
                </div>

                <div class="form-container">
                    <form id="filters-form" action="/" method="GET">

                        <div class="form-fields">

                            <div class="zip-distance-group form-group">
                                <input 
                                    type="text" 
                                    id="zip" 
                                    name="zip" 
                                    class="zip-input" 
                                    placeholder="ZIP code" 
                                    value="{{ request()->query('zip') }}"/>
                            </div>

                            <div class="form-group">
                                <select id="distance" name="miles">
                                    <option disabled selected>
                                        All miles
                                    </option>
                                    @foreach([10, 50, 100,] as $miles)
                                        <option value="{{ $miles }}" @selected(request()->query('miles') == $miles)>
                                            {{ $miles }} miles
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select id="category" name="gender">
                                    <option disabled selected>
                                        All
                                    </option>
                                    @foreach(['Man', 'Woman', 'LGBTQIA+',] as $gender)
                                        <option value="{{ $gender }}" @selected(request()->query('gender') == $gender)>
                                            {{ $gender }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <button type="submit" class="btn red">
                            Show matches
                        </button>

                    </form>
                </div>

                <div class="pages">
                    
                    <div class="pages-list">

                        <a href="{{ route('subscription.page') }}" class="pages-item red">
                            <p class="name">Subscription</p>
                            <img src="{{ asset('assets/img/sub.svg') }}" alt="" class="icon" />
                        </a>
                        
                        <a href="{{ route('earn.page') }}" class="pages-item red">
                            <p class="name">Earn with us</p>
                            <img src="{{ asset('assets/img/earn.svg') }}" alt="" class="icon" />
                        </a>
                        
                        <a href="{{ route('top-vote.page') }}" class="pages-item red">
                            <p class="name">Top vote</p>
                            <img src="{{ asset('assets/img/top.svg') }}" alt="" class="icon" />
                        </a>
                        
                        <a href="{{ route('my-profile.show') }}" class="pages-item red">
                            <p class="name">My post</p>
                            <img src="{{ asset('assets/img/post.svg') }}" alt="" class="icon" />
                        </a>
                        
                        <a href="{{ route('favorites.index') }}" class="pages-item red">
                            <p class="name">Favorites</p>
                            <img src="{{ asset('assets/img/favorite.svg') }}" alt="" class="icon" />
                        </a>
                        
                        <a href="{{ route('settings.page') }}" class="pages-item red">
                            <p class="name">Settings</p>
                            <img src="{{ asset('assets/img/settings.svg') }}" alt="" class="icon" />
                        </a>

                    </div>
                </div>

            </div>

            <div class="header-body">
                <div class="left">
                    <a href="{{ route('home.index') }}" class="btn red">
                        <img src="{{ asset('assets/img/tabler_cherry-filled.svg') }}" alt="" />
                    </a>
                </div>

                <a href="{{ route('home.index') }}" class="logo">
                    {{ env('APP_NAME') }}
                </a>
                
                <div class="burger-menu red flex">
                    <img src="{{ asset('assets/img/burger.svg') }}" alt="" />
                </div>
            </div>

        </div>

    </header>
    @endauth