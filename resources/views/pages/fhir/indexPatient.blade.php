@extends( 'layouts.fhir' )
@extends( 'includes.template_head' )

@section( 'pageTitle', 'FHIR PATIENT INDEX' )
@section( 'content' )

<?php 

$patient = $data_output;

?>
<link href="/css/resourcePatient.css" rel="stylesheet">
<script src="/js/formscripts/resourcePatient.js"></script>

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
                                    

<!-- DIV SHOW PATIENT -->
<div class="container">
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">SHOW PATIENT RESOURCE</h4>
        </div>
        <div class="modal-body" >
        </div>
        <div class="modal-footer">
          <a class="link-export" >Export</a>
          </div>
      </div>
      
    </div>
  </div>
  
</div>
<!-- END DIV SHOW PATIENT -->

<!-- DIV EXPORT -->
<div class="container">
    <!-- Modal -->
  <div class="modal fade" id="myModalExport" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">SELECT RESOURCES</h4>
        </div>
        <div class="modal-body" >
        </div>
        <div class="modal-footer">
          <!--  <a class="link-export" >Export</a>-->
          <button id="{{$patient->id_paziente}}" type="button" class="button-export1">Export</button>
          </div>
      </div>
      
    </div>
  </div>
  
</div>
<!-- END DIV EXPORT -->

                                    
                                     <table class="table table-striped table-bordered table-hover" id="dataTables-elencopaz">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Surname</th>
                                                <th>Name</th>
                                                <th>Birth Date</th>
                                                <th>Tax Code</th>
                                                <th>Show</th>
                                                <th>Update</th>
                                                <th>Export</th>
                                         <!--  <th>Delete</th>-->
                                                </tr>                        
                                        </thead>
                                        <tbody>
                                        <tr>
                                        <td align="center">{{$patient->id_paziente}}</td>
                                        <td align="center">{{$patient->paziente_cognome}}</td>
                                        <td align="center">{{$patient->paziente_nome}}</td>
                                        <td align="center">{{date_format($patient->paziente_nascita,"d-m-Y")}}</td> <!--  data-toggle="modal" data-target="#myModal" href="http://localhost:8000/api/fhir/Patient/{{$patient->id_paziente}}" -->
                                        <td align="center">{{$patient->paziente_codfiscale}}</td>
                                        <td align="center"> <button id="{{$patient->id_paziente}}" type="button " class="button-show" ><i class="glyphicon glyphicon-eye-open"></i></button></td>
                                        <td align="center"><button id="{{$patient->id_paziente}}" value="{{$patient->id_paziente}}"  onclick="openInputFileUpdate(this.id)" type="button" class="button-update" ><i class="icon-cloud-upload"></button></td>
                                 <!--   <td align="center">
                                      {{Form::open(array( 'action' => array('Fhir\Modules\FHIRPatient@destroy', $patient->id_paziente) ,'method' => 'DELETE' ,'files'=>'true', 'enctype'=>'multipart/form-data'))}}
                                      {{ csrf_field() }}
                                      {{Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'class' => 'button-delete'] )  }}
                                      {{Form::close()}}                          
                                       </td> -->
                                       
                                       <td align="center"> 
                                       <button id="{{$patient->id_paziente}}" type="button " class="button-export" ><i class="icon-cloud-download"></i></button>
                                      
                                       </td>
                                       
                                       
                                        </tr>
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
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!--END PAGE CONTENT --> 

@endsection