@extends( 'layouts.app' )
@extends( 'includes.template_head' )

@section( 'pageTitle', 'Strutture' )
@section( 'content' )

<!--PAGE CONTENT -->
<!--PAGE CONTENT-->
            <div id="content"> <!--MODCN-->
                <div class="inner" style="min-height:600px;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box dark">
                                <header>
                                    <h2>Elenco Studi Diagnostici</h2>
                                </header>
                            <div class="body">    
                                <div class = "accordion ac" id="accordionStudi">
                                   <div class="accordion-group">
                                       <div class = "row">
                                           <div class="accordion-heading centered">
                                               <div class = "col-lg-12">
                                                   <div  class = "col-lg-4">
                                                       <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionStudi" href="#Mycenters">
                                                           <h3>I miei centri diagnostici
                                                               <span >
                                                                   <i  class="icon-angle-down"></i>
                                                                </span>
                                                           </h3>
                                                        </a>
                                                    </div>
                                               </div>   <!--col-lg-12-->
                                           </div><!--accordion heading centered-->
                                       </div><!--row--->
                                    </div><!--accordion group-->
                                    <div id="Mycenters" class="accordion-body collapse in">
                                        <div class = "row"><!--info-->
                                            <div class = "col-lg-12">
                                                <hr>
                                                <input  type="hidden" name="delcenter_hidden" id="delcenter_hidden" class="form-control col-lg-6" value="0"/>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <div class="panel-heading text-right">
                                                            <u class="text-primary">Nuovo Centro</u>
                                                            <button data-toggle="modal" data-target="#addcentermodal" id="addCenter" type="button" class="btn btn-primary btn-md btn-circle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-plus"></i></button>
                                                        </div> <!-- panel-heading text-right -->
                                                        <table class="table table-striped table-bordered table-hover" id="dataTables-elencostu">
                                                            <thead>
                                                                <tr>
                                                                    <th>Centro</th>
                                                                    <th>Sede</th>
                                                                    <th>Città</th>
                                                                    <th>Contatti</th>
                                                                    <th>Mail</th>
                                                                    <th>Tipologia</th>
                                                                    <th>Opzioni</th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($own_structures as $own_structure)
                                                                <tr>
                                                                    <td id='elencostu_{{$own_structure->id_centro}}_nome'>{{$own_structure->centro_nome}}</td>
                                                                    <td id='elencostu_{{$own_structure->id_centro}}_via'>{{$own_structure->centro_indirizzo}}</td>
                                                                    <td id='elencostu_{{$own_structure->id_centro}}_citta'>TODO</td>
                                                                    <td>
                                                                        <table>
                                                                            <tr>
                                                                                <td id='elencostu_{{$own_structure->id_centro}}_numa'>TODO </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td id='elencostu_{{$own_structure->id_centro}}_mail'>TODO</td>
                                                                    <td id='elencostu_{{$own_structure->id_centro}}_tipo'>TODO</td>
                                                                    <td><button class='btn btn-default btn-success editCenter' data-toggle='modal' data-target='#modcentermodal' value='{{$own_structure->id_centro}}' type='button' id='editCenter_{{$own_structure->id_centro}}' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'><i class='icon-pencil'></i></button><input  type='hidden' id='modvalcenter_hidden_{{$own_structure->id_centro}}' class='form-control col-lg-6' value='{{$own_structure->id_centro}}'/> <button value='{{$own_structure->id_centro}}'  id='removeCenter_{{$own_structure->id_centro}}' type='button' class='removeCenter buttonDelete btn btn-default btn-danger' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='icon-remove'></i></button></td>
                                                                </tr>
                                                                @endforeach
                                                                @empty($own_structures)
                                                                Nessun centro è associato.
                                                                @endempty
                                                        </tbody>
                                                    </table>
                                                    </div> <!--table-responsive-->
                                                </div><!-- panel body -->
                                            </div><!-- col lg 12 -->
                                        </div> <!-- row -->
                                    </div> <!-- colapse in -->
                                    <div class="accordion-group">
                                        <div class = "row"> 
                                            <div class="accordion-heading centered">
                                                <div class = "col-lg-12">   
                                                    <div  class = "col-lg-8">
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionStudi" href="#Fsemcenters">
                                                            <h3>I centri diagnostici del Registro Sanitario
                                                                <span>
                                                                    <i  class="icon-angle-down"></i>
                                                                </span>
                                                            </h3>
                                                        </a>
                                                    </div> <!-- col-lg-8 -->
                                                </div>  <!--col-lg-12-->
                                            </div><!--accordion heading centered-->
                                        </div><!--row--->   
                                    </div><!--accordion group-->
                                    <div id="Fsemcenters" class="accordion-body collapse">
                                        <div class = "row"><!--info-->
                                            <div class = "col-lg-12">
                                                <hr>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                       <table class="table table-striped table-bordered table-hover" id="dataTables-elencostuall">
                                                           <thead>
                                                               <tr>
                                                                   <th>Centro</th>
                                                                   <th>Sede</th>
                                                                   <th>Contatti</th>
                                                                   <th>Mail</th>
                                                                   <th>Messaggio FSEM</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($resp_structures as $structure )
                                                                <tr>
                                                                    <td>{{ $structure->centro_nome }}</td>
                                                                    <td>{{ $structure->centro_indirizzo }}</td>
                                                                    <td>
                                                                        <table>
                                                                            <tr>
                                                                                <td>TODO</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td><button class='btn btn-warning btn-mailCppSet' data-toggle='modal' data-target='#formModal' type= 'button' id = 'mailSet_{{$structure->id_centro}}' aria-haspopup= 'true' aria-expanded= 'true' value = '$j'><i class= 'icon-envelope'></i></button> TODO ALL MAIL</td>

                                                                    <td><a class='text-center' data-toggle='modal' data-target='#messageModal' href=''><button class='btn btn-default center-block'>TODO <i class='panel-title-icon fa icon_custom-chat'></i></button></td>
                                                                </tr>
                                                                @endforeach
                                                                @empty($resp_structures)
                                                                Nel fascicolo sanitario non è presente nessuno studio.
                                                                @endempty
                                                            </tbody>
                                                       </table>
                                                    </div><!--table-responsive-->
                                                </div><!-- panel body -->
                                            </div><!-- col lg 12 -->
                                        </div> <!-- row -->
                                    </div> <!-- collapse-->
                                </div>
                            </div ><!--body-->
                        </div><!--box dark-->
                    </div><!--class="col-lg-12-->
                </div><!--class="row"-->
            </div><!--class inner--->
        </div><!--content-->
<!-- MODALE MODIFICA STUDI CP -->                                         
        <div class="col-lg-12">
            <div class="modal fade" id="modcentermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudimodcenter">&times;</button>
                            <h4 class="modal-title" id="H2">Centro diagnostico</h4>
                        </div>
                        <form class="form-horizontal"  id="modcenter">
                            <div class="modal-body">
                                <!--center 1 -->
                                <div class="form-group">
                                    <label id="centerName" for="modnamecenter1" class="control-label col-lg-4" value="0">Nome studio n.:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="modnamecenter1" id="modnamecenter1" class="form-control col-lg-6" value=""/>
                                        <input  type="hidden" name="modnamecenter_hidden" id="modnamecenter_hidden" class="form-control col-lg-6" value="0"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modviacenter1" class="control-label col-lg-4">Via:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="modviacenter1" id="modviacenter1" class="form-control col-lg-6" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modcittacenter1" class="control-label col-lg-4">Città:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="modcittacenter1" id="modcittacenter1" class="form-control col-lg-6" value="/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modnumcenter1" class="control-label col-lg-4">Telefono:</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="modnumcenter1" id="modnumcenter1" class="form-control col-lg-6" value=""/>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="modnumacenter1" class="control-label col-lg-4">Telefono alternativo:</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="modnumacenter1" id="modnumacenter1" class="form-control col-lg-6" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modmailcenter1" class="control-label col-lg-4">Email:</label>
                                    <div class="col-lg-8">
                                        <input type="email" name="modmailcenter1" id="modmailcenter1" class="form-control col-lg-6" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modviacenter" class="control-label col-lg-4">Tipo centro:</label>
                                        <div class="col-lg-8">
                                            <select name="modtipocenter1" id="modtipocenter1" class="form-control col-lg-6" >
                                                <option value="">- < ?php echo $this->get_var('elencostu_1_tipo'); ?> - </option>
                                            </select>
                                        </div>
                                </div>
                                <hr>
                            </div> <!-- fine modal body -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                                <button type="submit" class="btn btn-primary">Salva</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div> <!-- end col-lg-12 -->
    <!--FINE MOD STUDI CP-->
    <!-- MODALE ADD STUDI CP -->
    <div class="col-lg-12">
       <div class="modal fade" id="addcentermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudiaddcenter">&times;</button>
                       <h4 class="modal-title" id="H2">Centro diagnostico</h4>
                   </div>
                   <form class="form-horizontal" method="POST" action="/addstructure" id="addcenter">
                    {{ csrf_field() }}
                       <div class="modal-body">
                           <div class="form-group">
                                <label for="modnamecenter_add" class="control-label col-lg-4">Nome sede:</label>
                                <div class="col-lg-8">
                                    <input type="text" name="structure_name" id="structure_name" class="form-control col-lg-6" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="modviacenter_add" class="control-label col-lg-4">Via:</label>
                                <div class="col-lg-8">
                                    <input type="text" name="structure_address" id="structure_address" class="form-control col-lg-6" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="modcitycenter_add" class="control-label col-lg-4">Città:</label>
                                <div class="col-lg-8">
                                    <input type="text" name="structure_city" id="structure_city" class="typeahead form-control col-lg-6"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="modtelcenter_add" class="control-label col-lg-4">Telefono:</label>
                                <div class="col-lg-8">
                                    <input type="text" name="structure_telephone" id="structure_telephone" class="form-control col-lg-6" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="modtelacenter_add" class="control-label col-lg-4">Telefono Alternativo:</label>
                                  <div class="col-lg-8">
                                      <input type="text" name="structure_second_telephone" id="structure_second_telephone" class="form-control col-lg-6" value=""/>
                                  </div>
                            </div>
                            <div class="form-group">
                                <label for="modmailcenter_add" class="control-label col-lg-4">Email:</label>
                                <div class="col-lg-8">
                                   <input type="email" name="structure_email" id="structure_email" class="form-control col-lg-6" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="modtipocenter_add" class="control-label col-lg-4">Tipo centro:</label>
                                <div class="col-lg-8">
                                <select name="structure_type" id="structure_type" class="form-control col-lg-6" >
                                    <option value="">Scegli il tipo di centro... </option>
                                    @foreach($structure_types as $type)
                                    <option value="{{$type->id_centro_tipologia}}">{{$type->tipologia_nome}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <hr>
                       </div> <!-- fine modal body -->
                       <div class="modal-footer">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                            <button type="submit" class="btn btn-primary">Salva</button> 
                       </div>
                   </form>
                </div> <!-- fine modal-content -->
           </div> <!-- modal-dialog -->
       </div> <!-- fine modal -->
    </div> <!-- col-lg-12 --> 
    <!--FINE ADD STUDI CP-->
    <!--MODAL EMAIL-->
    <div class="col-lg-12">
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="chiudiformmodalmail">&times;</button>
                        <h4 class="modal-title" id="H2">Nuova Email</h4>
                    </div>
                    <form class="form-horizontal"  id="patmailform">
                    <div class="modal-body">
                        <div class="form-group">
                           <!--il getvar deve prendere nome e cognome del medico-->
                           <label class="control-label col-lg-4">Da {{$current_user->getName()}} {{$current_user->getSurname()}} :</label>
                           <div class="col-lg-8">
                               <input type="text" name="nomeutente" id="nomeutente" value="" readonly class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">A :</label>
                            <div class="col-lg-8">
                                <input type="text" name="mail" id="mail" value="" readonly class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="oggettomail" class="control-label col-lg-4">Oggetto:</label>
                                <div class="col-lg-8">
                                    <input type="text" name="oggettomail" id="oggettomail" class="form-control col-lg-6"/>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="contenuto" class="control-label col-lg-4">Testo:</label>
                            <div class="col-lg-8">
                               <textarea name="contenuto" id="contenuto" class="form-control col-lg-6" rows="6"></textarea>
                            </div>
                        </div>
                    </div> <!-- fine modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-abort" data-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">Invia</button>
                    </div>
                    </form>
                </div> <!-- modal-content -->
            </div> <!-- modal-dialog -->
        </div> <!-- fine modal -->
    </div> <!-- col-lg-12 -->
    <!--  FINE MODAL EMAIL-->   
<!--END PAGE CONTENT --> 

@endsection