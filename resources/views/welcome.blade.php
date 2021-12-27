<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LARA KKN</title>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="icon" href="{{ url('favicons/favicon.ico?v=1') }}" type="image/x-icon"/>
    <!-- Styles -->

    <style>
        html,
        body {
            background-color: #fff;
            color: #DDDDDD;
            font-family: 'Roboto', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
            background-image: url('images/home.jpg');
            background-size: cover;
            background-position:top center;
            align-items: center;
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
            margin-top: 40vh;
            margin-bottom: 30vh;
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .title small {
            font-size: 60px;
        }

        .links>a {
            color: whitesmoke;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
            display: flex;
            flex-direction: row;
            justify-content: center;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .gh-logo {
            transition: 0.3s;
        }
        .gh-logo:hover {
            opacity: 80%;
        }
    </style>

</head>

<body>
    <div style="">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
            <div class="top-right links">
                @auth
                <a href="{{ url('/home') }}">Home</a>
                @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
                @endif
                @endauth
            </div>
            @endif
            <div class="content">
                <div class="title ">
                    LARA KKN<br />
                    <small>
                        Laravel Based KKN Management System
                    </small>
                </div>
                <br />
                <br />
                <br />
                <div class="links">
                    <a> Created by : </a>
                </div>
                <div class="links">
                    <a>Hersyanda Putra Adi</a>
                    <a>Irfan Abdurrazaq</a>
                </div>
                <br />
                <br />
                <div class="links" style="color: #fff !important;">
                    <a> Find this Project on : </a>
                </div>
                <div class="links">
                    <a class="gh-logo" href="https://github.com/rlmyandaa/LaraKKN_8"><img src="images/github.png"></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>