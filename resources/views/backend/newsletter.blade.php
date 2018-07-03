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
		        <h3>newsletter</h3>
		    </div>
		     <div class="col-xs-12 col-md-10">
		      	<table id="datatable_newsletter" class="display dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="hidden-xs hidden-sm">NUME</th>
                            <th class="hidden-xs hidden-sm">EMAIL</th>
                            <th class="hidden-xs hidden-sm">ACTIUNI</th>
                        </tr>
                    </thead>
                </table>
                <div id="pageInfo"></div>
                <script>
                    $(document).ready(function() {
                        var table = $('#datatable_newsletter').DataTable( {
                            "bLengthChange": true,
                            "bInfo": true,
                            "pageLength": 20,
                            "lengthMenu": [[20, 40, 60, 80, 100 -1], [20, 40, 60, 80, 100, "all"]],
                            "deferRender": false,
                            "cache": false,
                            "serverSide": true,
                            "language": {
                                "search": "",
                                "searchPlaceholder": "SEARCH..."
                            },            
                            "ajax": "<?=url('/')?>/datatables/newsletter",
                            "columns": [
                                { "data": "nume" },
                                { "data": "email" },
                                { "data": "actiuni" }
                            ],
                            "order": [],
                            "columnDefs": [     
                                { className: "no-sort xs-text-left sm-text-left img_an_mb", "targets": [ 0 ], "orderable": false }, 
                                { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 1 ], "orderable": false }, 
                                { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 2 ], "orderable": false }
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