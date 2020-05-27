<div class="modal fade" id="delete-{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Are You Sure You Want To Delete This Comment ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center>

          <a href="{{ route('comment.destroy', $comment->id) }}" class="btn btn-danger">Yes</a>

          <button type="submit" class="btn btn-primary" data-dismiss="modal">No</button>

        </center>
        
      </div>
      
    </div>
  </div>
</div>