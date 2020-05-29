<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlyte.css') }}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 

    <style>
        nav > a, #navbarTogglerDemo02 > ul > li > a {
            color: #ffffff !important;
        }

        .site_name{
            font-size: 40px;
        }
        
        .jumbotron_edited{
            background-color: #ffffffa6;
        }

        .body_font_size{
            font-size: 16px;
            color: #000000;
        }
        
        .container_bg{
          background-color: #ffffffa3;
        }
        
        .post_list_title{
            color: #333333;
            text-transform: capitalize;
        }

</style>

</head>
<body  style="background-image: url({{ asset('sites_bg/bg.jpg') }}); background-position: center; background-attachment:fixed;">

    <div id="app" class="container">
    <header class="masthead">
      <h4>&nbsp;</h4>
      <nav class="navbar navbar-expand-md navbar-light bg-dark rounded mb-3 ">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" height="40"/>
      </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon" style="background-color: #ffffff !important;"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav text-md-center nav-justified w-100">
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('allBlog') }}" >Articles <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('create.site') }}"> Create Site </a>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" href="index.html#">Check Result</a>
            </li>


            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                      <li class="nav-item">
                        <a href="{{ route('profile', Auth::user()->id) }}"  class="dropdown-item" > Profile</a>
                      </li>

                      <div class="dropdown-divider"></div>

                      <li class="nav-item">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                      </li>
                    </ul>
                </li>
            @endguest

          </ul>
        </div>
      </nav>
    </header>

    
    @if(Auth::check() && Auth::user()->email_verified_at == '')
      <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
          @csrf
          <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
      </form>
    @endif

    <main class="py-2">
            @yield('content')
    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/popper.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>

    
<script>
    $(document).ready(function(){
        fetch_customer_data();
        function fetch_customer_data(query = '')
        {
            $.ajax({
                url:"{{ route('live_search.site') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_customer_data(query);
            
            if(query.length < 1){
                document.getElementById('tbody').style.display = 'none';
            } else{
                document.getElementById('tbody').style.display = 'block';
            }
        });
    });
</script>
    
</body>
</html>