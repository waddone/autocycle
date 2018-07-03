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
		        <h3>Anunturi generate pentru <?=$set_anunturi_r->marca?> <?=$set_anunturi_r->model?> <?=$set_anunturi_r->an?></h3>
                @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif

                <!-- Display Validation Errors -->
                @include('common.errors')
		    </div>
		    <div class="col-xs-12 col-md-10">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:red">Modifica anuntul general <?=$set_anunturi_r->marca?> <?=$set_anunturi_r->model?> <?=$set_anunturi_r->an?></a></h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                              <div class="panel-body">
                                    <form class="form-horizontal" method="POST" action="{{ route('adauga-generator') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="anunt_existent_id" value="<?=$set_anunturi_r->id?>">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('marca') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <label for="marca" class="control-label">Alege model <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                                <select id="marca" name="marca" class="form-control">
                                                    <option value="">Alege marca</option>
                                                    <? foreach ($marci_c as $marci_r) { ?>
                                                        <option value="<?=$marci_r->marca?>" <?=$set_anunturi_r->marca == $marci_r->marca ? 'selected':''?> required autofocus><?=$marci_r->marca?></option>
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
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <label for="model" class="control-label">Alege marca <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
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
                                                <label for="descriere" class="control-label">Descriere anunt <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                                <textarea name="descriere" class="form-control" placeholder="Introdu o descriere a anuntului" style="height: 120px;"><?=$set_anunturi_r->descriere?></textarea>
                                                @if ($errors->has('descriere'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('descriere') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('an') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <label for="an" class="control-label">Anul de fabricatie <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                                <select id="an" name="an" class="form-control">
                                                    <option value="">Selecteaza anul</option>
                                                <? for($i=1980;$i<='2018';$i++) { ?> 
                                                    <option value="<?=$i?>" <?=$set_anunturi_r->an == $i ? 'selected':''?>><?=$i?></option>
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
                                    <div class="col-md-12 delimiterRed">
                                        <br/>
                                        DETALII SUPLIMENTARE 
                                        <span> introducerea pozelor cat mai relevantate, va ofera o expunere mai buna fata de client.<br> Anunturile ce contin video sunt mult mai de interes pentru client. </span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('capacitate_cilindrica') ? ' has-error' : '' }}">
                                            <div class="col-md-6">
                                                <label for="capacitate_cilindrica" class="control-label">Capacitate cilindrica</label>
                                                <input type="text" name="capacitate_cilindrica" id="capacitate_cilindrica" class="form-control" value="<?=$set_anunturi_r->capacitate_cilindrica?>">
                                                @if ($errors->has('capacitate_cilindrica'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('capacitate_cilindrica') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="carburant" class="control-label">Carburant</label>
                                                <select id="carburant" name="carburant" class="form-control">
                                                    <option value="">Selecteaza carburant</option>
                                                    <option value="benzina" <?=$set_anunturi_r->carburant == 'benzina' ? 'selected' : '' ?>>benzina</option>
                                                    <option value="benzina + gpl" <?=$set_anunturi_r->carburant == 'benzina' ? 'selected' : '' ?>>benzina + gpl</option>
                                                    <option value="motorina" <?=$set_anunturi_r->carburant == 'motorina' ? 'selected' : '' ?>>motorina </option>
                                                    <option value="motorina + gpl" <?=$set_anunturi_r->carburant == 'motorina + gpl' ? 'selected' : '' ?>>motorina + gpl</option>
                                                    <option value="gpl" <?=$set_anunturi_r->carburant == 'gpl' ? 'selected' : '' ?>>gpl</option>
                                                    <option value="alternativ" <?=$set_anunturi_r->carburant == 'alternativ' ? 'selected' : '' ?>>alternativ</option>
                                                </select>
                                                @if ($errors->has('carburant'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('carburant') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('kilowati') ? ' has-error' : '' }}">
                                            <div class="col-md-6">
                                                <label for="kilowati" class="control-label">Kilowaţi (kW)</label>
                                                <input type="text" name="kilowati" id="kilowati" class="form-control" value="<?=$set_anunturi_r->kilowati?>">
                                                @if ($errors->has('kilowati'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('kilowati') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="cutie_viteze" class="control-label">Cutie viteze</label>
                                                <select id="cutie_viteze" name="cutie_viteze" class="form-control">
                                                    <option value="">Selecteaza cutie viteze</option>
                                                    <option value="manuala" <?=$set_anunturi_r->cutie_viteze == 'manuala' ? 'selected' : '' ?>>manuala</option>
                                                    <option value="automata" <?=$set_anunturi_r->cutie_viteze == 'automata' ? 'selected' : '' ?>>automata</option>
                                                    
                                                </select>
                                                @if ($errors->has('cutie_viteze'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('cutie_viteze') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('serie_sasiu') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <label for="serie_sasiu" class="control-label">Serie sasiu</label>
                                                <input type="text" name="serie_sasiu" id="serie_sasiu" class="form-control" value="<?=$set_anunturi_r->serie_sasiu?>">
                                                @if ($errors->has('serie_sasiu'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('serie_sasiu') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12"> 
                                        <label>Imagine principala <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label> <br> <div class="fileUpload2 col-xs-8 text-center"> 
                                            <div class="attach_pdf_icon"> 
                                                <i class="fas fa-image"></i> 
                                                <span class="black_img">Adauga imagine principala</span> 
                                            </div> 
                                            <input type="file" name="image1" id="image1" class="upload"> 
                                        </div> 
                                        <?
                                        $url_image1 = '';
                                        if($set_anunturi_r->image1 != ''){
                                            if(strpos($set_anunturi_r->image1, 'resources/assets/uploads/') !== false) {
                                                $url_image1 = 'style="background: url(\''.url('/').'/'.$set_anunturi_r->image1.'\');background-size: cover;"';
                                            } else {
                                                $url_image1 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$set_anunturi_r->image1.'\');background-size: cover;"';
                                            }
                                        }
                                        ?>
                                        <div class="img_uploaded col-xs-4 openSaysMe" id="mod_img_src1" data-modal="Anunturi_sparte" data-dowhat="img" data-id="<?=$set_anunturi_r->id?>" <?=$url_image1?>></div> 
                        
                                    </div>
                                    <div class="col-xs-12 col-md-6">  
                                        <br/>
                                        <div class="fileUpload2 col-xs-8 text-center">
                                            <div class="attach_pdf_icon">
                                                <i class="fas fa-image"></i>
                                                <span class="black_img">Adauga imagine 2</span>    
                                            </div>
                                            <input type="file" name="image2" id="image2" class="upload">
                                        </div>
                                        <?
                                        $url_image2 = '';
                                        if($anunturi_sp_p->image2 != ''){
                                            if(strpos($anunturi_sp_p->image2, 'resources/assets/uploads/') !== false) {
                                                $url_image2 = 'style="background: url(\''.url('/').'/'.$anunturi_sp_p->image2.'\');background-size: cover;"';
                                            } else {
                                                $url_image2 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$anunturi_sp_p->image2.'\');background-size: cover;"';
                                            }
                                        }
                                        ?>
                                        <div class="img_uploaded col-xs-4 openSaysMe" id="mod_img_src2" data-modal="Anunturi" data-dowhat="img" data-id="<?=$anunturi_sp_p->id?>" <?=$url_image2?>></div> 
                                    </div>
                                    <div class="col-xs-12 col-md-6"> 
                                        <br/> 
                                        <div class="fileUpload2 col-xs-8 text-center">
                                            <div class="attach_pdf_icon">
                                                <i class="fas fa-image"></i>
                                                <span class="black_img">Adauga imagine 3</span>    
                                            </div>
                                            <input type="file" name="image3" id="image3" class="upload">
                                        </div>
                                        <?
                                        $url_image3 = '';
                                        if($anunturi_sp_p->image3 != ''){
                                            if(strpos($anunturi_sp_p->image3, 'resources/assets/uploads/') !== false) {
                                                $url_image3 = 'style="background: url(\''.url('/').'/'.$anunturi_sp_p->image3.'\');background-size: cover;"';
                                            } else {
                                                $url_image3 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$anunturi_sp_p->image3.'\');background-size: cover;"';
                                            }
                                        }
                                        ?>
                                        <div class="img_uploaded col-xs-4 openSaysMe" id="mod_img_src3" data-modal="Anunturi" data-dowhat="img" data-id="<?=$anunturi_sp_p->id?>" <?=$url_image3?>></div> 
                                    </div>
                                    <div class="col-xs-12 col-md-6">  
                                        <br/>
                                        <div class="fileUpload2 col-xs-8 text-center">
                                            <div class="attach_pdf_icon">
                                                <i class="fas fa-image"></i>
                                                <span class="black_img">Adauga imagine 4</span>    
                                            </div>
                                            <input type="file" name="image4" id="image4" class="upload">
                                        </div>
                                        <?
                                        $url_image4 = '';
                                        if($anunturi_sp_p->image4 != ''){
                                            if(strpos($anunturi_sp_p->image4, 'resources/assets/uploads/') !== false) {
                                                $url_image4 = 'style="background: url(\''.url('/').'/'.$anunturi_sp_p->image4.'\');background-size: cover;"';
                                            } else {
                                                $url_image4 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$anunturi_sp_p->image4.'\');background-size: cover;"';
                                            }
                                        }
                                        ?>
                                        <div class="img_uploaded col-xs-4 openSaysMe" id="mod_img_src4" data-modal="Anunturi" data-dowhat="img" data-id="<?=$anunturi_sp_p->id?>" <?=$url_image4?>></div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">  
                                        <br/>
                                        <div class="fileUpload2 col-xs-8 text-center">
                                            <div class="attach_pdf_icon">
                                                <i class="fas fa-image"></i>
                                                <span class="black_img">Adauga imagine 5</span>    
                                            </div>
                                            <input type="file" name="image5" id="image5" class="upload">
                                        </div>
                                        <?
                                        $url_image5 = '';
                                        if($anunturi_sp_p->image5 != ''){
                                            if(strpos($anunturi_sp_p->image5, 'resources/assets/uploads/') !== false) {
                                                $url_image5 = 'style="background: url(\''.url('/').'/'.$anunturi_sp_p->image5.'\');background-size: cover;"';
                                            } else {
                                                $url_image5 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$anunturi_sp_p->image5.'\');background-size: cover;"';
                                            }
                                        }
                                        ?>
                                        <div class="img_uploaded col-xs-4 openSaysMe" id="mod_img_src5" data-modal="Anunturi" data-dowhat="img" data-id="<?=$anunturi_sp_p->id?>" <?=$url_image5?>></div>
                                    </div>                
                                    <div class="col-xs-12"> 
                                        <br/> 
                                        <div class="fileUpload2 <?=$set_anunturi_r->video != '' ? 'col-xs-8' : 'col-xs-12'?> text-center"> 
                                            <div class="attach_pdf_icon"> 
                                                <i class="fas fa-video"></i>
                                                <span class="black_img">Adauga video 
                                                    <span class="formats">(format : mp4,webm,ogg,3gp)</span>
                                                </span> 
                                            </div> 
                                            <input type="file" name="video" id="video" class="upload"> 
                                        </div>
                                        <? if($set_anunturi_r->video != '') { ?> 
                                            <div class="img_uploaded col-xs-4 openSaysMe" id="mod_img_src5" data-modal="Anunturi_sparte" data-dowhat="video" data-id="<?=$set_anunturi_r->id?>"><i class="fas fa-play"></i></div>
                                        <? } ?> 
                                    </div>            
                                    <div class="col-xs-12 text-center">
                                        <br/> 
                                        <br/> 
                                        <input type="submit" value="Update general pentru toate anunturile" class="btn btn-primary2">
                                        <br/> 
                                        <br/> 
                                        <br/> 
                                    </div>
                                </form>
                                <script>
                                    $(document).ready(function() {
                                        $('#marca').select2();
                                        $('#model').select2();
                                        $('#categoriepiesa').select2();
                                        $('#piesa').select2();
                                        $('#an').select2();
                                        $('#carburant').select2();
                                        $('#cutie_viteze').select2();
                                        var marca       = $('#marca').val();
                                        $.get('<?=url('/')?>/ajax/get-model/'+marca, function(data) {
                                            $("#model option").remove();
                                            $.each(JSON.parse(data), function(i, value) {
                                                $('#model').append($('<option>').text(value.model).attr('value', value.model));
                                                $("#model").val('<?=$set_anunturi_r->model?>');
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
                                        $("#image1,#image2,#image3,#image4,#image5,#image6,#image7,#image8,#image9").change(
                                        function(){
                                            readURL(this);
                                        });
                                    });
                                </script>
                              </div>
                        </div>
                    </div>
                </div>
		    </div>


            <div class="col-xs-12 col-md-10">
                <form class="form-horizontal" method="POST" action="{{ route('modifica-generator') }}"" enctype="multipart/form-data">  
                    {{ csrf_field() }}
                    <input type="hidden" name="anunt_existent_id" value="<?=$set_anunturi_r->id?>">
                    
                    <table id="datatable_anunturi" class="display dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="no-sort img_an_mb" valing="top">IMG</th>
                                <th class="hidden-xs hidden-sm">TITLU</th>
                                <th class="hidden-xs hidden-sm">PRET</th>
                                <th class="hidden-xs hidden-sm">MONEDA</th>
                            </tr>
                        </thead>
                    </table>

                    <div class="col-xs-12 text-center">
                        <br/> 
                        <br/> 
                        <input type="submit" value="Modifica lista de piese" class="btn btn-primary2">
                        <br/> 
                        <br/> 
                        <br/> 
                    </div>
                </form>
                <div id="pageInfo"></div>
                <script>
                    $(document).ready(function() {
                        var table = $('#datatable_anunturi').DataTable( {
                            "bLengthChange": true,
                            "bInfo": true,
                            "pageLength": 248,
                            "lengthMenu": [[20, 40, 60, 80, 100 -1], [20, 40, 60, 80, 100, "all"]],
                            "deferRender": false,
                            "cache": false,
                            "serverSide": true,
                            "language": {
                                "search": "",
                                "searchPlaceholder": "SEARCH..."
                            },            
                            "ajax": "<?=url('/')?>/datatables/set-anunturi/<?=$set_anunturi_r->id?>",
                            "columns": [
                                { "data": "image" },
                                { "data": "titlu" },
                                { "data": "pret" },
                                { "data": "moneda" }
                            ],
                            "order": [],
                            "columnDefs": [     
                                { className: "no-sort xs-text-left sm-text-left img_an_mb", "targets": [ 0 ], "orderable": false }, 
                                { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 1 ], "orderable": false }, 
                                { className: "no-sort hidden-xs hidden-sm warpesTdSmall", "targets": [ 2 ], "orderable": false },
                                { className: "no-sort hidden-xs hidden-sm warpesTdSmall", "targets": [ 3 ], "orderable": false }
                            ]
                        } );
                    });
                </script>
                <br/>
                <br/>
                <br/>
            </div>
	  	</div>
	</div>

@endsection