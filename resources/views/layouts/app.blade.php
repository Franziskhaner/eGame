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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><!--Para la valoración con Rating Stars -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css"/>
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
                                <a href="{{action('ArticleController@showByPlatform', 'PS VITA')}}">PLAYSTATION VITA</a>
                                <a href="{{action('ArticleController@showByPlatform', 'RETRO')}}">RETRO</a>
                            </div>
                        </div>
                    </ul>
                    <!-- Center Side Of Navbar -->
                    <div class="col-md-3" style="margin-left: 120px; margin-top: 13px;">
                        <form class="search" action="{{action('MainController@search', 'search')}}" method="get">
                            <input list="articles" placeholder="Search a game..." name="search">
                            <datalist id="articles">
                                @foreach($articlesCollection as $article)
                                    <option value="{{ $article->name }}">{{$article->name}}</option>
                                @endforeach
                            </datalist>
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <!--Botón de búsqueda avanzada -->
                    <div class="col-md-3" style="margin-top: 3px;" onclick="advancedSearchFunction()">
                        <button class="btn btn-info">Advanced</button> 
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
                            <div class="dropdown">
                                <button href="#" class="dropbtn" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-fw fa-user"></i> 
                                    {{ Auth::user()->first_name }} <span class="caret"></span>
                                </button>
                                <div class="dropdown-content">
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
                                        <a href="{{ route('ratings.index') }}"
                                            title="Ratings">
                                            Ratings
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
                                        <a href="{{ route('user_ratings')}}"
                                            title="Your Ratings">
                                            Your Ratings
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
                                </div>
                            </div>
                        @endif
                    </ul> 
                </div>
            </div>
        </nav>
        <div class="panel panel-default" id="advancedSearch">
            <div class="panel-heading">
                <h3>Advanced Search</h3>
                <form id="searchForm" action="{{action('MainController@advancedSearch', 'advancedSearch')}}" method="get">
                    <div class="row">
                        <div class="col-md-2">
                            <input list="articles" placeholder="Name..." name="name">
                            <datalist id="articles">
                                @foreach($articlesCollection as $article)
                                    <option value="{{ $article->name }}">{{$article->name}}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-2">
                            <input list="platforms" placeholder="Platform..." name="platform">
                            <datalist id="platforms">
                                <option value="PS4">PS4</option>
                                <option value="XBOX ONE">XBOX ONE</option>
                                <option value="PC">PC</option>
                                <option value="NINTENDO SWITCH">NINTENDO SWITCH</option>
                                <option value="NINTENDO 3DS">NINTENDO 3DS</option>
                                <option value="WII U">WII U</option>
                                <option value="PS VITA">PLAYSTATION VITA</option>
                                <option value="RETRO">RETRO</option>
                            </datalist>
                        </div>
                        <div class="col-md-2">
                            <input list="genders" placeholder="Genders..." name="gender">
                            <datalist id="genders">
                                <option value="Action">Action</option>
                                <option value="Shooter">Shooter</option>
                                <option value="Fighting">Fighting</option>
                                <option value="Platformer">Platformer</option>
                                <option value="Horror">Horror</option>
                                <option value="Adventure">Adventure</option>
                                <option value="RPG">RPG</option>
                                <option value="Sport">Sport</option>
                                <option value="Strategy">Strategy</option>
                                <option value="Puzzle">Puzzle</option>
                                <option value="Racing">Racing</option>
                                <option value="Simulator">Simulator</option>
                                <option value="Open World">Open World</option>
                            </datalist>
                        </div>
                        <div class="col-md-2">
                            <input list="prices" placeholder="Price..." name="price">
                            <datalist id="prices">
                                <option value="Minus 10€"></option>
                                <option value="10€ - 20€"></option>
                                <option value="20€ - 30€"></option>
                                <option value="30€ - 40€"></option>
                                <option value="40€ - 50€"></option>
                                <option value="50€ - 60€"></option>
                                <option value="More 60€"></option>
                            </datalist>
                        </div>
                        <div class="col-md-2">
                            <input id="release_date" type="date" name="release_date" placeholder="Release date...">
                        </div>
                        <div class="col">
                            <input type="submit" class="btn btn-info" value="Search">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/material.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.3.0/js/ripples.min.js"></script><!-- ripples.min.js es para el efecto de onda al hacer click -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
    <script>
        /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
          dropdown[i].addEventListener("click", function() {
          this.classList.toggle("active");
          var dropdownContent = this.nextElementSibling;
          if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
          } else {
          dropdownContent.style.display = "block";
          }
          });
        }
    </script>
    <script>
        $("#input-id").rating();
    </script>
    <script name="selectedArticleToRate">
        function myFunction(parameter, parameter2){
            var select = parameter;
            select.addEventListener("change",
              function(){
                selectedGame = this.options[select.selectedIndex].text;
                var button = "#starButton-" + parameter2;
                $(button).attr("href", "rate_your_order/"+selectedGame);
              });
        }
    </script>
    <script>
        //* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
        function advancedSearchFunction(){
            var dropdownContent = document.getElementById("advancedSearch")

            if (dropdownContent.style.display === "none") {
              dropdownContent.style.display = "block";
            } else {
              dropdownContent.style.display = "none";
            }
        }
    </script>
    {{--
    <script name="slideShowCarousel">
        var slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
          showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
          showSlides(slideIndex = n);
        }

        function showSlides(n) {
          var i;
          var slides = document.getElementsByClassName("mySlides");
          var dots = document.getElementsByClassName("demo");
          var captionText = document.getElementById("caption");
          if (n > slides.length) {slideIndex = 1}
          if (n < 1) {slideIndex = slides.length}
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
          }
          for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
          }
          slides[slideIndex-1].style.display = "block";
          dots[slideIndex-1].className += " active";
          captionText.innerHTML = dots[slideIndex-1].alt;
        }
    </script>
    --}}
    <script
        src="https://checkout.stripe.com/checkout.js"
        data-key="{{ config('services.stripe.key') }}"
        image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-locale="auto">
        $(".stripe-button");
    </script>
    <script>
        $.material.init();
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
