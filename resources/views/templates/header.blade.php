<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ env('APP_NAME') }}">

    <title>{{ env('APP_NAME') }}</title>

    @if(in_array(Route::currentRouteName(), ['profile.page', 'my-profile.show',]))
        @embedstyles('assets/css/fancybox.css')
    @endif

    @embedstyles('assets/css/main.css')
</head>

<body @class(['height' => Route::currentRouteName() == 'settings.page',])>

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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M16.893 16.92L19.973 20M19.084 11.581C19.084 15.768 15.701 19.162 11.529 19.162C7.35602 19.162 3.97302 15.768 3.97302 11.582C3.97302 7.393 7.35602 4 11.528 4C15.701 4 19.084 7.394 19.084 11.581Z" stroke="url(#paint0_linear_1306_19139)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <defs>
                                    <linearGradient id="paint0_linear_1306_19139" x1="11.973" y1="4" x2="11.973" y2="20" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7A0004"/>
                                    <stop offset="1" stop-color="#BA0007"/>
                                    </linearGradient>
                                </defs>
                            </svg>  
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

                <div class="log-out btn red">
                    <a href="{{ route('web.logout') }}">
                        Log out
                    </a>   
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