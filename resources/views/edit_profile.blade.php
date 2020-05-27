@extends('layouts.main_app')

@section('content')

@include('layouts.partials.errors')

<div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 inner_post_body mb-5 container_bg py-4">

    @include('layouts.partials.session_report')

    <div class="text-center">
        @if($user->pic != '')
            <img src="{{ asset('profile_images/'.$user->pic) }}"  style="width: 200px;" class="rounded img-thumbnail" alt="..." >
        @else
            <img src="{{ asset('profile_images/default.png') }}" style="width: 200px;" class="rounded img-thumbnail" alt="...">
        @endif
        <h1 class="display-3 site_name">{{ $user->name }}</h1>
    </div> 

    @if(Auth::check() == $user->id)

        @if(Auth::user()->id == $user->id)

            <br><br>
            <form method="POST" action="{{ route('update.user') }}"  enctype="multipart/form-data">

                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Profile Picture') }}</label>

                    <div class="col-md-6">
                        <input id="pic" type="file" class="form-control @error('pic') is-invalid @enderror" name="pic">

                        @error('pic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <hr/>                    
                <hr/>   

                <div class="form-group row">
                    <label for="old_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                    <div class="col-md-6">
                        <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" value="Current Password" >

                        @error('old_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                
                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>


                
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-success">
                            {{ __('Update Profile') }}
                        </button>
                    </div>
                </div>
            </form>
        @endif
    @endif
</div>
@endsection