<?php use App\CreateSite; ?>
@extends('layouts.app')

@section('content')

<div class="container">

    
        <div class="jumbotron jumbotron_edited">
            <div class="text-center">
                <h1 class="display-3 site_name"> 
                    @if($getByDomain != null)
                        Searches From : <b> {{ $getByDomain->name }} </b> 
                    @else
                        Searches From : <b> {{ 'Community Platform' }} </b> 
                    @endif
                </h1>
                @include('layouts.partials.search')
            </div>
        </div>

        <?php if(isset($_GET['search']) && $_GET['search'] != ''){ ?>
            <div class="alert alert-success" role="alert">
                Result Searches For : <b> {{ $_GET['search'] }} </b>
            </div>
        <?php } ?>

        

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

            @if($threads->count() < 1 )
            <div class="card">
                <div class="card-body text-center">
                    <h3> No result found for the keyword searched </h3>
                </div>
            </div>
            @endif
        </div>

        <div class='pagination justify-content-center mt-5'> {{ $threads->links() }} </div>
</div>


@endsection