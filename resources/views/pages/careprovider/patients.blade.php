@extends( 'layouts.app' )
@extends( 'includes.template_head' )

@section( 'pageTitle', 'Pazienti' )
@section( 'content' )

<!--PAGE CONTENT -->
        <div id="content"> <!--MODCN-->
            <div class="inner" style="min-height:600px;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box dark">
                            <header>
                                <h2>Elenco Pazienti</h2>
                            </header> 
                            <div class="body">
                                <div class="table-responsive">
               
                                     <table class="table table-striped table-bordered table-hover" id="dataTables-elencopaz">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Registro</th>
                                                <th>Cognome</th>
                                                <th>Nome</th>
                                                <th>Codice Fiscale</th>
                                                <th>Report</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@foreach($patients as $patient)
                                        	<tr>
                                        		<td>{{$patient->id_paziente}}</td>
                                        		<td><button class='btn btn-default btn-success ' type = 'submit' onclick = 'APRIFINESTRA'><i class='icon-check'></i></button></td>
                                        		<td>{{$patient->user()->first()->getSurname()}}</td>
                                        		<td>{{$patient->user()->first()->getName()}}</td>
                                        		<td>{{$patient->user()->first()->getFiscalCode()}}</td>
                                        		<td><button class='btn btn-info ' onclick='EXPORTPDF'><i class='icon-book'></i></button></td>
                                        	</tr>
                                        	@endforeach
                                        	@empty($patients)
                                        		Nessun paziente presente.
                                        	@endempty
                                        </tbody>
                                    </table>
                                </div><!--table-responsive-->
                            </div ><!--body-->
                        </div><!--box dark-->
                    </div><!--class="col-lg-12-->
                </div><!--class="row"-->
            </div><!--class inner--->
        </div><!--nomenu-->
                    
            
    
    <!-- formscripts/admin.js da modificare con elencoPz.js-->
      <!--<script src="formscripts/admin.js"></script>-->
    <!-- MODCN -->
    <script src="formscripts/modcentercp.js"></script>
    <!-- Jquery Autocomplete -->
    <script src="assets/plugins/autocomplete/typeahead.bundle.js"></script>

    <!-- Script notifice tooltip -->
    <script src="formscripts/elencoPz.js"></script>

<!--END PAGE CONTENT --> 

@endsection