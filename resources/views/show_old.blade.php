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

<div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 inner_post_body mb-5">

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
  <b> Posted: {{ now()->diffInDays($thread->created_at) }} Days Ago </b>
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
        
        @foreach($comments as $comment)

            @include('layouts.partials.comment_profile')
            @include('layouts.partials.commenteditmodal')
            @include('layouts.partials.commentdeletemodal')

          <div class="card-comment">
            <!-- User image -->
            @if($comment->user->pic != '')
                <img src="{{ asset('profile_images/'.$comment->user->pic) }}" style="border: 1px #cccccc solid; border-radius: 5px;" class="img-sm" alt="..." >
            @else
                <img src="{{ asset('profile_images/default.png') }}"  style="border: 1px #cccccc solid; border-radius: 5px;" class="img-sm" alt="...">
            @endif

            <div class="comment-text">
              <span class="username">

                <span class="c-black change_cursor" n data-toggle="modal" data-target="#show-profile-{{ $comment->user_id }}"> 
                  {{ $comment->user->name }}
                </span>

                @if(auth()->check())
                  @if(auth()->user()->id == $comment->user_id)
                    
                  <span style="float: right;"data-toggle="modal" data-target="#delete-{{ $comment->id }}">
                    <img src="{{ asset('images/times.png') }}" class="ml-3" style="width: 10px; height: 10px;">
                  </span>

                  <span style="float: right; margin-left: 10px;" data-toggle="modal" data-target="#edit-{{ $comment->id }}" class="ml-3">
                    <img src="{{ asset('images/pen.png') }}" style="width: 10px; height: 10px;">
                  </span>

                  @endif
                @endif

              </span><!-- /.username -->
                {{ $comment->content }} 
              <br>
              <span class="text-muted float-right ml-3">
                  @if(now()->diffInDays($comment->created_at) > 1)
                    Posted <b> {{ now()->diffInDays($comment->created_at) }} Days Ago </b>
                  @else
                    Posted <b> Today </b>
                  @endif
              </span> 
            </div>
            <!-- /.comment-text -->
          </div>
        @endforeach

        {{ $comments->links() }}

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
          $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

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