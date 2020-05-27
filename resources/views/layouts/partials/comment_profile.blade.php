<div class="modal fade" id="show-profile-{{ $comment->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
            
            @if($comment->user->pic != '')
                <img src="{{ asset('profile_images/'.$comment->user->pic) }}" class="mr-3 shadow-inner" alt="{{ $comment->user->name }}" >
            @else
                <img src="{{ asset('profile_images/default.png') }}" class="mr-3 shadow-inner" alt="{{ $comment->user->name }}" style="width: 200px">
            @endif

            <h1 class="display-3 site_name">{{ $comment->user->name }}</h1>

        
        @if(Auth::check() == $comment->user_id)
            @if(Auth::user()->id == $comment->user_id)
                <a href="{{ route('profile', $comment->user_id) }}" class="btn btn-success"> Edit Profile </a>
            @endif
        @endif

        </div> 

      </div>
    </div>
  </div>
</div>