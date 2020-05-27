<div class="modal fade" id="reply-edit-{{ $reply->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Your Reply</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('reply.update', $reply->id) }}" method="post" role="form" id="create-comment-form">
            
            {{csrf_field()}}

          <input type="hidden" name="comment_id" value="{{ $comment->id }}">
          <div class="form-group">
            <label for="message-text" class="col-form-label">Content</label>
            <textarea class="form-control" name="content">{{ $reply->content }}</textarea>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>