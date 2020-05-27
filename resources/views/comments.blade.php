<?php use App\Comment; ?>

<div id="load" style="position: relative;">
@foreach($comments as $comment)

  @include('layouts.partials.commenteditmodal')
  @include('layouts.partials.commentdeletemodal')
  @include('layouts.partials.commentdeletemodal')
  @include('layouts.partials.commentreplymodal')

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
          
        <span style="float: right;" data-toggle="modal" data-target="#delete-{{ $comment->id }}">
          <img src="{{ asset('images/times.png') }}" class="ml-3" style="width: 10px; height: 10px;">
        </span>

        <span style="float: right; margin-left: 10px;" data-toggle="modal" data-target="#edit-{{ $comment->id }}" class="ml-3">
          <img src="{{ asset('images/pen.png') }}" style="width: 10px; height: 10px;">
        </span>

        @endif
      @endif

    </span><!-- /.username -->

      <!-- Checking if this a reply Comment -->
      <?php
        if($comment->reply_to != 0){
            $reply = Comment::find($comment->reply_to);
            $name = $reply->user->name;

            echo "<div class='card card-footer mt-3'> 
                     <div class='mb-2'>Comment by<b><i> $name </i></b></div>
                    $reply->content 
                  </div>";
        }
      ?>

      {{ $comment->content }} 

    <br>
    <div class="mt-4"> 
      <span class="text-muted float-right ml-3">
          @if(now()->diffInDays($comment->created_at) > 1)
            Posted <b> {{ now()->diffInDays($comment->created_at) }} Days Ago </b>
          @else
            Posted <b> Today </b>
          @endif
      </span> 
      <span class="btn btn-sm btn-success"  data-toggle="modal" data-target="#reply-{{$comment->id}}">
        Reply
      </span>
    </div>
  </div>
  <!-- /.comment-text -->
  </div>
@endforeach

{{ $comments->links() }}
</div>
