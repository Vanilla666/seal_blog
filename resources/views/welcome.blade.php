<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    大海豹專區
                </div>
                <svg width="220" height="150" > <!-- SVG 的邊框 style="border:3px solid green" -->
                <circle cx="0" cy="0" r="35" stroke="black" stroke-width="3" fill="red" >
                <animateMotion dur="1.75s" path="M0 100 Q50 50, 200 95" repeatCount="indefinite" rotate="auto" /> 
                </circle>
                <path  d="M0 100 Q50 50, 200 95"  fill="none"/> <!-- stroke="black" 畫黑線 fill="none" 不填滿  -->
                </svg>
                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="./post">貼文區</a> <!-- 貼文專區 -->
                    <a href="./personal">個人專區</a> <!-- 個人專區 -->
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
                <img src="http://files.57gif.com/webgif/0/0/aa/e5e4837533138808bcd989d940a04.gif" alt="Smiley face" width="50%" height="50%"> <!-- 海豹.gif -->
            </div>
        </div>
     
    </body>
</html>
