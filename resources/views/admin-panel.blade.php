<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1440, initial-scale=1, maximum-scale=1" />
    
    <title>Admin Panel • {{ config('app.name') }}</title>
   
    <link rel="icon" type="image/svg" href="/favicon.svg">
</head>

<body style="margin: 0px;">

    <div id="app">
        <style>
            .loader-body {
                height: 100vh;
                width: 100vw;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            
            .loader {
                --c: no-repeat linear-gradient(#1677ff 0 0);
                background: var(--c), var(--c), var(--c), var(--c), var(--c), var(--c), var(--c), var(--c), var(--c);
                background-size: 16px 16px;
                animation: l32-1 1s infinite, l32-2 1s infinite;
            }
            
            @keyframes l32-1 {
                0%,
                100% {
                    width: 45px;
                    height: 45px
                }
                35%,
                65% {
                    width: 65px;
                    height: 65px
                }
            }
            
            @keyframes l32-2 {
                0%,
                40% {
                    background-position: 0 0, 0 50%, 0 100%, 50% 100%, 100% 100%, 100% 50%, 100% 0, 50% 0, 50% 50%
                }
                60%,
                100% {
                    background-position: 0 50%, 0 100%, 50% 100%, 100% 100%, 100% 50%, 100% 0, 50% 0, 0 0, 50% 50%
                }
            }
            
            @keyframes l15-0 {
                0%,
                49.99% {
                    transform: scale(1)
                }
                50%,
                100% {
                    transform: scale(-1)
                }
            }
            
            @keyframes l15-1 {
                0% {
                    transform: translateX(-37.5%) rotate(0turn)
                }
                80%,
                100% {
                    transform: translateX(-37.5%) rotate(1turn)
                }
            }
        </style>
        
        <div class="loader-body">
            <div class="loader"></div>
        </div>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</body>

</html>