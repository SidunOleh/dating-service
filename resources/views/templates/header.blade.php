<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
</head>

<body>

    @guest
    <header class="header" id="header">
        
        <a href="#" class="advertising-banner">
            <img src="{{ asset('assets/img/adv.jpg') }}" alt="" />
            <p>www.nazarbazar.com</p>
        </a>

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
    </header>
    @endguest

    @auth
    <header class="header" id="header">
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
            
            <div class="header-menu">

                <div class="head">
                    <div class="user-mail">
                        {{ Auth::user()->email }}
                    </div>
                    <div class="close red flex">
                        <img src="{{ asset('assets/img/close.svg') }}" alt="" />
                    </div>
                </div>
                
                <div class="coins">
                    <img src="{{ asset('assets/img/coins.svg') }}" alt="" />
                    <span>
                        {{ Auth::user()->balance }}
                    </span>
                    <div class="add-coins flex red">
                        <img src="{{ asset('assets/img/plus.svg') }}" alt="" />
                    </div>
                </div>
                
                <div class="search-container">
                    <input type="text" name="query" class="search-input" placeholder="Search" />
                    <button type="submit" class="search-button">
                        <img src="{{ asset('assets/img/search.svg') }}" alt="Search" />
                    </button>
                </div>

                <div class="form-container">
                    
                    <div class="form-group">
                        <label for="category">Show me:</label>
                        <select id="category" name="category">
                            <option value="all">All</option>
                            <option value="category1">Category 1</option>
                            <option value="category2">Category 2</option>
                        </select>
                    </div>

                    <div class="zip-distance-group">
                        <input type="text" id="zip" name="zip" class="zip-input" placeholder="ZIP code" />
                        <select id="distance" name="distance">
                            <option value="all-miles">All miles</option>
                            <option value="10-miles">10 miles</option>
                            <option value="50-miles">50 miles</option>
                            <option value="100-miles">100 miles</option>
                        </select>
                    </div>

                </div>

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
        </div>
    </header>
    @endauth