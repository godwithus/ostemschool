<div class="modal fade" id="admin-action" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Add Opperation To Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">

          <a href="{{ route('make.admin', $userEmail->id) }}" class="btn btn-primary btn-block">Make Admin</a>

        </div>
        
      </div>
      
    </div>
  </div>
</div>