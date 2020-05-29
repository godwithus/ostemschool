@extends('layouts.app')

@section('content')

<?php use App\CreateSite; ?>
      @include('layouts.partials.errors')

      <h1 class="text-center"> Create a New Post</h1>

      <div class="row justify-content-center">
      <div class="col-md-8">
    
      @include('layouts.partials.admin_menu')
    @include('layouts.partials.session_report')

            <div class="card">
                <div class="card-body">
                <form action="{{ route('store.post') }}" method="post" role="form" id="create-thread-form" enctype="multipart/form-data">

                  {{csrf_field()}}
                  <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control"  value="{{ old('title') }}"  placeholder="Enter ..."  name="title">
                      </div>
                    </div>
                  </div>

                  <?php
                    $domain = new CreateSite();
                    $getByDomain = $domain->getUrl();
                  ?>

                  <input type="hidden" class="form-control" placeholder="Enter ..."  name="site_id" 
                  value="{{ $getByDomain->id }}">

                  <div class="row">
                    <div class="col-sm-12">
                      <!-- textarea -->
                      <div class="form-group">
                        <label> Content </label>
                        <textarea class="form-control my-editor" rows="3" placeholder="Enter ..." name="content">{{ old('content') }}</textarea>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleFormControlSelect2"> Select Article Section </label>
                    <select class="form-control" name="department">
                      <option> Choose a Department  </option>
                      @foreach($dept as $eachDept)
                        <option value="{{ $eachDept->id }}"> {{ $eachDept->name }} </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <!-- textarea -->
                      <div class="form-group">
                        <label> Feature Image </label>
                        <input type="file" class="form-control" placeholder="Select Feature Image ..."  name="feature">
                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-sm-12 mt-4">
                    <label class="container_new">
                      Stick Post on Index Page
                      <input type="checkbox" name="stick_post" value="yes">
                      <span class="checkmark_new"></span>
                    </label>
                    </div>
                  </div>



                  <button type="submit" class="btn btn-info float-right"> Submit </button>

              </form>
            </div>
          </div>
        </div>
      </div>



@endsection


@section('script_holder')
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>
    var editor_config = {
      path_absolute : "/",
      selector: "textarea.my-editor",
      image_dimensions: false,
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
      relative_urls: false,
      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
          cmsURL = cmsURL + "&type=Images";
        } else {
          cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizable : "yes",
          close_previous : "no"
        });
      }
    };

    tinymce.init(editor_config);
  </script>

@endsection