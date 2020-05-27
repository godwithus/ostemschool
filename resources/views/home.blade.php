<?php 
  use App\CreateSite; 
  use App\BlogAdmin;
  
   // We want to get the Domain of the Current Domain the Use is ON
    // We want to get the Domain of the Current Domain the Use is ON
    $domain = new CreateSite();
    $getByDomain = $domain->getUrl();
    $creator = '';
    // We want to know if such Domain exist at all in our Database
    if (Auth::check() && $getByDomain != null) {
       $creator = BlogAdmin::where('user_id', auth()->user()->id)
                 ->where('site_id', $getByDomain->id)
                 ->count();
    }
?>

@extends('layouts.app')

@section('content')

<div class="container">


<div class="jumbotron jumbotron_edited">
  @include('layouts.partials.errors')
  @include('layouts.partials.session_report')

  <div class="text-center">
  @if($getByDomain->logo != '')
    <img src="{{ asset('sites_logo/'.$getByDomain->logo) }}" class="rounded img-thumbnail" alt="...">
  @else
    <img src="{{ asset('sites_logo/default.png') }}" class="rounded img-thumbnail" alt="...">
  @endif
  <h1 class="display-3 site_name">{{ $getByDomain->name }}</h1>
  <p class="lead"> {{ $getByDomain->description }}  
    
    
  @if(Auth::check() && $getByDomain->user_id == Auth::user()->id)
    @include('layouts.partials.edit_site_details')
    <br>
    <button class="btn btn-success btn-sm"  data-toggle="modal" data-target="#editSite" >edit</button> 
    <a href="{{ route('create.post') }}" class="btn btn-secondary">Create New Article</a>

  @elseif(Auth::check() && $creator > 0)

    <br> <a href="{{ route('create.post') }}" class="btn btn-secondary">Create New Article</a>

  @elseif(!Auth::check())

    <br> <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>

  @endif
    

  </p>
  </div>
</div>

</div>


@if($sticky_threads_count > 0 )
  <h1 class="mb-5 mt-5">
    <span class="mini_title_box">Featured Article </span>
    @if($sticky_threads_count > 6 )
      <span class="float-right"> <a href="{{ route('sticky.post.list') }}" class="btn btn-success">see all </a></span>
    @endif
  </h1>
@endif

    
<div class="card-columns">
    @foreach($sticky_threads as $thread)
        <div class="card">
        <a href="{{ route('show.post', array($thread->id, $thread->slug)) }}" class="post_list_title">
            
            @if($thread->feature_image != '')
            <img class="card-img-top" src="{{ asset('feature_images/'.$thread->feature_image ) }}" alt="Card image cap">
            @else
            <img class="card-img-top" src="{{ asset('feature_images/default.jpg') }}" alt="Card image cap">
            @endif
            </a>

            <div class="card-body">
            <a href="{{ route('show.post', array($thread->id, $thread->slug)) }}" class="post_list_title">
            <h4 class="card-title"> {{ $thread->title }} </h4>
            </a>
            </div>

        </div>
      @endforeach
</div>


@if($none_sticky_threads_count > 0 )
  <h1 class="mb-5 mt-5">
    <span class="mini_title_box">Popular Article </span>
    @if($none_sticky_threads_count > 6 ) 
      <span class="float-right"> <a href="{{ route('none.sticky.post.list') }}" class="btn btn-success">see all </a></span>
    @endif
  </h1>
@endif

    
    
<div class="card-columns">
    @foreach($none_sticky_threads as $thread)
        <div class="card">
          <a href="{{ route('show.post', array($thread->id, $thread->slug)) }}" class="post_list_title"> 
            
            @if($thread->feature_image != '')
            <img class="card-img-top" src="{{ asset('feature_images/'.$thread->feature_image ) }}" alt="Card image cap">
            @else
            <img class="card-img-top" src="{{ asset('feature_images/default.jpg') }}" alt="Card image cap">
            @endif
          </a>
            <div class="card-body">
            <a href="{{ route('show.post', array($thread->id, $thread->slug)) }}" class="post_list_title"> 
            <h4 class="card-title"> {{ $thread->title }} </h4>
            </a>
            </div>

        </div>
    @endforeach
</div>


</div>

@endsection