@extends('layouts.app')
@extends('includes.template_head')

@section('pageTitle', 'Impostazioni Sicurezza')
@section('content')
<!--PAGE CONTENT -->
<div id="content">

            <div class="inner" style="min-height:1200px;">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Pannello di controllo</h2>
                        		<h3>Impostazioni di sicurezza</h3>
                    </div>
                </div>
                <hr />
                

		
			<!-- ACCESSI AL SISTEMA -->	
            <div class="row">
                <div class="col-lg-12">
                    <div class="box dark">
                        <header>
                        	<h5>Accessi al sistema</h5>
                        </header>
                        <div class="body">
                            <div class="table-responsive">
                                 <table class="table table-striped table-bordered table-hover" id="dataTables-accsistema">
                                    <thead>
                                        <tr>
                                            <th>Visitatore</th>
                                            <th>Ruolo</th>
                                            <th>Azione</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>  
                                    <tbody>
                                    	@foreach($logs as $log)
                                    		<tr>
                                    			<td>{{User::where('id_utente', $log->id_visitante)->first()->getName()}} {{User::where('id_utente', $log->id_visitante)->first()->getSurname()}}</td>
                                    			<td>{{User::where('id_utente', $log->id_visitante)->first()->getDescription()}}</td>
                                    			<td>{{$log->audit_nome}}</td>
                                    			<td><?php echo date('d/m/y', strtotime($log->audit_data)) ?></td>
                                    		</tr>
                                    	@endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<!-- FINE ACCESSI AL SISTEMA -->
            </div>
        </div>

<!--END PAGE CONTENT -->
@endsection