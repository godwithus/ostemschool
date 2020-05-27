<div class="modal fade" id="reply-{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reply to Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="{{ route('store.comment') }}" method="post" role="form" id="create-thread-form">
            {{csrf_field()}}

            <div class="form-group">
              <input type="hidden" name="thread_id" value="{{ $thread->id }}">
              <input type="hidden" name="reply_to" value="{{ $comment->id }}">
              <textarea class="form-control" name="content" placeholder="Type in your reply"></textarea>
              <button type="submit" class="btn btn-primary btn-sm mt-2 btn-block" style="float: right;">Submit</button>
            </div>        
          </form>
          
      </div>
    </div>
  </div>
</div>