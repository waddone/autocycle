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
		        <h3>newsletter</h3>
		        @if(Session::has('message'))
				<p class="alert alert-info">{{ Session::get('message') }}</p>
				@endif
		    </div>
		    <div class="col-xs-12 col-md-7">
		        <form class="form-horizontal" action="{{route('newsletter-post')}}" method="POST">
                    {{ csrf_field() }}

                    <div class="col-md-12">
			            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			            	<div class="col-md-12">
			                	<label for="name" class="control-label">Nume si prenume <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
			                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Nume si prenume">
			                    @if ($errors->has('name'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('titlu') }}</strong>
			                        </span>
			                    @endif  
		                	</div>
			            </div>
			        </div>

			        <div class="col-md-12">
			            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
			            	<div class="col-md-12">
			                	<label for="email" class="control-label">Email <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
			                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Nume si prenume">
			                    @if ($errors->has('email'))
			                        <span class="help-block">
			                            <strong>{{ $errors->first('titlu') }}</strong>
			                        </span>
			                    @endif  
		                	</div>
			            </div>
			        </div>

			        <div class="col-xs-12 text-center">
                    	<br/> 
                    	<br/> 
                    	<input type="submit" value="Adauga user" class="btn btn-primary2">
                    	<br/> 
                    	<br/> 
                    	<br/> 
                    </div>
                </form>
		    </div>
	  	</div>
	</div>

@endsection