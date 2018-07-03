@extends('layouts.frontend.app')

@section('content')
    <div class="container-fluid nopadding goBlackMob">
        <div class="NormalPageHome">
            <video muted autoplay loop>
                <source src="<?=url('/')?>/resources/assets/video/autocycle.mp4" type="video/mp4">
                <source src="<?=url('/')?>/resources/assets/video/autocycle.avi" type="video/avi">
                <source src="<?=url('/')?>/resources/assets/video/autocycle.mpg" type="video/mpg">
            </video>
            <div class="row nopadding goooo">
                <div class="col-xs-12 col-md-10 col-md-offset-1 text-center h1Home">
                    <h1>dezmembrari auto</h1>
                    <h4>Autocycle va ofera o gama larga de piese auto din dezmembrari la cele mai avantajoase preturi. Piesele noastre sunt testate, oferim garantie, factura si posibilitatea de retur.</h4>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1 FilterHome">
                    <form action="{{route('filtrare-anunturi')}}" method="GET">
                        <div class="col-xs-12 col-md-3 containBtnHome">
                            <select id="marca" name="marca" class="HomeSelect">
                                <option value="">Marca</option>
                                <? foreach ($marci_c as $marci_r) { ?>
                                    <option value="<?=$marci_r->marca?>" <?=old('marca') == $marci_r->marca ? 'selected':''?> required autofocus><?=$marci_r->marca?></option>
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
                                    echo '<option value="'.$piese_r->piesa.'">'.$piese_r->piesa.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-3 containBtnHome">
                            <input type="submit" value="Cauta" class="HomeSubmit">
                            <i class="fas fa-search"></i>
                        </div>
                    </form>
                </div>

                <div class="col-xs-12 col-md-4 col-md-offset-4 text-center CallUsNow hidden-xs hidden-sm">
                
                    <a href="tel:+40721186386" title="vezi toate piesele" class="btn HomeSubmit"><i class="fas fa-phone"></i> &nbsp; 0721 186 386 &nbsp;&nbsp; SUNA ACUM !</a>
                        
                </div>
                <script>
                    $(document).ready(function() {
                        $('#marca').select2();
                        $('#model').select2();
                        $('#piesa').select2();
                        var marca       = $('#marca').val();
                        $.get('<?=url('/')?>/ajax/get-model/'+marca, function(data) {
                          $("#model option").remove();
                          $('#model').append($('<option>').text('selecteaza').attr('value',''));
                          $.each(JSON.parse(data), function(i, value) {
                            $('#model').append($('<option>').text(value.model).attr('value', value.model));
                            });
                        });
                        $('#marca').change(function() {
                            var marca       = $('#marca').val();
                            $.get('<?=url('/')?>/ajax/get-model/'+marca, function(data) {
                              $("#model option").remove();
                              $('#model').append($('<option>').text('selecteaza').attr('value',''));
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


    <div class="container-fluid blockUltimele">
        <div class="container">
            <div class="row">
                <div class="col-xs-12  text-center titluUltimeleHome">
                    <h3>Ultimele piese adaugate pe stoc</h3>
                </div>

                <? foreach ($anunturi_c as $anunturi_r) { ?>
                    <div class="col-xs-12 col-md-3 AnuntuHome">
                        <div class="titluHome"><?=$anunturi_r->titlu;?></div>
                        <div class="containerImg" style="background: url('<?=strpos($anunturi_r->image1, 'resources/assets/uploads/') !== false ? url('/').'/'.$anunturi_r->image1 : 'https://dezmembrarisipieseauto.ro/'.$anunturi_r->image1 ?>')" onclick="window.location = '<?=$anunturi_r->AnuntUrl()?>'">
                            <!--
                            <img class="img-responsive pozaHome" src="<?//=strpos($anunturi_r->image1, 'resources/assets/uploads/') !== false ? url('/').'/'.$anunturi_r->image1 : 'https://dezmembrarisipieseauto.ro/'.$anunturi_r->image1 ?>">
                            -->
                            <div class="overlay">
                                <div class="HomeVezi">
                                    <a href="<?=$anunturi_r->AnuntUrl()?>" title="<?=$anunturi_r->titlu?>" class="btn btn-primary">VEZI PIESA <i class="fas fa-arrow-alt-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="HomeVezi2 hidden-md hidden-lg">
                                <a href="<?=$anunturi_r->AnuntUrl()?>" title="<?=$anunturi_r->titlu?>" class="btn btn-primary">VEZI PIESA <i class="fas fa-arrow-alt-circle-right"></i></a>
                            </div>

                            <div class="someDetails">
                                <?=$anunturi_r->piesa;?><span class="hidden-xs hidden-sm"> - <?=$anunturi_r->marca;?> <?=$anunturi_r->model;?></span>
                            </div>
                        </div>
                    </div>
                <? } ?>

                <div class="col-xs-12 text-center VeziToatePiesele">
                    <a href="{{ route('listare-anunturi') }}" title="vezi toate piesele" class="btn btn-primary2">VEZI TOATE PIESELE </a>
                </div>

            </div>



        </div>
    </div>


    <div class="container-fluid fifth_container"> 
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center title_fifth_container">
                    <h3>Informatii utile Autocycle </h3>
                </div>
            </div>

            <div class="row little_padding">
                <div class="col-md-4 block_pic_info">
                    <div class="row-fluid">
                        <div class="col-xs-2 col-md-3 block_pic">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="col-xs-10 col-md-9 block_info">  
                            <h4>Piese originale din dezmembrari</h4>
                            <p class="grey_75">Toate piesele oferite spre vanzare sunt originale, ele provenind din dezmembrarea masinilor. Deasemni piesele sunt testate si perfect functionale</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 block_pic_info">
                    <div class="row-fluid">
                        <div class="col-xs-2 col-md-3 block_pic">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="col-xs-10 col-md-9 block_info">  
                            <h4>Oferim garantie</h4>
                            <p class="grey_75">Autocycle ofera garantie timp de 3 luni de zile pentru orice fel de piesa achizitionata de la noi. </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 block_pic_info">
                    <div class="row-fluid">
                        <div class="col-xs-2 col-md-3 block_pic">
                            <i class="fas fa-thumbs-up"></i>
                        </div>
                        <div class="col-xs-10 col-md-9 block_info">  
                            <h4>Oferim retur</h4>
                            <p class="grey_75">Oferim retur pentru orice fel de piesa cumparata de la noi, clientul putant sa returneze piesa in termen de 15 zile de la achizitionarea ei, putand sa primeasca alta piesa la schimb sau banii inapoi</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 block_pic_info">
                    <div class="row-fluid">
                        <div class="col-xs-2 col-md-3 block_pic">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="col-xs-10 col-md-9 block_info">  
                            <h4>Livram in toata tara in 24h</h4>
                            <p class="grey_75">Autocycle cu sediul in Pucioasa, Dambovita face livrari de piese contra cost in toata tara in 24-48 de ore, de la plasarea comenzii.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 block_pic_info">
                    <div class="row-fluid">
                        <div class="col-xs-2 col-md-3 block_pic">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="col-xs-10 col-md-9 block_info">  
                            <h4>Cele mai bune preturi</h4>
                            <p class="grey_75">Autocycle vine cu cea mai buna oferta de preturi raportat la calitatea pieselor din dezmembrari oferite   </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 block_pic_info">
                    <div class="row-fluid">
                        <div class="col-xs-2 col-md-3 block_pic">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <div class="col-xs-10 col-md-9 block_info">  
                            <h4>Montare piese in service</h4>
                            <p class="grey_75">Montam contra cost piese achizitionate la service-ul propiu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-6 HartaSite">
                <iframe
                    width="100%"
                    height="450"
                    frameborder="0" style="border:0"
                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCDDqw_S-WWQobZLqFE9Qki-nxLVysh3ic
                    &q=Autocycle&center=45.077510, 25.437304" allowfullscreen>
                </iframe>
            </div>
            <div class="col-xs-12 col-md-6 text-center Abonare">
                <h3>Abonare oferte piese</h3>
                <p>Aboneaza-te la newsletterul nostru si ori de cate ori avem promotii de la piese, te vom anunt pe email.</p>
                <form action="{{route('newsletter')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="input-group col-xs-12 col-md-6 col-md-offset-3">
                    <input type="text" name="name" placeholder="Nume si prenume" class="search-query form-control"> 
                    </div>
                    <div class="input-group col-xs-12 col-md-6 col-md-offset-3 NewsletterLocationFooter">
                        <input type="text" name="email" placeholder="Email" class="search-query form-control"> 
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection




<!--
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            
                            <div class="carousel-caption">
                                ceva 1 <br/>
                                ceva 1 <br/>
                                ceva 1 <br/>
                                ceva 1 <br/>
                                ceva 1 <br/>
                                ceva 1 <br/>
                                ceva 1 <br/>
                            </div>
                        </div>
                    
                        <div class="item">
                            
                            <div class="carousel-caption">
                                ceva 2 <br/>
                                ceva 2 <br/>
                                ceva 2 <br/>
                                ceva 2 <br/>
                                ceva 2 <br/>
                                ceva 2<br/>
                                ceva 2 <br/>
                            </div>
                        </div>
                        ...
                    </div>

                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>




-->