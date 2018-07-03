@extends('layouts.frontend.app')
@section('content')
    <div class="container-fluid NormalPageColor">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1X">
                <h1><i class="fas fa-info-circle"></i> Despre noi</h1>
                @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                Despre noi - Autocycle
                <br/><br/>
            </div>
        </div>
    </div>
    <div class="container NormalPageWhite">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                Compania Auto Cycle este un parc de dezmembrari si sursa dumneavoastra pentru piesele si accesoriile de cea mai buna calitate la preturi rezonabile. <br/>
                Suntem autorizati de Registru Auto Roman, Politia Romana, Agentia de Protectie a Mediului DAMBOVITA.
                Oferim piese si accesorii originale second hand pentru autoturisme. <br/>  
                Indiferent ce va trebuie, de la o oglinda la un motor, puteti cumpara de la magazinul nostru, sau puteti comanda online si va vor fi livrate.
                Pentru a beneficia de garantie montare pieselor trebuie facuta in service autorizat RAR.
                Garantia este de 90 zile.
                Mărci auto dezmembrate:
                Audi, Citroen, Dacia, Honda, Mazda, Mercedes, Nissan, Renault, Toyota, VW  
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br/><br/>
                <div class="row paddingBtDesk">
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/1.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/2.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/3.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/4.jpg'?>" class="img-responsive">
                    </div>
                </div>
                <div class="row paddingBtDesk">
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/5.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/6.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/7.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/8.jpg'?>" class="img-responsive">
                    </div>
                </div>

                <div class="row paddingBtDesk">
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/9.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/10.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/11.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/12.jpg'?>" class="img-responsive">
                    </div>
                </div>

                <div class="row paddingBtDesk">
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/13.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/14.jpg'?>" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-md-3 MbPaddingBt">
                        <img src="<?=url('/').'/resources/assets/despre-noi/15.jpg'?>" class="img-responsive">
                    </div>
                </div>

            </div>
    </div>
@endsection