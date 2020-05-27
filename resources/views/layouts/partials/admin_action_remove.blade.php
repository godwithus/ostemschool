<div class="modal fade" id="admin-action-remove-{{ $admin->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize"> Are You Sure You Want To Remove <b> {{ $admin->user->name }} </b> From Admin ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">

          
        <a href="{{ route('remove.admin', $admin->user_id) }}" class="btn btn-danger"> Yes  </a>

        <button type="submit" class="btn btn-primary" data-dismiss="modal">No</button>


        </div>
        
      </div>
      
    </div>
  </div>
</div>