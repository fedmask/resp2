@extends( 'layouts.fhir' )
@extends( 'includes.template_head' )

@section( 'pageTitle', 'FHIR PATIENT' )
@section( 'content' )

<?php 

$patients = $data_output;

?>
<!--PAGE CONTENT -->
        <div id="content"> <!--MODCN-->
            <div class="inner" style="min-height:800px;" >
                <div class="row">
                    <div class="col-lg-12" >
                        <div class="box dark">
                            <header>
                                <h2 style="color:#1d71b8;"> FHIR RESOURCE PATIENT </h2>
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
<!-- 
                                        <u class="text-primary">Importa paziente</u>
                                        <button id="upload_link" type="button" class="btn btn-primary btn-md btn-circle"><i class="glyphicon glyphicon-cloud-upload"></i></button>
      -->
                                    </div> <!-- panel-heading text-right -->
                                     <table class="table table-striped table-bordered table-hover" id="dataTables-elencopaz">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Surname</th>
                                                <th>Name</th>
                                                <th>Tax Code</th>
                                                <th>Birth Date</th>
                                                <th>Export</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                        @foreach($patients as $p)
                                        <td align="center">{{$p->id_paziente}}</td>
                                        <td align="center">{{$p->paziente_cognome}}</td>
                                        <td align="center">{{$p->paziente_nome}}</td>
                                        <td align="center">{{$p->paziente_codfiscale}}</td>
                                        <td align="center">{{date_format($p->paziente_nascita,"d-m-Y")}}</td>
                                        <td align="center"> <a href="http://localhost:8000/fhir/Patient/{{$p->id_paziente}}" download="RESP-PATIENT-{{$p->id_paziente}}.xml">
                    <i class="glyphicon glyphicon-cloud-download"></i></a></td>
                                        </tr>
                                        @endforeach
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