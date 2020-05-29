<?php 
  use App\CreateSite; 
  use App\BlogAdmin; 
  use \Carbon\Carbon;

   // We want to get the Domain of the Current Domain the Use is ON
   $domain = new CreateSite();
   $getByDomain = $domain->getUrl();
   $creator = '';

  $bg = $getByDomain->bg == '' ? 'default.jpeg' : $getByDomain->bg;

   // We want to know if such Domain exist at all in our Database
   if (Auth::check() && $getByDomain != null) {
      $creator = BlogAdmin::where('user_id', auth()->user()->id)
                ->where('site_id', $getByDomain->id)
                ->count();
   }

?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')

    <!-- Scripts -->

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


        /* Customize the label (the container) */
.container_new {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container_new input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark_new {
  position: absolute;
  top: 0;
  left: 0;
  border: 2px solid #333;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container_new:hover input ~ .checkmark_new {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container_new input:checked ~ .checkmark_new {
  background-color: #2196F3;
}

/* Create the checkmark_new/indicator (hidden when not checked) */
.checkmark_new:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark_new when checked */
.container_new input:checked ~ .checkmark_new:after {
  display: block;
}

/* Style the checkmark_new/indicator */
.container_new .checkmark_new:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}

.my-editor{
    width: 100% !important;
    min-height: 500px;
}

.post-content img{
  max-width: 100%;
  max-height: 100%;
  margin: auto;
  display: block;
}

.inner_post_body{
  background-color: #ffffffad;
  border-radius: 10px;
  padding: 20px;
}

.change_cursor{
  cursor: pointer;
  color: #555555;
}
.mini_title_box{
  background-color: #343a40;
  color: #ffffff;
  border-radius: 10px;
  padding: 10px;
}

.post_list_title{
  color: #333333;
  text-transform: capitalize;
}

.link{
  background-color: red;
  color: #ffffff;
  border-radius: 10px;
  padding: 10px;
}

.form-control:focus {
    outline: 0 !important;
    border-color: initial;
    box-shadow: none;
}
    </style>
</head>
<body style="background-image: url({{ asset('sites_bg/'.$bg) }}); background-position: center; background-size: cover; background-attachment:fixed;">
    <div id="app" class="container container_bg">
    <header class="masthead">
      <h4>&nbsp;</h4>
      <nav class="navbar navbar-expand-md navbar-light bg-dark rounded mb-3 ">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}"  height="40"/>
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
              <a class="nav-link" href="#"> Past Questions </a>
            </li>

            @if(Auth::check())
              @if(($getByDomain->user_id == Auth::user()->id) || ($creator > 0 ) )
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
              @endif
            @endif

           
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
    </div>

    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/popper.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>

    @yield('script_holder')
    
</body>
</html>
