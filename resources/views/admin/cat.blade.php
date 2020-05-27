@extends('layouts.main_app')

@section('content')

<div class="row justify-content-center">
        <div class="col-md-8">
            @include('layouts.partials.session_report')
            @include('layouts.partials.errors')


            <div class="card">

              <form action="{{ route('cstore') }}" method="post" role="form" id="create-thread-form" class="card-body">
                {{csrf_field()}}

                <div class="form-group mb-3">
                  <input type="text" class="form-control" value="{{ old('cat') }}" placeholder="Category Name" name="name">
                </div>        
                
                <button type="submit" class="btn btn-primary btn-sm mt-2 btn-block" style="float: right;">Submit Category</button>
              </form>
            </div>
        </div>
      </div>

@endsection