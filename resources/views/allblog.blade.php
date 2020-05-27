<?php use App\CreateSite; ?>
@extends('layouts.main_app')

@section('content')

<div class="container">

    
        <div class="jumbotron jumbotron_edited">
        <div class="text-center">
        <h1 class="display-3 site_name"> 
            @if($getByDomain != null)
                Articles From : <b> {{ $getByDomain->name }} </b> 
            @else
                Articles From : <b> {{ 'Community Platform' }} </b> 
            @endif
            </h1>
        </div>
        </div>

        <div class="card-columns">
            @foreach($threads as $thread)
                <div class="card">
                    <?php
                        $currentDomain = explode('.', $_SERVER['HTTP_HOST']);
                        $checkTheDomain = count($currentDomain);

                        $parentDomain = new CreateSite();
                        $sites = CreateSite::find($thread->site_id);
                    ?>

                        @if($thread->feature_image != '')
                            <a href="http://{{$sites->domain}}.{{$parentDomain->parentDomain() }}/show/{{$thread->id}}/{{$thread->slug}}">
                                <img class="card-img-top" src="{{ asset('feature_images/'.$thread->feature_image ) }}" alt="Card image cap">
                            </a>
                        @else
                            <a href="http://{{$sites->domain}}.{{$parentDomain->parentDomain() }}/show/{{$thread->id}}/{{$thread->slug}}">
                                <img class="card-img-top" src="{{ asset('feature_images/default.jpg') }}" alt="Card image cap">
                            </a>
                        @endif
                        
                        <div class="card-body">
                        <a href="http://{{$sites->domain}}.{{$parentDomain->parentDomain() }}/show/{{$thread->id}}/{{$thread->slug}}" class="post_list_title">
                        <h4 class="card-title"> {{ $thread->title }} </h4>
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

        <div class='pagination justify-content-center mt-5'> {{ $threads->links() }} </div>
</div>


@endsection