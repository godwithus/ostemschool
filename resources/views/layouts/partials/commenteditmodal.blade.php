<div class="modal fade" id="edit-{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Your Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('update.comment', $comment->id) }}" method="post" role="form" id="create-comment-form">
            
            {{csrf_field()}}

          <input type="hidden" name="thread_id" value="{{ $thread->id }}">
          <div class="form-group">
            <textarea class="form-control" name="content">{{ $comment->content }}</textarea>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success"> Update </button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>