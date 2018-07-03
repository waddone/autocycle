@extends('layouts.frontend.app')
@section('content')
    <div class="container-fluid NormalPageColor">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1X">
                <h1><i class="fas fa-envelope"></i> Contact</h1>
                @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                Contact - Autocycle
                <br/><br/>
            </div>
        </div>
    </div>
    <div class="container NormalPageWhite">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <p class="titlecontact"><b>SC Auto Cycle SRL</b></p>
                        <p class="rest"><i class="fas fa-location-arrow"></i> &nbsp; Strada Dacia, Pucioasa 135400<br/> Dambovita</p>
                        <p class="rest">
                            <a href="tel:+40721186386" title="vezi toate piesele" class="btn HomeSubmit"><i class="fas fa-phone"></i>  &nbsp; 0721 186 386</a></br></br>
                            <a href="tel:+40726369949" title="vezi toate piesele" class="btn HomeSubmit"><i class="fas fa-phone"></i>  &nbsp; 0726 369 949</a></br></br>
                            <a href="tel:+40770406076" title="vezi toate piesele" class="btn HomeSubmit"><i class="fas fa-phone"></i>  &nbsp; 0770 406 076</a></br></br>
                            </br></br>
                        </p>
                        <br>
                        <p class="rest"><i class="fas fa-phone"></i> &nbsp; <script type="text/javascript">eTd('autocycle.ro', 'office');</script>
                        </p>
                    </div>
                    <div class="col-xs-12 col-md-8">
                        <form action="{{ url('contact') }}" method="POST" class="form-horizontal">
                            {{ csrf_field() }}
                            <!-- Task Name -->
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="contact-name" class="control-label">NUME * : </label>
                                    <input type="text" name="name" id="contact-name" class="form-control" value="{{old('name')}}" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="contact-email" class="control-label">EMAIL * : </label>
                                    <input type="text" name="email" id="contact-email" class="form-control" value="{{old('email')}}" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="contact-phone" class="control-label">TELEFON * : </label>
                                    <input type="text" name="phone" id="contact-phone" class="form-control" value="{{old('phone')}}" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="contact-description" class="control-label">Text * :</label>
                                    <textarea class="form-control" rows='5' name="description" id="contact-description" value="">{{old('description')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <br/>
                                    <button type="submit" class="btn btn-primary">
                                        TRIMITE !
                                    </button>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>      
            </div>
        </div>
    </div>
@endsection