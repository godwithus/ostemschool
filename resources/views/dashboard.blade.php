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

@include('layouts.partials.errors')

<style>
    .thread{
        background-color: #cccccc;
        padding: 10px;
        border-left: 5px solid #333333;
    }

    .thread a{
        color: #333333;
        text-transform: capitalize;
    }

    .thread a:hover{
        text-decoration: underline;
    }
</style>
<div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 inner_post_body">

    @include('layouts.partials.admin_menu')


    <div class="card">
        <div class="card-body">
            
            @if($threads->count() > 0)
                @foreach($threads as $thread)
                    <!-- <div class="card-body"> -->
                        @include('layouts.partials.deletemodal')
                        <div class="thread mb-2"> 
                            <a href="{{ route('show.post', array( $thread->id, $thread->slug)) }}"> {{ $thread->title }} </a> 

                            @if((Auth::user()->id == $thread->user_id) && ($creator > 0 ) )

                                <span class="float-right">
                                    <a href="{{ route('edit.post', $thread->id) }}"> 
                                        <img src="{{ asset('images/pen.png') }}" style="width: 10px; height: 10px;">
                                    </a>
                                    <img src="{{ asset('images/times.png') }}" class="ml-3" style="width: 10px; height: 10px; cursor: pointer;" data-toggle="modal" data-target="#delete-thread">
                                </span>

                            @elseif($getByDomain->user_id == Auth::user()->id)

                                <span class="float-right">
                                    <a href="{{ route('edit.post', $thread->id) }}"> 
                                        <img src="{{ asset('images/pen.png') }}" style="width: 10px; height: 10px;">
                                    </a>
                                    <img src="{{ asset('images/times.png') }}" class="ml-3" style="width: 10px; height: 10px; cursor: pointer;" data-toggle="modal" data-target="#delete-thread">
                                </span>

                            @endif


                        </div>
                    <!-- </div> -->
                @endforeach
            
            @else
                <div class="card-footer text-center"> No Post Created Yet <a href="{{ route('create.post') }}"> Create Article</a></div>
            @endif
        </div>
    </div>
</div>
@endsection