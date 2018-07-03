@extends('layouts.frontend.app')
@section('content')
    <div class="container-fluid NormalPageColor">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1">
                <h1>dezmembrari auto <span class="smalller"> - <?=$h1?></span></h1>
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="row InfoAboutAnunturi">
                    <div class="col-xs-12 col-md-6 nopadding text-left info_st"><i class="fas fa-eye"></i> <?=$count_anunturi?> piese pe stoc pentru <?=$h1?></div>
                    <div class="col-xs-12 col-md-6 nopadding text-right info_dr">preturi intre <?=$pret_min?> RON si <?=$pret_max?> RON <i class="far fa-money-bill-alt"></i></div>
                </div>
            </div>

            <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <form action="{{route('filtrare-anunturi')}}" method="GET">
                        <div class="col-xs-12 col-md-3 containBtnHome">
                            <select id="marca" name="marca" class="HomeSelect">
                                <option value="">Marca</option>
                                <? foreach ($marci_c as $marci_r) { ?>
                                    <option value="<?=$marci_r->marca?>" <?=$marca_aleasa == $marci_r->marca ? 'selected':''?> required autofocus><?=$marci_r->marca?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-3 containBtnHome">
                            <select id="model" name="model" class="HomeSelect">
                                <option value="">Model</option>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-3 containBtnHome">
                            <select name="piesa" id="piesa" class="HomeSelect">
                            <option value="">PIESA</option>
                            <?  foreach ($piese_c as $piese_r) {   
                                    echo '<option value="'.$piese_r->piesa.'" '.$piesa_aleasa == $piese_r->piesa ? "selected":"" .$piese_r->piesa.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-3 containBtnHome">
                            <input type="submit" value="Cauta" class="HomeSubmitBlack">
                            <i class="fas fa-search"></i>
                        </div>
                    </form>
                    <script>
                        $(document).ready(function() {
                            $('#marca').select2();
                            $('#model').select2();
                            $('#piesa').select2();
                            var marca       = $('#marca').val();
                            $.get('<?=url('/')?>/ajax/get-model/'+marca, function(data) {
                              $("#model option").remove();
                              $.each(JSON.parse(data), function(i, value) {
                                var selected = ' ';
                                if(value.model == '<?=$model_aleasa?>') {
                                    selected = ' selected';
                                }
                                $('#model').append($('<option'+selected+'>').text(value.model).attr('value', value.model));
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
                        });
                    </script>
                </div>
        </div>
    </div>
    <div class="container NormalPage">
        <div class="row nopadding">
            <div class="col-xs-12 col-md-9" id="firstPart">
                <? foreach ($anunturi_c as $anunturi_r) { ?>
                    <div class="row Anunt">
                        <div class="col-xs-12 col-md-3 ImgAnunt">
                            <img src="<?=strpos($anunturi_r->image1, 'resources/assets/uploads/') !== false ? url('/').'/'.$anunturi_r->image1 : 'https://dezmembrarisipieseauto.ro/'.$anunturi_r->image1 ?>" class="img-responsive">
                            <div class="pret"><?=$anunturi_r->pret?> <?=$anunturi_r->moneda?></div>
                        </div>
                        <div class="col-xs-12 col-md-9 AnuntDetails">
                            <div class="row height170">
                                <div class="col-xs-12">
                                    <a href=""><h2><?=$anunturi_r->titlu?></h2></a>
                                </div>
                                <div class="col-xs-12 descAnunt">
                                    <p>
                                        <?=$anunturi_r->descriere?> <br/>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 up30">
                            <div class="row height30">
                                <div class="col-xs-12 col-md-5 positionBottom"><i class="fas fa-wrench"></i> <span><?=$anunturi_r->piesa?></span> </div>
                                <div class="col-xs-12 col-md-5 positionBottom"><i class="fas fa-car"></i> <span><?=$anunturi_r->marca?> - <?=$anunturi_r->model?></span> </div>
                                <div class="col-xs-12 col-md-2 positionBottom"><i class="far fa-clock"></i> <span><?=$anunturi_r->an?></span> </div>


                                <div class="hidden-md hidden-lg col-xs-12 text-right mobileBtn nopadding">
                                    <a href="<?=$anunturi_r->AnuntUrl()?>" title="<?=$anunturi_r->titlu?>" class="btn btn-primary">VEZI PIESA <i class="fas fa-arrow-alt-circle-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="hidden-xs hidden-sm col-md-12 text-center nested">
                            <a href="<?=$anunturi_r->AnuntUrl()?>" title="<?=$anunturi_r->titlu?>" class="btn btn-primary">VEZI PIESA <i class="fas fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                <? } ?>
            </div>
           
            <div class="hidden-xs hidden-sm col-md-3 nopadding">
                <div class="row">
                    <div class="col-xs-12 BlockDr text-center" id="secondPart">
                        <img src="{{ url('/') }}/resources/assets/images/logo.png" class="img-responsive" alt="Autocycle dezmembrari dambovita">
                        <div class="infoTel">
                        </br>
                        Comenzi telefonice : </br></br>
                        <a href="tel:+40787435267" title="vezi toate piesele" class="btn HomeSubmit"><i class="fas fa-phone"></i>  &nbsp; 0787435267</a>
                        </br></br>
                        Comenzi online :  </br></br>
                        <a href="{{route('cerere-piesa')}}" title="vezi toate piesele" class="btn HomeSubmit"><i class="fas fa-cart-plus"></i> Comenzi online!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row nopadding">
            <div class="col-xs-12 text-center">
                <?// echo $anunturi_c->render(); 
                 echo $anunturi_c->appends(request()->input())->links();?>
            </div>
        </div>
    </div>
    <script>
        $( document ).ready(function() {
            var firstPartHeight  = $('#firstPart').height() - 67;
            $('#secondPart').height(firstPartHeight);
        })
    </script>
@endsection