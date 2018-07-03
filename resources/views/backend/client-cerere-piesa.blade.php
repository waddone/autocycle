@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPageWhiteCont">
	    <div class="row nopadding">
	        <div class="col-xs-12 NormalPageH1X nopadding">
	            <h1>Contul meu</h1>
	        </div>
	    </div>
	   
	    <div class="row nopadding">
	    	@component('layouts.backend.menu-client')
	    	@endcomponent
		    <div class="col-xs-12 col-md-10 BlockDrCont">
		        <h3>Cerere piesa</h3>
		        @if(Session::has('message'))
				<p class="alert alert-info">{{ Session::get('message') }}</p>
				@endif

				<!-- Display Validation Errors -->
                @include('common.errors')
		    </div>
		    <div class="col-xs-12 col-md-8">
		        <form class="form-horizontal" method="POST" action="{{ route('trimite-cerere-post') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('marca') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="marca" class="control-label">Alege marca <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                <select id="marca" name="marca" class="form-control">
                                    <option value="">Alege marca</option>
                                    <? foreach ($marci_c as $marci_r) { 
                                        $selected = '';
                                        if(old('marca') != '') {
                                            if(old('marca') == strtolower($marci_r->marca)) {
                                                $selected = 'selected';
                                            }
                                        }  
                                    ?>
                                        <option value="<?=$marci_r->marca?>" <?=$selected?> required autofocus><?=$marci_r->marca?></option>
                                    <? } ?>
                                </select>
                                @if ($errors->has('marca'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('marca') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="model" class="control-label">Alege model <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                <select id="model" name="model" class="form-control">
                                    <option value="">Alege modelul</option>
                                </select>
                                @if ($errors->has('model'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('model') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('descriere') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="descriere" class="control-label">Piese dorite <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                <textarea name="descriere" class="form-control" placeholder="Introdu piesele de care ai nevoie rand pe rand" style="height: 120px;"></textarea>
                                @if ($errors->has('descriere'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descriere') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('an') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="an" class="control-label">Anul de fabricatie <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                <select id="an" name="an" class="form-control">
                                    <option value="">Selecteaza anul</option>
                                <? for($i=1980;$i<='2018';$i++) { ?> 
                                    <option value="<?=$i?>"><?=$i?></option>
                                <? } ?>
                                </select>
                                @if ($errors->has('an'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('an') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('an') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="carburant" class="control-label">Carburant <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                <select id="carburant" name="carburant" class="form-control">
                                    <option value="">Selecteaza carburant</option>
                                    <option value="benzina">benzina</option>
                                    <option value="benzina + gpl">benzina + gpl</option>
                                    <option value="motorina">motorina </option>
                                    <option value="motorina + gpl">motorina + gpl</option>
                                    <option value="gpl">gpl</option>
                                    <option value="alternativ">alternativ</option>
                                </select>
                                @if ($errors->has('carburant'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('carburant') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                    	<br/> 
		        		<label>Imagine piesa</label> <br> <div class="fileUpload2 col-xs-8 text-center"> 
		        			<div class="attach_pdf_icon"> 
		        				<i class="fas fa-image"></i> 
		        				<span class="black_img">Adauga imagine piesa</span> 
		        			</div> 
		        			<input type="file" name="image1" id="image1" class="upload"> 
		        		</div> 
		        		<div class="img_uploaded col-xs-4" id="mod_img_src1"></div> 
		        	</div>
                    <div class="col-md-12 delimiterRed">
                        <br/>
                        DETALII DESPRE TINE
                        <span> intrudu datele tale pentru a te putea contact cat mai repede in legatura cu piesa, piesele dorite </span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('nume') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="nume" class="control-label">Nume si prenume <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                <input type="text" name="nume" value="<?=$user_logat_r->name?>" placeholder="Nume si prenume" class="form-control">
                                @if ($errors->has('nume'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nume') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('telefon') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="telefon" class="control-label">Telefon <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                <input type="text" name="telefon" value="" placeholder="telefon" class="form-control">
                                @if ($errors->has('telefon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <br/> 
                        <br/> 
                        <input type="submit" value="Trimite cerere" class="btn btn-primary2">
                        <br/> 
                        <br/> 
                        <br/> 
                    </div>

                </form>
                <script>
                    $(document).ready(function() {
                        $('#marca').select2();
                        $('#model').select2();
                        $('#an').select2();
                        $('#carburant').select2();
                        var marca       = $('#marca').val();
                        $.get('<?=url('/')?>/ajax/get-model/'+marca, function(data) {
                            $("#model option").remove();
                            $.each(JSON.parse(data), function(i, value) {
                                $('#model').append($('<option>').text(value.model).attr('value', value.model));
                            });
                        });
                        $('#marca').change(function() {
                            var marca       = $('#marca').val();
                            $.get('<?=url('/')?>/ajax/get-model/'+marca, function(data) {
                              $("#model option").remove();
                              $.each(JSON.parse(data), function(i, value) {
                                $('#model').append($('<option>').text(value.model).attr('value', value.model));
                                });
                            });
                        });
                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader    = new FileReader();
                                var InputName = input['name'];
                                var nrOfFile  = InputName.replace('image', '');
                                reader.onload = function (e) {
                                    $('#showImg'+nrOfFile).css('background-image', 'url(' + e.target.result + ')');
                                    $('#mod_img_src'+nrOfFile).css('background-image', 'url(' + e.target.result + ')');
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                        $("#image1").change(
                        function(){
                            readURL(this);
                        });
                    });
                </script>
		    </div>
	  	</div>
	</div>

@endsection