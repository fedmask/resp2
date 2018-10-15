@extends( 'layouts.fhir' )
@extends( 'includes.template_head' )

@section( 'pageTitle', 'FHIR CONDITION' )
@section( 'content' )

<?php 

$diagnosi = $data_output['diagnosi'];
$patient = $data_output['patient'];


?>
<link href="/css/resourcePatient.css" rel="stylesheet">
<script src="/js/formscripts/resourceCondition.js"></script>

<!--PAGE CONTENT -->

        <div id="content"> <!--MODCN-->
            <div class="inner" style="min-height:800px;" >
                <div class="row">
                    <div class="col-lg-12" >
                        <div class="box dark">
                            <header>
                                <h2 style="color:#1d71b8;"> FHIR RESOURCE CONDITION </h2>
                            </header> 
                            <div class="body">
                                <div class="table-responsive">
                                    <div class="panel-heading text-right">
                                        <div id="inputFile" style="display: none;">
                                            <form method="POST" action="/api/fhir/Condition" enctype="multipart/form-data">
                                            	{{ csrf_field() }}
                                                <input id="file" name="file" type="file" />
                                                <input hidden id="patient_id" name="patient_id" type="text" value="{{$patient->id_paziente}}" />
                                                <input id="import-file" type="submit" value="Import" class="btn btn-primary" disabled>
                                                <input id="import-annulla" type="button" value="Annulla" class="btn btn-default">
                                            </form>
                                        </div>
                                        <div id="inputFileUpdate"  style="display: none;">
                                      {{Form::open(array( 'id' => 'updateInputForm' , 'onsubmit' =>'updateInputForm()' ,'method' => 'PUT' ,'files'=>'true', 'enctype'=>'multipart/form-data'))}}
                                      {{ csrf_field() }}
                                      <input id="fileUpdate" name="fileUpdate" type="file" />
                                      <input hidden id="diagnosi_id" type="text" value="{{$current_user->id_utente}}" />
                                      {{Form::button('Upload',['id'=>'upload', 'type' => 'submit', 'class' => 'btn btn-primary', 'disabled'] )}}
                                      {{Form::button('Annulla',['id'=>'annulla', 'type' => 'button', 'class' => 'btn btn-default'] )}}
                                      {{Form::close()}} 
                                      
                                      </div>
                                        <u class="text-primary">Import Condition</u>
                                        <button id="upload-res"  onclick="openInputFile()" type="button" class="btn btn-primary btn-md btn-circle" ><i class="glyphicon glyphicon-cloud-upload"></i></button>
                                    </div> <!-- panel-heading text-right -->

<!-- DIV SHOW PATIENT -->
<div class="container">
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">SHOW CONDITION RESOURCE</h4>
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
        <button id="{{$patient->id_paziente}}" type="button" class="button-export1" >Export</button>
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
                                                <th>Code</th>
                                                <th>Severity</th>
                                                <th>Show</th>
                                                <th>Update</th>
                                                <th>Export</th>
                                                <th>Delete</th>
                                                </tr>                        
                                        </thead>
                                        <tbody>
                                        <tr>
                                        @foreach($diagnosi as $d)
                                        <td align="center">{{$d->getId()}}</td>
                                        <td align="center">{{$d->getCodeDisplay()}}</td> 
                                        <td align="center">{{$d->getSeverityDisplay()}}</td>
                                        <td align="center"> <button id="{{$d->getId()}}" type="button " class="button-show" ><i class="glyphicon glyphicon-eye-open"></i></button></td>
                                        <td align="center"><button id="{{$d->getId()}}" value="{{$d->getId()}}"  onclick="openInputFileUpdate(this.id)" type="button" class="button-update" ><i class="icon-cloud-upload"></button></td>
                                        <td align="center">
                                       <button id="" type="button " class="button-export" ><i class="icon-cloud-download"></i></button>                  
                                       </td>
                                        <td align="center">
                                       {{Form::open(array( 'action' => array('Fhir\Modules\FHIRCondition@destroy', $d->getId()) ,'method' => 'DELETE'))}}
                                      {{ csrf_field() }}
                                      <input hidden id="patient_id" name="patient_id" type="text" value="{{$patient->id_paziente}}" />
                                      {{Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'class' => 'button-delete'] )  }}
                                      {{Form::close()}} 
                                       </td>
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
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!--END PAGE CONTENT --> 

@endsection