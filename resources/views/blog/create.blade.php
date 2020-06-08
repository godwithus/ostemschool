@extends('layouts.app')

@section('content')

<?php use App\CreateSite;
  $domain = new CreateSite();
  $getByDomain = $domain->getUrl();
?>

      @include('layouts.partials.create_style')

      @include('layouts.partials.errors')
      @include('layouts.partials.add_media')

   

      <h1 class="text-center"> Create a New Post</h1>

      <div class="row justify-content-center">
      <div class="col-md-8">


      @include('layouts.partials.admin_menu')
      @include('layouts.partials.session_report')
      @include('layouts.partials.uploaded_images')

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

                  <input type="hidden" class="form-control" placeholder="Enter ..."  name="site_id" 
                  value="{{ $getByDomain->id }}">

                  <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMedia"> Add Image</button>
                  
                  <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#showImages"> Choose Image</button>


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
  @include('layouts.partials.extra_added_script')
@endsection