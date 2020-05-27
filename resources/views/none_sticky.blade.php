<?php use App\CreateSite; ?>
<?php
    $currentDomain = explode('.', $_SERVER['HTTP_HOST']);
    $checkTheDomain = count($currentDomain);
?>

@extends('layouts.app')


@section('content')

<div class="container">

    
        <div class="jumbotron jumbotron_edited">
        <div class="text-center">
        <h1 class="display-3 site_name"> 
                Popular Articles From : <b> {{ $getByDomain->name }} </b> 
            </h1>
        </div>
        </div>

        <div class="card-columns">
            @foreach($none_sticky_threads as $thread)
                <div class="card">
                    
                        @if($thread->feature_image != '')
                            <a href="{{ route('show.post', array($thread->id, $thread->slug)) }}">
                                <img class="card-img-top" src="{{ asset('feature_images/'.$thread->feature_image ) }}" alt="Card image cap">
                            </a>
                        @else
                            <a href="{{ route('show.post', array($thread->id, $thread->slug)) }}">
                                <img class="card-img-top" src="{{ asset('feature_images/default.jpg') }}" alt="Card image cap">
                            </a>
                        @endif
                        
                        <div class="card-body">
                        <a href="{{ route('show.post', array($thread->id, $thread->slug)) }}" class="post_list_title">
                        <h4 class="card-title"> {{ $thread->title }} </h4>
                        </a>
                    
                    </div>

                </div>
            @endforeach
        </div>
    <div class="text-center mt-5"> {{ $none_sticky_threads->links() }} </div>
</div>


@endsection