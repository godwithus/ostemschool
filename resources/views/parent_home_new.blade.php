@extends('layouts.app')

@section('content')

@include('layouts.partials.errors')


    <style>
    .black {
        color: #333333;
    }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/cover.css') }}" rel="stylesheet">


  </head>
  <div class="text-center" style="background-image: url({{ asset('sites_bg/bg.jpg') }});">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="masthead mb-auto">
            <div class="inner">
            <h3 class="masthead-brand">Community</h3>
            <nav class="nav nav-masthead justify-content-center">
                <a class="nav-link active" href="#">Home</a>
                <a class="nav-link" href="#">Articles</a>
                <a class="nav-link" href="#">Forum</a>
            </nav>
            </div>
        </header>

        <main role="main" class="inner cover mt-5 py-5">
            <h1 class="cover-heading">
                    
                <div class="input-group mb-3">
                <input type="text" class="form-control" style="height: 50px;" placeholder="Browse Site" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="button-addon2">Search</button>
                </div>
                </div>
            </h1>
        </main>

  <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="text-center"> Search User to Make Admin </h3>
                    <div class="input-group">
                        <input type="email" name="search" id="search" class="form-control" placeholder=" Search By Email" aria-label="Product name">
                    </div>
                    <div class="text-center"> Making any one an Admin will give them there access to create, update and delete the post on your site</div>
                    <div id="tbody">
                    </div>

                </div>
            </div>
        </div>
    </div>


    <h1 class="mb-5">Featured Site</h1>
        <div class="card-columns">
            @foreach($sites as $site)
                <div class="card">
                    @if($site->logo != '')
                        <img src="{{ asset('sites_logo/'.$site->logo) }}" class="rounded img-thumbnail mt-5" alt="{{ $site->name }}">
                    @else
                        <img src="{{ asset('sites_logo/default.png') }}" class="rounded img-thumbnail mt-5" alt="{{ $site->name }}">
                    @endif
                    <div class="card-body">
                    <h5 class="card-title"> <a href="http://{{ $site->domain}}.ostemschool.test" class="black"> {{ $site->name }} </a> </h5>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</div>


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
        });
    });
</script>
@endsection