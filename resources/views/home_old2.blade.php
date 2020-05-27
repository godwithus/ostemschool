@extends('layouts.app')

@section('content')

<div class="container">

<div class="jumbotron jumbotron_edited">
  @include('layouts.partials.edit_site_details')
  @include('layouts.partials.errors')


  <div class="text-center">
  @if($getByDomain->logo != '')
    <img src="{{ asset('sites_logo/'.$getByDomain->logo) }}" class="rounded img-thumbnail" alt="...">
  @else
    <img src="{{ asset('sites_logo/default.png') }}" class="rounded img-thumbnail" alt="...">
  @endif
  <h1 class="display-3 site_name">{{ $getByDomain->name }}</h1>
  <p class="lead"> {{ $getByDomain->description }}  
    @if(Auth::check() && $getByDomain->user_id == Auth::user()->id)
    <button class="btn btn-success btn-sm"  data-toggle="modal" data-target="#editSite">edit</button> 
    @endif
  </p>
  </div>
</div>
  

  
</div>


@if($sticky_threads_count > 1 )
  <h1 class="mb-5 mt-5">
    <span class="mini_title_box">Featured Article </span>
    @if($sticky_threads_count > 6 )
      <span class="float-right"> <a href="#" class="btn btn-success">see all </a></span>
    @endif
  </h1>
@endif

    
<div class="card-columns">
    @foreach($sticky_threads as $thread)
        <div class="card">
            <a href="{{ route('show.post', array($thread->id, $thread->slug)) }}">
                @if($thread->feature_image != '')
                <img class="card-img-top" src="{{ asset('feature_images/'.$thread->feature_image ) }}" alt="Card image cap">
                @else
                <img class="card-img-top" src="{{ asset('feature_images/default.jpg') }}" alt="Card image cap">
                @endif
        
                <div class="card-body">
                <h4 class="card-title"> {{ $thread->title }} </h4>
                </div>
              </a>
        </div>

        </div>
    @endforeach
</div>



@if($none_sticky_threads_count > 1 )
  <h1 class="mb-5 mt-5">
    <span class="mini_title_box">Featured Article </span>
    @if($none_sticky_threads_count > 6 )
      <span class="float-right"> <a href="#" class="btn btn-success">see all </a></span>
    @endif
  </h1>
@endif

    
    
<div class="card-columns">
    @foreach($none_sticky_threads as $thread)
        <div class="card">
            <a href="{{ route('show.post', array($thread->id, $thread->slug)) }}">
                @if($thread->feature_image != '')
                <img class="card-img-top" src="{{ asset('feature_images/'.$thread->feature_image ) }}" alt="Card image cap">
                @else
                <img class="card-img-top" src="{{ asset('feature_images/default.jpg') }}" alt="Card image cap">
                @endif
              </a>
              <div class="card-body">
                <h4 class="card-title"> {{ $thread->title }} </h4>
              </div>
            
        </div>
    @endforeach
</div>


</div>

@endsection