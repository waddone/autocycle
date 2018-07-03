<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Autocycle - dezmembrari auto Dambovita') }}</title>
    <link href="{{ url('/') }}/resources/assets/css/app.css?ver=1.01" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="{{ url('/') }}/resources/assets/css/style.css?ver=1.98" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <link href="{{ url('/') }}/resources/assets/css/data_table.min.css" rel="stylesheet">
    <!--
    <script src="{{ url('/') }}/resources/assets/js/jquery.dataTables.min.js"></script>
    -->
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <style>
        .impersonate-bar {
            position: fixed;
            bottom: 15px;
            left: 15px;
            width: 20%;
        }
    </style>
</head>
<body>
    <div id="app">
        <?
        if(Route::currentRouteName() == 'home') {
            $navbar = '';
            $logo   = 'logo';
            $fixed  = '';
        } else {
            $navbar = '';
            $logo   = 'logo';
            $fixed  = 'navbar-fixed-top';
        }
        ?>

        <header>
            <nav class="navbar navbar-default <?=$fixed?> <?=$navbar?>">
                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand ImgLogo" href="{{ url('/') }}" title="Autocycle">
                            <img src="{{ url('/') }}/resources/assets/images/<?=$logo?>.png" alt="Autocycle">
                            <span class="LogoText">Autocycle.ro</span>
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            <li><a href="{{ route('home') }}" title="Home" <?=Route::currentRouteName() == 'home' ? 'class="active"' : ''?>>Home</a></li>
                            <li><a href="{{ route('listare-anunturi') }}" title="dezmembrari auto" <?=Route::currentRouteName() == 'listare-anunturi' ? 'class="active"' : ''?>>Dezmembrari auto</a></li>
                            <li><a href="{{ route('cerere-piesa') }}" title="Cerere piesa" <?=Route::currentRouteName() == 'cerere-piesa' ? 'class="active"' : ''?>>Cerere piesa</a></li>
                            <li><a href="{{ route('despre-noi') }}" title="despre noi" <?=Route::currentRouteName() == 'despre-noi' ? 'class="active"' : ''?>>Despre noi</a></li>
                            <li><a href="{{ route('contact') }}" title="contact" <?=Route::currentRouteName() == 'contact' ? 'class="active"' : ''?>>Contact</a></li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li><a href="{{ route('login') }}" title="login">Login</a></li>
                                <li><a href="{{ route('register') }}" title="cont nou">Cont nou</a></li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ route('contul-meu') }}">Contul meu</li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        @yield('content')
    </div>


    <footer>
        <nav class="to_hide_on_mobile">
            <div class="container">
                <div class="row nopadding">
                    <?=breadcrumbs()?>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <a class="navbar-brand ImgLogo" href="{{ url('/') }}" title="Autocycle">
                        <img src="{{ url('/') }}/resources/assets/images/logo_footer.png" alt="Autocycle">
                        <span class="LogoText">Autocycle.ro</span>
                    </a>
                    <ul>
                        <li>SC Auto Cycle SRL </li>
                        <li>CUI: 34240709</li>
                        <li>Reg. Com.: J15/190/2015</li>
                    </ul>
                </div>
                <div class="col-xs-12 col-md-4">
                    <h4>DESPRE NOI</h4>
                    <ul>
                        <li><a href="{{ route('listare-anunturi') }}" title="">Piese din dezmembrari</a></li>
                        <li><a href="{{ route('despre-noi') }}" title="">Despre noi</a></li>
                        <li><a href="{{ route('contact') }}" title="">Contact</a></li>
                        <li><a href="{{ route('termeni-si-conditii') }}" title="">Termeni si conditii </a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-md-4">
                    <h4>Piese din dezmembrari</h4>
                    <ul>
                        <li><a href="" title="">Dezmembrari Mazda</a></li>
                        <li><a href="" title="">Dezmembrari Mercedes</a></li>
                        <li><a href="" title="">Dezmembrari Honda</a></li>
                        <li><a href="" title="">Dezmembrari Audi</a></li>
                        <li><a href="" title="">Dezmembrari Nissan</a></li>
                        <li><a href="" title="">Dezmembrari Dacia</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center atention">
                    <hr>
                    © www.autocycle.ro & www.autodezmembrat.ro ATENTIE! Parc dezmembrari auto situat in Pucioasa judetul Dambovita. Comercializam numai piese originale dupa masini importate din europa. Oferim garantie 90 zile pentru piesele comercializate.
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <a class="CallMobileModal openSaysMe" data-modal="Call" data-dowhat="call" data-id="call">
        <i class="fas fa-phone"></i>
    </a>
    <div class="modal fade" id="ModalGeneral" role="dialog">  
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content showModalContent" id="showModalContent">
                <div class="modal-header text-center">
                </div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <img id="imageLoading" class="img-responsive" src="{{url('/')}}/resources/assets/images/image_loading.gif">
                </div>
                <div class="modal-footer text-center">
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $(document).on("click",".openSaysMe",function() {
                var id     = $(this).data("id");
                var modal  = $(this).data("modal");
                var dowhat = $(this).data("dowhat");
                openModal(id,modal,dowhat);
            });
            function openModal(id,modal,dowhat) {
                id     = typeof id     !== 'undefined' ? id  : null;
                modal  = typeof modal  !== 'undefined' ? modal  : null;
                dowhat = typeof dowhat !== 'undefined' ? dowhat  : null;
                $('#ModalGeneral').modal('show');
                $('#showModalContent').html('<div class="modal-header text-center"></div><div class="modal-body lower-on-sm text-center img_centered"><img id="imageLoading" class="img-responsive" src="{{url('/')}}/resources/assets/images/image_loading.gif"></div><div class="modal-footer text-center"></div>');
                $.ajax({
                    url:"<?=url('/')?>/modale/"+modal+"/"+dowhat+"/"+id,
                    method:"GET",
                    success:function(data) {
                        $('#ModalGeneral').modal('show');
                        $('#showModalContent').html(data);  
                    }
                });
            };
        });
    </script>
</body>
</html>
