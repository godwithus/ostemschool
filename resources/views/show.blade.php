@extends('layouts.app')

@section('content')

<?php 

  use App\BlogAdmin; 
  use App\CreateSite; 
  use \Carbon\Carbon;

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

@include('layouts.partials.deletemodal')
@include('layouts.partials.profile')
@include('layouts.partials.session_report')
@include('layouts.partials.errors')

<div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 inner_post_body mb-5">

@include('layouts.partials.sections_menu')

<h1 class="text-dark font-serif pt-2 mb-4">{{ $thread->title }}</h1> <div class="media py-1"><a href="http://blog.test/blog/Emmanuel" class="router-link-active">


            @if($thread->user->pic != '')
                <img src="{{ asset('profile_images/'.$thread->user->pic) }}" style="border: 1px #cccccc solid; width: 50px; border-radius: 5px;" class="mr-3 shadow-inner" alt="..." >
            @else
                <img src="{{ asset('profile_images/default.png') }}"  style="border: 1px #cccccc solid; width: 50px; border-radius: 5px;" class="mr-3 shadow-inner" alt="...">
            @endif

</a> <div class="media-body">
<span class="text-decoration-none router-link-active change_cursor"  data-toggle="modal" data-target="#show-profile"> <b> {{ $thread->user->name}} </b> </span>


@if(Auth::check() == $thread->user_id)
  @if((Auth::user()->id == $thread->user_id) && ($creator > 0 ) )
    <a href="{{ route('edit.post', $thread->id) }}" class="btn btn-primary btn-sm"> edit post</a>
    <span class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-thread"> delete post</span>
  
  @elseif($getByDomain->user_id == Auth::user()->id)
    <a href="{{ route('edit.post', $thread->id) }}" class="btn btn-primary btn-sm"> edit post</a>
    <span class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-thread"> delete post</span>
  
  @endif
@endif

<br>
<span class="text-secondary">
  @if(now()->diffInDays($thread->created_at) > 0)
    <b> Posted: {{ now()->diffInDays($thread->created_at) }} Days Ago </b>
  @else
    <b> Posted: Today </b>
  @endif
</span></div></div> 

<div class="post-content position-relative align-items-center overflow-y-visible font-serif mt-4 body_font_size">
    {!! $thread->content !!}
</div> 

</div>



<div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 inner_post_body">
    @if(auth()->check())
      <div class="col-12 mt-4">
          <form action="{{ route('store.comment') }}" method="post" role="form" id="create-thread-form">
            {{csrf_field()}}

            <div class="form-group">
              <input type="hidden" name="thread_id" value="{{ $thread->id }}">
              <label for="message-text" class="col-form-label" style="font-weight: bold">Give A Comment</label>
              <textarea class="form-control" name="content"></textarea>
              <button type="submit" class="btn btn-primary btn-sm mt-2 btn-block" style="float: right;">Submit</button>
            </div>        
          </form>
      </div>
    @else
      <div class="row justify-content-md-center">
        <div class="col-md-7 alert alert-info  mt-4" style="border-radius: 10px;">
          <h5 class="text-center"><a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">Register </a> to Submit a comment</h5>
        </div>
      </div>

    @endif

    <br><br>

    @if($comments->count() > 0)
      <h3 class="ml-3"> <a id="comment"> People's Comment </a></h3>

    @else
      <h4 class="ml-3"> <a id="comment"> No Comment Giving Yet </a></h4>
    @endif

      <div class="card-footer card-comments mt-3">
        
      
          <div class="card-comment articles">
            @include('comments')
          </div>


      </div>

    </div>

</div>
@endsection

@section('script_holder')

<script type="text/javascript">

  $(function() {
      $('body').on('click', '.pagination a', function(e) {
          e.preventDefault();

          $('#load a').css('color', '#dfecf6');
          $('#load').append('<img style="position: absolute; left: 50%; top: 50%; z-index: 100000; background-color: green;" src="/images/loading.gif" />');

          var url = $(this).attr('href');  
          getArticles(url);
          window.history.pushState("", "", url);
      });

      function getArticles(url) {
          $.ajax({
              url : url  
          }).done(function (data) {
              $('.articles').html(data);  
          }).fail(function () {
              alert('Articles could not be loaded.');
          });
      }
  });

</script>

@endsection