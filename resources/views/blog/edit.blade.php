@extends('layouts.app')

@section('content')

<?php use App\CreateSite; ?>

<h1 class="text-center"> Edit Post : <b> {{ $thread->title }} </b></h1>

<div class="row justify-content-center">
<div class="col-md-8">


    @include('layouts.partials.session_report')
    @include('layouts.partials.errors')
    @include('layouts.partials.add_media')

    @include('layouts.partials.admin_menu')
    @include('layouts.partials.session_report')
    @include('layouts.partials.uploaded_images')

      <div class="card">
          <div class="card-body">


      <form action="{{ route('update.post', $thread->id) }}" method="post" role="form" id="create-thread-form" enctype="multipart/form-data">

        {{csrf_field()}}
        <div class="row">
          <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
              <label>Title</label>
              <input type="text" class="form-control" placeholder="Enter ..."  name="title" value="{{ $thread->title }}">
            </div>
          </div>
        </div>

        <?php
           $domain = new CreateSite();
           $getByDomain = $domain->getUrl();
        ?>

        <input type="hidden" class="form-control" placeholder="Enter ..."  name="site_id" 
        value="{{ $getByDomain->id }}">

        
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMedia"> Add Image</button>
        <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#showImages"> Choose Image</button>

        <div class="row">
          <div class="col-sm-12">
            <!-- textarea -->
            <div class="form-group">
              <label> Content </label>
              <textarea class="form-control my-editor" rows="3" placeholder="Enter ..." name="content">{{ $thread->content }}</textarea>
            </div>
          </div>
        </div>

        
        <div class="form-group">
          <label for="exampleFormControlSelect2"> Select Article Section </label>
          <select class="form-control" name="department">
            <option> Choose a Department  </option>
            @foreach($dept as $eachDept)
              <option value="{{ $eachDept->id }}" <?php if($eachDept->id == $thread->department){ echo "selected='selected'";} ?> > {{ $eachDept->name }} </option>
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
            @if($thread->stick_post == 'yes')
              <input type="checkbox" name="stick_post" checked="checked">
            @else
              <input type="checkbox" name="stick_post">
            @endif
            <span class="checkmark_new"></span>
          </label>
          </div>
        </div>


        <button type="submit" class="btn btn-info float-right"> Update </button>

       </form>
            </div>
          </div>
        </div>
      </div>

@endsection

@section('script_holder')
  @include('layouts.partials.extra_added_script')
@endsection