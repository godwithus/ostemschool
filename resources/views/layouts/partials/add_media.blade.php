<div class="modal fade" id="addMedia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload New Image </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form method="post" id="upload_form" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="modal-body">
            <div class="alert" id="message" style="display: none"></div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Choose Image</label>
              <input type="file" class="form-control" name="select_file" id="select_file" />               
            </div>

            <span id="uploaded_image" class="text-center"></span>

            <img src="{{ asset('images/loading.gif') }}" style="display: none;" id="uploading"/>

            <input type="hidden" class="form-control" placeholder="Enter ..."  name="site_id" value="{{ $getByDomain->id }}">

            <br>

            <div class="col-lg-12 mt-3" id="copy_text" style="display: none;">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for..." aria-label="Search for..." id="myInput">
                <span class="input-group-btn">
                  <button class="btn btn-secondary" style="border-radius: 0 10px 10px 0" type="button" onclick="myFunction()">Copy Address</button>
                </span>
              </div>
              <div style="color: green; font-weight: bold; text-align: center; display: none;" id="address_copied"> Image Address Copied</div>
            </div>

          </div>
          
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            <input type="submit" style="display: none;" name="upload" id="upload" class="btn btn-primary" value="Upload">
            
          </div>
          
        </form>
        <br />
    
    </div>
  </div>
</div>