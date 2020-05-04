<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>

        .content{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 150px;
        }
        .welcome__title{
            font-family: 'Montserrat', sans-serif;
            font-weight: bold;
            font-size: 100px;
            color: rgb(30, 30, 30);
        }
        .welcome__content{
            font-family: 'Montserrat', sans-serif;
            font-size: 20px;
            text-align: center;
        }
        .nav{
            text-align: right;
            padding: 20px;
        }
        .welcome__link{
                font-family: 'Montserrat', sans-serif;
                text-decoration: none;
                color: rgb(30, 30, 30);
                margin-left: 20px;

        }
        .welcome__link:hover{
            color: grey;
        }
        .welcome__button{
            display: block;
            background-color: rgb(30, 30, 30);
            margin-top: 15px;
            padding: 10px;
            color: white;
            font-size: 14px;
            font-family: 'Montserrat', sans-serif;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
    </style>
</head>

<body>
    <div class="">
        @if (Route::has('login'))
        <div class="nav">
            @auth
            <a href="{{ url('/home') }}" class="welcome__link">Accueil</a>
            @else
            <a href="{{ route('login') }}" class="welcome__link">Connexion</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="welcome__link">Inscription</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
            <div class="welcome__title">
                Jadwal
            </div>
            <p class="welcome__content">Votre assistant d'envoi de mail et de création de session d'examen</p>
            <a href="{{ url('/home') }}" class="welcome__button">commencer</a>
        </div>
    </div>
</body>

</html>
