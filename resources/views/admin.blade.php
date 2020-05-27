@extends('layouts.app')

@section('content')

@include('layouts.partials.errors')

<style>
    .thread{
        background-color: #cccccc;
        padding: 10px;
        border-left: 5px solid #333333;
    }

    .thread a{
        color: #333333;
        text-transform: capitalize;
    }

    .thread a:hover{
        text-decoration: underline;
    }
</style>
<div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 inner_post_body mb-3">
    
    @include('layouts.partials.admin_menu')
    @include('layouts.partials.session_report')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="text-center"> Search User to Make Admin </h3>
                    <div class="input-group">
                        <input type="email" name="search" id="search" class="form-control" placeholder=" Search By Email" aria-label="Product name">
                    </div>
                    <div class="text-center"> Making any one an Admin will give them access to create, update and delete the article on your site</div>
                    <div id="tbody">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card">
    @if($getAdmin->count() > 0)
    <h1 class="text-center mt-2"> Selected Admins </h1>
        <div class="card-body">
            <div class="row">
            
                @foreach($getAdmin as $admin)
                    @include('layouts.partials.admin_action_remove')
                    <div class="col-lg-12 mb-2">
                        <div class="card-footer">
                            <b><a href="">{{ $admin->user->name }}</a></b> &nbsp;  &nbsp;  &nbsp; 
                            <i> {{ $admin->user->email }} </i> 
                            <span class="float-right">
                                <button class="btn btn-danger btn-small" data-toggle="modal" data-target="#admin-action-remove-{{ $admin->id }}"> Remove From Admin </button>
                            </span>
                        </div>
                    </div>
                @endforeach
           

            </div>
        </div> 
        @else
            <div class="card-footer text-center"> No Admin Selected Yet </div>
        @endif
    </div>

</div>

    <script>
        $(document).ready(function(){
            fetch_customer_data();
            function fetch_customer_data(query = '')
            {
                $.ajax({
                    url:"{{ route('live_search.action') }}",
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function(){
                var query = $(this).val();
                fetch_customer_data(query);
            });
        });
    </script>
@endsection