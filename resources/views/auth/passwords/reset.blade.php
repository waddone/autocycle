@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPageWhiteCont">
        <div class="row nopadding">
            <div class="col-xs-12 NormalPageH1X nopadding">
                <h1>Contul meu</h1>
            </div>
        </div>
       
        <div class="row nopadding">
            @component('layouts.backend.menu-admin')
            @endcomponent
            <div class="col-xs-12 col-md-10 BlockDrCont">
                <h3>Reseteaza parola</h3>
                @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif

                <!-- Display Validation Errors -->
                @include('common.errors')
            </div>
            <div class="col-xs-12 col-md-7">
                <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">
                        <br/>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br/>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>

@endsection
