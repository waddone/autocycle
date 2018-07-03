@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPageWhiteCont">
	    <div class="row nopadding">
	        <div class="col-xs-12 NormalPageH1X nopadding">
	            <h1>Contul meu - <?=$user_logat_r->name?></h1>
	        </div>
	    </div>
	   
	    <div class="row nopadding">
	    	<? if($user_logat_r->isAdmin() == true) { ?>
	    	@component('layouts.backend.menu-admin')
	    	@endcomponent
	    	<? } else {?>
	    	@component('layouts.backend.menu-client')
	    	@endcomponent
	    	<? } ?>
	    	
		    <div class="col-xs-12 col-md-10 BlockDrCont">
		        <h3>Contul meu</h3>
		    </div>
		    <div class="col-xs-12 col-md-7">
		        <? if($user_logat_r->isAdmin() == true) { ?>
		    	{{ Auth::user()->hasActiveAds() }}
		    	<? } else {?>
		    		detalii cont client
		    	<? } ?>
		    </div>
	  	</div>
	</div>

@endsection