@extends('layouts.main_app')

@section('content')

        <main class="py-2">
            <div class="jumbotron mt-5 mb-5 jumbotron_edited">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input type="email" name="search" id="search" class="form-control" placeholder="Search From Pull Of Website" aria-label="Product name" style="height: 70px;">
                        </div>
                        <div id="tbody">
                        </div>
                    </div>
                </div>
            </div>
        </main>

        
    <h1 class="mb-3">Featured Site</h1>
    
    <div class="card-columns">
        @foreach($sites as $site)
            <div class="card text-center">
                @if($site->logo != '')
                    <img src="{{ asset('sites_logo/'.$site->logo) }}" class="rounded img-thumbnail mt-3" alt="{{ $site->name }}">
                @else
                    <img src="{{ asset('sites_logo/default.png') }}" class="rounded img-thumbnail mt-3" alt="{{ $site->name }}">
                @endif
                <div class="card-body">
                <h5 class="card-title"> <a href="http://{{ $site->domain}}.ostemschool.test" class="post_list_title"> {{ $site->name }} </a> </h5>
                </div>
            </div>
        @endforeach
    </div>
    </div>

    
@endsection