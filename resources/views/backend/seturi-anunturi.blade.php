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
		        <h3>Anunturile mele</h3>
		    </div>
		    <div class="col-xs-12 col-md-10">
		      	<table id="datatable_seturi_anunturi" class="display dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="no-sort img_an_mb" valing="top">IMG</th>
                            <th class="hidden-xs hidden-sm">MARCA & MODEL</th>
                            <th class="hidden-xs hidden-sm">ACTIUNI</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th class="hidden-xs hidden-sm">    
                                <select id="select_model" name="select_model">
                                    <option value="">Alege marca si model</option>
                                    <?
                                    foreach ($model_c as $model_r) {
                                        echo '<option value="'.$model_r->model.'">'.$model_r->marca.' '.$model_r->model.'</option>';
                                    }
                                    ?>
                                </select>                                   
                            </th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                <div id="pageInfo"></div>
                <script>
                    $(document).ready(function() {
                        var table = $('#datatable_seturi_anunturi').DataTable( {
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
                            "ajax": "<?=url('/')?>/datatables/seturi-anunturi",
                            "columns": [
                                { "data": "image" },
                                { "data": "marca" },
                                { "data": "actiuni" }
                            ],
                            "order": [],
                            "columnDefs": [     
                                { className: "no-sort xs-text-left sm-text-left img_an_mb", "targets": [ 0 ], "orderable": false }, 
                                { className: "no-sort hidden-xs hidden-sm", "targets": [ 1 ], "orderable": false }, 
                                { className: "no-sort hidden-xs hidden-sm", "targets": [ 2 ], "orderable": false },
                            ]
                        } );

                        table.columns(1).every( function () {
                            var that = this;
                            $( '#select_model', this.footer() ).on( 'keypress keyup change', function (e) {
                                that.search($(this).val()).draw();
                            });
                        } );
                        table.columns(2).every( function () {
                            var that = this;
                            $( '#select_piesa', this.footer() ).on( 'keypress keyup change', function (e) {
                                that.search($(this).val()).draw();
                            });
                        } );

                        $('#datatable_seturi_anunturi tfoot tr').appendTo('#datatable_seturi_anunturi thead');
                        $('#select_model').select2();
                    });
                </script>
                <br/>
                <br/>
                <br/>
		    </div>
	  	</div>
	</div>

@endsection