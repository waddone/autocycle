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
		        <h3>Newsletter view</h3>
                @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif
		    </div>
		    <div class="col-xs-12 col-md-8 col-md-offset-1">
                <form action="{{route('newsletter-send')}}" method="POST">
                    {{ csrf_field() }}
    		      	<table class="emailTemplate">
                        <tr class="text-center">
                            <td class="text-center LogoMail">
                                <img src="{{ url('/') }}/resources/assets/images/logo.png" alt="Autocycle">  
                                <br/>
                                Autocycle.ro | autodezmembrat.ro
                            </td>
                            <td class="text-left titluMail">
                                <label>Titul dorit - subiectul emailul</label>
                                <input type="text" name="titlu" placeholder="Oferte Autocycle.rol" value="Oferte Autocycle.ro" class="form-control">
                            </td>
                            <td class="text-left PrezenareEmail">
                                Buna ziua Nume Prenume,
                            </td>
                            <td class="text-left textMail">
                                <label>Textul dorit si incorporat in email</label>
                                <textarea name="text" placeholder="text-ul pe care vrei sa-l trimiti" class="form-control"></textarea>
                            </td>
                            <td class="text-left FooterLogoMail">
                                <img src="{{ url('/') }}/resources/assets/images/logo_white.png" alt="Autocycle">  
                                <span>@Autocycle.ro | @autodezmembrat.ro - 2018 </span>
                            </td>
                        </tr>
                    </table>
                    <div class="col-xs-12 text-center">
                        <br/> 
                        <input type="submit" value="Trimite Newsletter" class="btn btn-primary2">
                        <br/>    
                    </div>
                </form>
		    </div>
            
            
	  	</div>
	</div>

@endsection