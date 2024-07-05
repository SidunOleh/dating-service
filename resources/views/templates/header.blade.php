<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
</head>

<body>

    <script>
        const DS = {}
    </script>

    @guest('web')
    <header class="header" id="header">

        <div class="header-wrapper">
            @includeWhen($adsSettings->sole('name', 'show_top_ad')->value and $topAd, 'templates.top-ad', ['ad' => $topAd,]) 

            <div class="header-body">
                <div class="left">
                    <a href="{{ route('home') }}" class="btn red">
                        <img src="{{ asset('assets/img/tabler_cherry-filled.svg') }}" alt="" />
                    </a>
                </div>
                
                <a href="{{ route('home') }}" class="logo">
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
        
        @includeWhen($adsSettings->sole('name', 'show_top_ad')->value and $topAd, 'templates.top-ad', ['ad' => $topAd,]) 
        
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
                        <img src="{{ asset('assets/img/plus.svg') }}" alt="" />
                    </div>
                </div>

                <form method="GET" action="{{ route('home') }}" id="filters-form">

                    <div class="search-container">
                        <input 
                            type="text" 
                            name="s"
                            class="search-input" 
                            placeholder="Search" 
                            value="{{ request()->query('s') }}"/>

                        <button type="submit" class="search-button">
                            <img src="{{ asset('assets/img/search.svg') }}" alt="Search" />
                        </button>
                    </div>

                    <div class="form-container">
                        
                        <div class="form-group">
                            <label for="category">
                                Show me:
                            </label>
                            <select id="category" name="gender">
                                <option disabled selected>
                                    All
                                </option>
                                @foreach(['Man', 'Woman', 'LGBTQ+',] as $gender)
                                <option value="{{ $gender }}" @selected(request()->query('gender') == $gender)>
                                    {{ $gender }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="zip-distance-group">
                            <input 
                                type="text" 
                                id="zip" 
                                name="zip" 
                                class="zip-input" 
                                placeholder="ZIP code" 
                                value="{{ request()->query('zip') }}"/>

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

                    </div>

                    <button type="submit" class="btn" style="margin: 20px 0 10px 0; width: 100%;">
                        Apply
                    </button>

                </form>

                <div class="pages">
                    
                    <div class="pages-list">

                        <a href="" class="pages-item red">
                            <p class="name">Subscription</p>
                            <img src="{{ asset('assets/img/sub.svg') }}" alt="" class="icon" />
                        </a>
                        
                        <a href="" class="pages-item red">
                            <p class="name">Earn with us</p>
                            <img src="{{ asset('assets/img/earn.svg') }}" alt="" class="icon" />
                        </a>
                        
                        <a href="" class="pages-item red">
                            <p class="name">Top vote</p>
                            <img src="{{ asset('assets/img/top.svg') }}" alt="" class="icon" />
                        </a>
                        
                        <a href="" class="pages-item red">
                            <p class="name">My post</p>
                            <img src="{{ asset('assets/img/post.svg') }}" alt="" class="icon" />
                        </a>
                        
                        <a href="" class="pages-item red">
                            <p class="name">Favorites</p>
                            <img src="{{ asset('assets/img/favorite.svg') }}" alt="" class="icon" />
                        </a>
                        
                        <a href="" class="pages-item red">
                            <p class="name">Settings</p>
                            <img src="{{ asset('assets/img/settings.svg') }}" alt="" class="icon" />
                        </a>

                    </div>
                </div>

            </div>

            <div class="header-body">
                <div class="left">
                    <a href="{{ route('home') }}" class="btn red">
                        <img src="{{ asset('assets/img/tabler_cherry-filled.svg') }}" alt="" />
                    </a>
                </div>

                <a href="{{ route('home') }}" class="logo">
                    {{ env('APP_NAME') }}
                </a>
                
                <div class="burger-menu red flex">
                    <img src="{{ asset('assets/img/burger.svg') }}" alt="" />
                </div>
            </div>

        </div>

    </header>
    @endauth