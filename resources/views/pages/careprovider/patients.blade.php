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
                                    <div class="panel-heading text-right">
                                        <div style="display: none;">
                                            <form method="POST" action="#" enctype="multipart/form-data">
                                            	{{ csrf_field() }}
                                                <input id="upload_patient" type="file" />
                                                <input id="careprovider_id" type="text" value="{{$current_user->id_utente}}" />
                                            </form>
                                        </div>

                                        <u class="text-primary">Importa paziente</u>
                                        <button id="upload_link" type="button" class="btn btn-primary btn-md btn-circle"><i class="glyphicon glyphicon-cloud-upload"></i></button>
                                    </div> <!-- panel-heading text-right -->
                                     <table style ="font-size: 12"; class="table table-striped table-bordered table-hover" id="dataTables-elencopaz">
                                        <thead >
                                            <tr>
                                                <th>ID</th>
                                                <th>Registro</th>
                                                <th>Cognome</th>
                                                <th>Nome</th>
                                                <th>Codice Fiscale</th>
                                                <th>Telefono</th>
                                                <th>Mail</th>
                                                <th>Report</th>
                                                <th>Esporta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@foreach($patients as $patient)
                                        	<tr align="center">
                                        		<td>{{$patient->id_paziente}}</td>
                                        		<td><button class='btn btn-default btn-success ' type = 'submit' onclick = 'APRIFINESTRA'><i class='icon-check'></i></button></td>
                                        		<td style ="font-size: 14";><b>{{$patient->user()->first()->getSurname()}}</b></td>
                                        		<td style ="font-size: 14";><b>{{$patient->user()->first()->getName()}}</b></td>
                                        		<td>{{$patient->user()->first()->getFiscalCode()}}</td>
                                        		<td>{{$patient->user()->first()->getTelephone()}}</td>
                                        		<td>{{$patient->user()->first()->getEmail()}}</td>
                                        		<td><button class='btn btn-info ' onclick='EXPORTPDF'><i class='icon-book'></i></button></td>
                                        		<td><button class='btn btn-info' onclick=window.open('/formscripts/exportPatient.php?patientid={{$patient->id_utente}}')><i class='glyphicon glyphicon-cloud-download'></i></button></td>
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