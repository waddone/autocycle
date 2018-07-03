<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Anunturi;
use App\Marci;
use App\Modele;
use App\Categorii;
use App\Piese;
use App\Newsletter;
use Illuminate\Http\UploadedFile;
use Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
// toate facades se pot scrie si asa 
// use Input;

class ModaleController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(){
        $this->middleware('auth')->except(['generalModale']);
        //$this->middleware('auth');
    }
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */

    public function generalModale($modal, $dowhat, $id) {

        //$object_r  = DB::select( DB::raw("SELECT * FROM {$modal} WHERE id = '{$id}' limit 1") )->first();
        //$dowhat = actionul pe care il faci
        //$user_logat_r   = Auth::user();
        //$object_r       = DB::table($modal)->where('id', $id)->first();
        //sau 
        if($modal != 'Call') {
            $modal          = 'App\\'.$modal;
            $object_r       = $modal::where('id', $id)->first();
            $modal          = str_replace('App\\', '', $modal);
            $marci_c        = Marci::all();
            $categ_c        = Categorii::all();
        }
        //////////////////////////////////////////////////////
        ////////// vezi modale cursuri de dans   /////////////
        //////////////////////////////////////////////////////
        if($modal == 'Anunturi') {
            if($dowhat == 'edit') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editare : <?=$object_r->titlu;?></h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form" method="POST" action="<?=route('adauga-anunt-post')?>" enctype="multipart/form-data">
                                <?=csrf_field()?>
                                <input type="hidden" name="anunt_id" value="<?=$object_r->id?>">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="titlu" class="control-label">Titlu anunt <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                            <input id="titlu" type="text" class="form-control" name="titlu" value="<?=$object_r->titlu?>" required autofocus placeholder="titlu anunt"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="marca" class="control-label">Alege model <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                            <select id="marca" name="marca" class="form-control" required autofocus>
                                                <option value="">Alege marca</option>
                                                <? foreach ($marci_c as $marci_r) { ?>
                                                    <option value="<?=$marci_r->marca?>" <?=$object_r->marca == $marci_r->marca ? 'selected':''?>><?=$marci_r->marca?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="model" class="control-label">Alege marca <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                            <select id="model" name="model" class="form-control" required autofocus>
                                                <option value="<?=$object_r->model?>"><?=$object_r->model?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="categoriepiesa" class="control-label">Alege categoria de piesa <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                            <select id="categoriepiesa" name="categoriepiesa" class="form-control" required autofocus>
                                                <option value="">Alege categorie de piesa</option>
                                                <? foreach ($categ_c as $categ_r) { ?>
                                                    <option value="<?=$categ_r->categorie?>" <?=$object_r->categoriepiesa == $categ_r->categorie ? 'selected':''?> required autofocus><?=$categ_r->categorie?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="piesa" class="control-label">Alege piesa <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                            <select id="piesa" name="piesa" class="form-control" required autofocus>
                                                <option value="<?=$object_r->piesa?>"><?=$object_r->piesa?></option>
                                            </select>
                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="descriere" class="control-label">Descriere anunt <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                            <textarea name="descriere" class="form-control" placeholder="Introdu o descriere a anuntului" required autofocus style="height: 120px;"><?=$object_r->descriere!=''?$object_r->descriere:'dezmembram '.$object_r->piesa.' pentru '.$object_r->marca.' '.$object_r->model.' din anul '.$object_r->an?></textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="an" class="control-label">Anul de fabricatie <span class="mandatory"><span>*</span> (CAMP OBLIGATORIU)</span></label>
                                            <select id="an" name="an" class="form-control" required autofocus>
                                                <option value="">Selecteaza anul</option>
                                            <? for($i=1980;$i<='2018';$i++) { ?> 
                                                <option value="<?=$i?>" <?=$object_r->an == $i ? 'selected' : ''?>><?=$i?></option>
                                            <? } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="pret" class="control-label">Pret <span class="mandatory"><span>*</span></span></label>
                                            <input type="text" name="pret" id="pret" class="form-control" value="<?=$object_r->pret!='0'?$object_r->pret:''?>" required autofocus>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="moneda" class="control-label">Moneda <span class="mandatory"><span>*</span></span></label>
                                            <select id="moneda" name="moneda" class="form-control" required autofocus>
                                                <option value="">Selecteaza</option>
                                                <option value="ron" <?=$object_r->moneda == 'ron' ? 'selected' : ''?>>RON</option>
                                                <option value="euro" <?=$object_r->moneda == 'euro' ? 'selected' : ''?>>EURO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 delimiterRed">
                                    <br/>
                                    DETALII SUPLIMENTARE 
                                    <span> introducerea pozelor cat mai relevantate, va ofera o expunere mai buna fata de client.<br> Anunturile ce contin video sunt mult mai de interes pentru client. </span>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="capacitate_cilindrica" class="control-label">Capacitate cilindrica</label>
                                            <input type="text" name="capacitate_cilindrica" id="capacitate_cilindrica" class="form-control" value="<?=$object_r->capacitate_cilindrica?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="carburant" class="control-label">Carburant</label>
                                            <select id="carburant" name="carburant" class="form-control">
                                                <option value="">Selecteaza carburant</option>
                                                <option value="benzina" <?=$object_r->carburant == 'benzina' ? 'selected' : ''?>>benzina</option>
                                                <option value="benzina + gpl" <?=$object_r->carburant == 'benzina + gpl' ? 'selected' : ''?>>benzina + gpl</option>
                                                <option value="motorina" <?=$object_r->carburant == 'motorina' ? 'selected' : ''?>>motorina </option>
                                                <option value="motorina + gpl" <?=$object_r->carburant == 'motorina + gpl' ? 'selected' : ''?>>motorina + gpl</option>
                                                <option value="gpl" <?=$object_r->carburant == 'gpl' ? 'selected' : ''?>>gpl</option>
                                                <option value="alternativ" <?=$object_r->carburant == 'alternativ' ? 'selected' : ''?>>alternativ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="kilowati" class="control-label">Kilowaţi (kW)</label>
                                            <input type="text" name="kilowati" id="kilowati" class="form-control" value="<?=$object_r->kilowati?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cutie_viteze" class="control-label">Cutie viteze</label>
                                            <select id="cutie_viteze" name="cutie_viteze" class="form-control">
                                                <option value="">Selecteaza cutie viteze</option>
                                                <option value="manuala" <?=$object_r->cutie_viteze == 'manuala' ? 'selected' : ''?>>manuala</option>
                                                <option value="automata" <?=$object_r->cutie_viteze == 'automata' ? 'selected' : ''?>>automata</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="serie_sasiu" class="control-label">Serie sasiu</label>
                                            <input type="text" name="serie_sasiu" id="serie_sasiu" class="form-control" value="<?=$object_r->serie_sasiu?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cod_piesa" class="control-label">Cod piesa</label>
                                            <input type="text" name="cod_piesa" id="cod_piesa" class="form-control" value="<?=$object_r->cod_piesa?>">
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
                                    if($object_r->image1 != ''){
                                        if(strpos($object_r->image1, 'resources/assets/uploads/') !== false) {
                                            $url_image1 = 'style="background: url(\''.url('/').'/'.$object_r->image1.'\');background-size: cover;"';
                                        } else {
                                            $url_image1 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$object_r->image1.'\');background-size: cover;"';
                                        }
                                    }
                                    ?>
                                    <div class="img_uploaded col-xs-4" id="mod_img_src1" <?=$url_image1?>></div> 
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
                                    if($object_r->image2 != ''){
                                        if(strpos($object_r->image2, 'resources/assets/uploads/') !== false) {
                                            $url_image2 = 'style="background: url(\''.url('/').'/'.$object_r->image2.'\');background-size: cover;"';
                                        } else {
                                            $url_image2 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$object_r->image2.'\');background-size: cover;"';
                                        }
                                    }
                                    ?>
                                    <div class="img_uploaded col-xs-4" id="mod_img_src2" <?=$url_image2?>></div>
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
                                    if($object_r->image3 != ''){
                                        if(strpos($object_r->image3, 'resources/assets/uploads/') !== false) {
                                            $url_image3 = 'style="background: url(\''.url('/').'/'.$object_r->image3.'\');background-size: cover;"';
                                        } else {
                                            $url_image3 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$object_r->image3.'\');background-size: cover;"';
                                        }
                                    }
                                    ?>
                                    <div class="img_uploaded col-xs-4" id="mod_img_src3" <?=$url_image3?>></div>
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
                                    if($object_r->image4 != ''){
                                        if(strpos($object_r->image4, 'resources/assets/uploads/') !== false) {
                                            $url_image4 = 'style="background: url(\''.url('/').'/'.$object_r->image4.'\');background-size: cover;"';
                                        } else {
                                            $url_image4 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$object_r->image4.'\');background-size: cover;"';
                                        }
                                    }
                                    ?>
                                    <div class="img_uploaded col-xs-4" id="mod_img_src4" <?=$url_image4?>></div>
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
                                    if($object_r->image5 != ''){
                                        if(strpos($object_r->image5, 'resources/assets/uploads/') !== false) {
                                            $url_image5 = 'style="background: url(\''.url('/').'/'.$object_r->image5.'\');background-size: cover;"';
                                        } else {
                                            $url_image5 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$object_r->image5.'\');background-size: cover;"';
                                        }
                                    }
                                    ?>
                                    <div class="img_uploaded col-xs-4" id="mod_img_src5" <?=$url_image5?>></div>
                                </div>
                                <div class="col-xs-12 col-md-6"> 
                                    <br/> 
                                    <div class="fileUpload2 col-xs-8 text-center">
                                        <div class="attach_pdf_icon">
                                            <i class="fas fa-image"></i>
                                            <span class="black_img">Adauga imagine 6</span>    
                                        </div>
                                        <input type="file" name="image6" id="image6" class="upload">  
                                    </div>
                                    <?
                                    $url_image6 = '';
                                    if($object_r->image6 != ''){
                                        if(strpos($object_r->image6, 'resources/assets/uploads/') !== false) {
                                            $url_image6 = 'style="background: url(\''.url('/').'/'.$object_r->image6.'\');background-size: cover;"';
                                        } else {
                                            $url_image6 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$object_r->image6.'\');background-size: cover;"';
                                        }
                                    }
                                    ?>
                                    <div class="img_uploaded col-xs-4" id="mod_img_src6" <?=$url_image6?>></div>
                                </div>
                                <div class="col-xs-12 col-md-6">  
                                    <br/>
                                    <div class="fileUpload2 col-xs-8 text-center">
                                        <div class="attach_pdf_icon">
                                            <i class="fas fa-image"></i>
                                            <span class="black_img">Adauga imagine 7</span>    
                                        </div> 
                                        <input type="file" name="image7" id="image7" class="upload">  
                                    </div>
                                    <?
                                    $url_image7 = '';
                                    if($object_r->image7 != ''){
                                        if(strpos($object_r->image7, 'resources/assets/uploads/') !== false) {
                                            $url_image7 = 'style="background: url(\''.url('/').'/'.$object_r->image7.'\');background-size: cover;"';
                                        } else {
                                            $url_image7 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$object_r->image7.'\');background-size: cover;"';
                                        }
                                    }
                                    ?>
                                    <div class="img_uploaded col-xs-4" id="mod_img_src7" <?=$url_image7?>></div>
                                </div>
                                <div class="col-xs-12 col-md-6">  
                                    <br/>
                                    <div class="fileUpload2 col-xs-8 text-center">
                                        <div class="attach_pdf_icon">
                                            <i class="fas fa-image"></i>
                                            <span class="black_img">Adauga imagine 8</span>    
                                        </div> 
                                        <input type="file" name="image8" id="image8" class="upload">  
                                    </div>
                                    <?
                                    $url_image8 = '';
                                    if($object_r->image8 != ''){
                                        if(strpos($object_r->image8, 'resources/assets/uploads/') !== false) {
                                            $url_image8 = 'style="background: url(\''.url('/').'/'.$object_r->image8.'\');background-size: cover;"';
                                        } else {
                                            $url_image8 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$object_r->image8.'\');background-size: cover;"';
                                        }
                                    }
                                    ?>
                                    <div class="img_uploaded col-xs-4" id="mod_img_src8" <?=$url_image8?>></div>
                                </div>
                                <div class="col-xs-12 col-md-6"> 
                                    <br/> 
                                    <div class="fileUpload2 col-xs-8 text-center">
                                        <div class="attach_pdf_icon">
                                            <i class="fas fa-image"></i>
                                            <span class="black_img">Adauga imagine 9</span>    
                                        </div>
                                        <input type="file" name="image9" id="image9" class="upload">  
                                    </div>
                                    <?
                                    $url_image9 = '';
                                    if($object_r->image9 != ''){
                                        if(strpos($object_r->image9, 'resources/assets/uploads/') !== false) {
                                            $url_image9 = 'style="background: url(\''.url('/').'/'.$object_r->image9.'\');background-size: cover;"';
                                        } else {
                                            $url_image9 = 'style="background: url(\'https://dezmembrarisipieseauto.ro/'.$object_r->image9.'\');background-size: cover;"';
                                        }
                                    }
                                    ?>
                                    <div class="img_uploaded col-xs-4" id="mod_img_src9" <?=$url_image9?>></div>
                                </div>

                                <div class="col-xs-12"> 
                                    <br/> 
                                    <div class="fileUpload2 col-xs-12 text-center"> 
                                        <div class="attach_pdf_icon"> 
                                            <i class="fas fa-video"></i>
                                            <span class="black_img">Adauga video 
                                                <span class="formats">(format : mp4,webm,ogg,3gp)</span>
                                            </span> 
                                        </div> 
                                        <input type="file" name="video" id="video" class="upload">  
                                    </div>
                                </div>
                            
                                <div class="col-xs-12 text-center">
                                    <br/> 
                                    <br/> 
                                    <input type="submit" value="Modifica anunt" class="btn btn-primary2">
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
                                            $("#model").val('<?=$object_r->model?>');
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
                                    var categ       = $('#categoriepiesa').val();
                                    $.get('<?=url('/')?>/ajax/get-piesa/'+categ, function(data) {
                                        $("#piesa option").remove();
                                        $.each(JSON.parse(data), function(i, value) {
                                            $('#piesa').append($('<option>').text(value.piesa).attr('value', value.piesa));
                                            $("#piesa").val('<?=$object_r->piesa?>');
                                        });
                                    });
                                    $('#categoriepiesa').change(function() {
                                        var categ       = $('#categoriepiesa').val();
                                        $.get('<?=url('/')?>/ajax/get-piesa/'+categ, function(data) {
                                          $("#piesa option").remove();
                                          $.each(JSON.parse(data), function(i, value) {
                                            $('#piesa').append($('<option>').text(value.piesa).attr('value', value.piesa));
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
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">sterge : <?=$object_r->titlu;?></h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <form class="form-horizontal" method="POST" action="<?=route('sterge-anunt')?>" enctype="multipart/form-data">
                                <?=csrf_field()?>
                                <input type="hidden" name="anunt_id" value="<?=$object_r->id?>">
                                <input type="submit" value="Sterge anunt" class="btn btn-primary2">
                            </form>
                        </div>
                    </div>
                </div>
            <? } 
            if($dowhat == 'reactiveaza') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">reactiveaza : <?=$object_r->titlu;?></h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <form class="form-horizontal" method="POST" action="<?=route('reactiveaza-anunt')?>" enctype="multipart/form-data">
                                <?=csrf_field()?>
                                <input type="hidden" name="anunt_id" value="<?=$object_r->id?>">
                                <input type="submit" value="Reactiveaza anunt" class="btn btn-primary2">
                            </form>
                        </div>
                    </div>
                </div>
            <? } 
            if($dowhat == 'img') {
                if(strpos($object_r->image1, 'resources/assets/uploads/') !== false) {
                    $image_url = url('/').'/'.$object_r->image1;
                } else {
                    $image_url = 'https://dezmembrarisipieseauto.ro/'.$object_r->image1;

                } ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Imagine : <?=$object_r->titlu;?></h4>
                </div>
                <img src="<?=$image_url?>" class="img-responsive">
            <? } 
            if($dowhat == 'video') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Video : <?=$object_r->titlu;?></h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <video width="320" height="240" controls>
                                <?
                                $ext  = explode(".", $object_r->video);
                                $ext  = strtolower(end($ext));
                                ?>
                                <source src="<?=url('/')?>/<?=$object_r->video?>" type="video/<?=$ext?>">
                            </video>
                        </div>
                    </div>
                </div>
            <? } 
        } // end modal Anunturi
        if($modal == 'Anunturi_sparte') {
            if($dowhat == 'img') {
                if(strpos($object_r->image1, 'resources/assets/uploads/') !== false) {
                    $image_url = url('/').'/'.$object_r->image1;
                } else {
                    $image_url = 'https://dezmembrarisipieseauto.ro/'.$object_r->image1;

                } ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Imagine</h4>
                </div>
                <img src="<?=$image_url?>" class="img-responsive">
            <? } 
            if($dowhat == 'video') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Video</h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <video width="320" height="240" controls>
                                <?
                                $ext  = explode(".", $object_r->video);
                                $ext  = strtolower(end($ext));
                                ?>
                                <source src="<?=url('/')?>/<?=$object_r->video?>" type="video/<?=$ext?>">
                            </video>
                        </div>
                    </div>
                </div>
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Sterge set anunturi <?=$object_r->model?> <?=$object_r->marca?> </h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <form class="form-horizontal" method="POST" action="<?=route('sterge-set-anunt')?>" enctype="multipart/form-data">
                                <?=csrf_field()?>
                                <input type="hidden" name="anunt_spart_id" value="<?=$object_r->id?>">
                                <input type="submit" value="Sterge set anunt" class="btn btn-primary2">
                            </form>
                        </div>
                    </div>
                </div>
            <? } 
        } // end modal Anunturi
        if($modal == 'Cereri') {
            if($dowhat == 'detalii') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Detalii cerere: <?=$object_r->id;?></h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12">
                            Nume : <?=$object_r->nume;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            Telefon : <?=$object_r->telefon;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            Marca : <?=$object_r->marca;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            Model : <?=$object_r->model;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            An : <?=$object_r->an;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            Carburant : <?=$object_r->carburant;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            Piese : <?=$object_r->descriere;?>
                        </div>
                    </div>
                    <? if($object_r->image1 != '') { ?> 
                    <div class="row">
                        <div class="col-xs-12">
                            Imagine :<br/> <img src="<?=url('/')?>/<?=$object_r->image1;?>" style="height: 300px;" class="img-responsive">
                        </div>
                    </div>
                    <? } ?>
                </div>
            <? } 
            if($dowhat == 'rezolvata') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cerere rezolvata ?: <?=$object_r->id;?></h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <form class="form-horizontal" method="POST" action="<?=route('activeaza-rezolvata')?>" enctype="multipart/form-data">
                                <?=csrf_field()?>
                                <input type="hidden" name="id" value="<?=$object_r->id?>">
                                <input type="submit" value="Cerere rezolvata ?" class="btn btn-primary2">
                            </form>
                        </div>
                    </div>
                </div>
            <? } 
            if($dowhat == 'img') { ?>
                <div class="img-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Imagine cerere : <?=$object_r->id;?></h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12">
                            <img src="<?=url('/')?>/<?=$object_r->image1;?>" style="max-height: 500px;" class="img-responsive">
                        </div>
                    </div>
                </div>
            <? } 
        }
        if($modal == 'Newsletter') {
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Activeaza newsletterul pentru : <?=$object_r->name;?></h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" action="<?=route('newsletter-post-2')?>" method="POST">
                                <?=csrf_field()?>
                                <input id="id" type="hidden" class="form-control" name="id" value="<?=$object_r->id;?>">
                                <input id="active" type="hidden" class="form-control" name="active" value="yes">
                                <div class="col-xs-12 text-center">
                                    <br/> 
                                    <input type="submit" value="Activeaza user" class="btn btn-primary2">
                                    <br/> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <? } 
            if($dowhat == 'deactivate') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Dezactiveaza newsletterul pentru : <?=$object_r->name;?></h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <form class="form-horizontal" action="<?=route('newsletter-post-2')?>" method="POST">
                                <?=csrf_field()?>
                                <input id="id" type="hidden" class="form-control" name="id" value="<?=$object_r->id;?>">
                                <input id="active" type="hidden" class="form-control" name="active" value="no">
                                <div class="col-xs-12 text-center">
                                    <br/> 
                                    <input type="submit" value="Dectiveaza user" class="btn btn-primary2">
                                    <br/> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <? } 
        }
        if($modal == 'Call') {
            if($dowhat == 'call') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Comanda piese telefonic sau online</h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-offset-3 text-center">
                            <a href="tel:+40721186386" title="vezi toate piesele" class="btn HomeSubmit"><i class="fas fa-phone"></i>  &nbsp; 0721 186 386</a></br></br>
                            <a href="tel:+40726369949" title="vezi toate piesele" class="btn HomeSubmit"><i class="fas fa-phone"></i>  &nbsp; 0726 369 949</a></br></br>
                            <a href="tel:+40770406076" title="vezi toate piesele" class="btn HomeSubmit"><i class="fas fa-phone"></i>  &nbsp; 0770 406 076</a></br></br>
                        </br></br>
                           <br/>
                           <br/>
                           <br/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-offset-3 text-center">
                           <a href="<?=route('cerere-piesa')?>" title="vezi toate piesele" class="btn HomeSubmit2"><i class="fas fa-cart-plus"></i> Cerere piesa!</a>
                        </div>
                    </div>
                </div>
            <? } 
        }
        ?>

                                       
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

<? // 
    }


}