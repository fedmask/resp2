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
                                        <div id="inputFile" style="display: none;">
                                            <form method="POST" action="/api/fhir/Patient" enctype="multipart/form-data">
                                            	{{ csrf_field() }}
                                                <input name="file" type="file" />
                                                <input hidden id="careprovider_id" type="text" value="{{$current_user->id_utente}}" />
                                                <input type="submit" value="Upload File">
                                            </form>
                                        </div>
                                        
                                        <div id="inputFileUpdate" style="display: none;">
                                      {{Form::open(array( 'id' => 'updateInputForm' , 'onsubmit' =>'updateInputForm()' ,'method' => 'PUT' ,'files'=>'true', 'enctype'=>'multipart/form-data'))}}
                                      {{ csrf_field() }}
                                      <input name="fileUpdate" type="file" value="PUT"/>
                                      <input hidden id="patient_id" type="text" value="{{$current_user->id_utente}}" />
                                      {{Form::submit('Upload File')}}
                                      {{Form::close()}} 
                                      
                                      </div>
                                        <u class="text-primary">Import Patient</u>
                                        <button id="upload-res" onclick="openInputFile()" type="button" class="btn btn-primary btn-md btn-circle" ><i class="glyphicon glyphicon-cloud-upload"></i></button>
                                    
                                    <script>

                                    function updateInputForm(){

                                        var action = document.getElementById("updateInputForm").action;
                                        document.getElementById("updateInputForm").action = "/api/fhir/Patient/"+document.getElementById("patient_id").value;
                                    	
                                    }

                                    function openInputFile(){
                                    document.getElementById("inputFile").hidden=false;
                                    document.getElementById("inputFile").style.display='block';
                                    }

                                    function openInputFileUpdate(id){
                                        document.getElementById("inputFileUpdate").hidden=false;
                                        document.getElementById("inputFileUpdate").style.display='block';
                                        document.getElementById("patient_id").value = id;
                                        
                                        }


                                    
                                    </script>
                                    
                                    <style>
                                    
                                    
                                    .icon-cloud-download {
                                    	  color: white;
                                    	}
                                    	
                                    .icon-trash {
                                    	  color: white;
                                    	}
                                    
                                    </style>
                                    
                                    
                                    </div> <!-- panel-heading text-right -->
                                     <table class="table table-striped table-bordered table-hover" id="dataTables-elencopaz">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Surname</th>
                                                <th>Name</th>
                                                <th>Birth Date</th>
                                                <th>Show</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                                <th>Export</th>
                                            </tr>                        
                                        </thead>
                                        <tbody>
                                        <tr>
                                        @foreach($patients as $p)
                                        <td align="center">{{$p->id_paziente}}</td>
                                        <td align="center">{{$p->paziente_cognome}}</td>
                                        <td align="center">{{$p->paziente_nome}}</td>
                                        <td align="center">{{date_format($p->paziente_nascita,"d-m-Y")}}</td>
                                        <td align="center"> <a target="blank" href="http://localhost:8000/api/fhir/Patient/{{$p->id_paziente}}"><button type="button" class="btn btn-primary btn-md btn-circle" ><i class="glyphicon glyphicon-eye-open"></i></button></a>  </td>
                                        <td align="center"><button id="{{$p->id_paziente}}" value="{{$p->id_paziente}}"  onclick="openInputFileUpdate(this.id)" type="button" class="btn btn-primary btn-md btn-circle" ><i class="icon-cloud-upload"></button></td>
                                        <td align="center">
                                      {{Form::open(array( 'action' => array('Fhir\Modules\FHIRPatient@destroy', $p->id_paziente) ,'method' => 'DELETE' ,'files'=>'true', 'enctype'=>'multipart/form-data'))}}
                                      {{ csrf_field() }}
                                      {{Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-primary btn-md btn-circle'] )  }}
                                      {{Form::close()}}                          
                                       </td>
                                        <td align="center"><button type="button" class="btn btn-primary btn-md btn-circle" > <a href="http://localhost:8000/api/fhir/Patient/{{$p->id_paziente}}" download="RESP-PATIENT-{{$p->id_paziente}}.xml">
                                        <i class="icon-cloud-download"></i></a></button></td>
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