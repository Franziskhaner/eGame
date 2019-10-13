<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'eGame') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/material-fullpalette.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/css/ripples.min.css">
{{--
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><!--Para la valoración con Rating Stars -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <!-- Para la valoración con RateYo -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse bg-primary navbar-static-top"><!-- También se puede cambiar el navbar por navbar-default, navbar-dar, light, etc -->
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}"><i class="fa fa-fw fa-home"></i>
                        eGame
                    </a> 
                {{--<a class="navbar-brand" href="#"><i class="fa fa-fw fa-envelope"></i> Contact</a>--}} <!-- Para el botón Contacto -->
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-left">
                        <div class="dropdown">
                            <button class="dropbtn">Platforms 
                              <i class="fa fa-caret-down"></i>
                            </button>
                            <div class="dropdown-content">
                              <a href="{{action('ArticleController@showByPlatform', 'PS4')}}">PS4</a>
                              <a href="{{action('ArticleController@showByPlatform', 'XBOX ONE')}}">XBOX ONE</a>
                              <a href="{{action('ArticleController@showByPlatform', 'PC')}}">PC</a>
                              <a href="{{action('ArticleController@showByPlatform', 'NINTENDO SWITCH')}}">NINTENDO SWITCH</a>
                              <a href="{{action('ArticleController@showByPlatform', 'NINTENDO 3DS')}}">NINTENDO 3DS</a>
                              <a href="{{action('ArticleController@showByPlatform', 'WII U')}}">WII U</a>
                              <a href="{{action('ArticleController@showByPlatform', 'PLAYSTATION VITA')}}">PLAYSTATION VITA</a>
                              <a href="{{action('ArticleController@showByPlatform', 'RETRO')}}">RETRO</a>
                            </div>
                        </div>
                    </ul>
                    <!-- Center Side Of Navbar -->
                    <div class="col-md-4">
                        <form action="{{action('MainController@search', 'search')}}" method="get">
                            <div class="input-group" style="display: inline-block;">
                                <input type="search" name="search" class="form-control">
                                <span class="input-group-prepend">
                                    <button type="submit" class="btn btn-success">Search</button>
                                <!--{{--<button type="submit"><i class="fa fa-search"></i></button>--}}-->
                                </span>
                            </div>
                        </form>
                    </div>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li>
                            <a href="{{url('/cart')}}">
                                <span class= "glyphicon glyphicon-shopping-cart"></span>
                                {{$articlesCount}}
                            </a>
                        </li>
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}"><i class="fa fa-fw fa-user"></i> Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-fw fa-user"></i> 
                                    {{ Auth::user()->first_name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        @if (Auth::user()->role == 'Admin')
                                            <a href="{{ route('users.index') }}"
                                                title="Users">
                                                Users
                                            </a>
                                            <a href="{{ route('articles.index') }}"
                                                title="Articles">
                                                Articles
                                            </a>
                                            <a href="{{ route('orders.index') }}"
                                                title="Orders">
                                                Orders
                                            </a>
                                        @else
                                            <a href="{{ route('account') }}"
                                                title="Your Account">
                                                Your Account
                                            </a>
                                            <a href="{{ route('user_orders')}}"
                                                title="Your Orders">
                                                Your Orders
                                            </a>
                                        @endif
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul> 
                </div>
            </div>
        </nav>
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
{{--    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/material.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/ripples.min.js"></script><!-- ripples.min.js es para el efecto de onda al clicar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script><!-- Para el rating del articulo -->
    <script>
        $.material.init();
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
