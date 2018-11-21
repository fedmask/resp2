 @extends('pages.Administration.app_Admin') @section('content')
@include('pages.Administration.modalRegisterActivityAdmin')




<meta name="csrf-token" content="{{ csrf_token() }}">


<div id="content">
	<div class="inner" style="min-height: 1200px;">
		<br>
		<h2>Gestione amministrazione</h2>
		<button class="btn1" style="width: 100%" data-toggle="modal"
			data-target="#myModalRegisterOP">
			<i class="fa fa-floppy-o"></i> Registra Operazione su un Utente
		</button>


		<br>
		<hr>
		<button class="btn1" style="width: 100%" data-toggle="modal"
			data-target="#myModalRegisterOPA">
			<i class="fa fa-floppy-o"></i> Registra Operazione Amministrativa
		</button>

<hr>

@if($current_administrator->Ruolo == 'Responsabile al Trattamento' || $current_administrator->Ruolo == 'Amministratore_di_sistema')
		<button class="btn2" style="width: 100%" data-toggle="modal"
			data-target="#myModalRegisterAdmin">
			<i class="fa fa-address-card-o"></i> Registra Nuovo Amministratore
		</button>


		<div class="modal fade" id="myModalRegisterAdmin" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"><h3>Registra nuovo Amministratore</h3></div>

					<div class="modal-body">

						
						{{ Form::open(['url' => '/administration/AdminCreate']) }}

						{{ csrf_field() }}	
						<div class="form-group">
							
						
						
								<label for="userName" class="control-label col-lg-3">Username*</label>
								<input id="userName" name="username" type="text" class="form-control">
								@if ($errors->has('username'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('username') }}</div>
									@endif
								
							<br>

							
								<label for="email" class="control-label col-lg-3">Email*</label>
								<input id="email" name="email" type="email" class="form-control">
									@if ($errors->has('email'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('email') }}</div>
									@endif
								<br>
								<label for="confirmEmail" class="control-label col-lg-5">Conferma Email*</label>
								 <input id="confirmEmail" name="confirmEmail" type="email" class="form-control">
									@if ($errors->has('confirmEmail'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('confirmEmail') }}</div>
									@endif
								
							<br>

							
								<label for="password" class="control-label col-lg-5">Password*</label>
								 <input id="password" name="password" type="password" class="form-control" placeholder="almeno 8 caratteri tra cui una cifra">
									@if ($errors->has('password'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('password') }}</div>
									@endif
								<br>
								<label for="confirmPassword" class="control-label col-lg-5">Conferma Password*</label>
								 
									<input id="confirmPassword" name="confirmPassword" type="password" class="form-control">
									@if ($errors->has('confirmPassword'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('confirmPassword') }}</div>
									@endif
								<br>
							

						
								<label for="surname" class="control-label col-lg-3">Cognome*</label>
								 <input id="surname" name="surname" type="text" class="form-control">
									@if ($errors->has('surname'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('surname') }}</div>
									@endif
								<br>
								<label for="name" class="control-label col-lg-3">Nome*</label>
								 <input id="name" name="name" type="text" class="form-control">
									@if ($errors->has('name'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('name') }}</div>
									@endif
								
							<br>
<div>
							
								<label for="gender" class="control-label col-lg-3">Sesso*</label>
								 
									<label class="radio-inline">
										<input  type="radio"  name="gender" id="genderM" value="M">M
									</label>
									<label class="radio-inline">
										<input  type="radio"  name="gender" id="genderF" value="F">F
                                    </label>
                                    @if ($errors->has('gender'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('gender') }}</div>
									@endif
						</div>			
									<br>
						
	
								<label for="birthCity" class="control-label col-lg-5">Comune di nascita*</label>
								 <input id="birthCity" name="birthCity" type="text" class="typeahead form-control">
									@if ($errors->has('birthCity'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('birthCity') }}</div>
									@endif
								<br>
								<label for="birthDate" class="control-label col-lg-5">Data di nascita*</label>
								{{Form::date('birthDate','', ['id'=>"birthDate", 'name'=>"birthDate", 'class' => 'form-control col-lg-6'])}}
								 	
								 	@if ($errors->has('birthDate'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('birthDate') }}</div>
									@endif
								
						<br>
						<br>
						<br>
						<br>
						
								<label for="livingCity" class="control-label col-lg-5">Comune di residenza*</label>
								 <input id="livingCity" name="livingCity" type="text" class="typeahead form-control">
									@if ($errors->has('livingCity'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('livingCity') }}</div>
									@endif
								<br>
								<label for="address" class="control-label col-lg-5">Via/Corso/Piazza*</label>
								 <input id="address" name="address" type="text" class="form-control">
									@if ($errors->has('address'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('address') }}</div>
									@endif
								
							
<br>
							
								<label for="telephone" class="control-label col-lg-5">Recapito telefonico*</label>
								 
									<input id="telephone" name="telephone" type="tel" class="form-control">
									@if ($errors->has('telephone'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('telephone') }}</div>
									@endif
								<br>
<label for="telephone" class="control-label col-lg-5">Ruolo Amministratore*</label>

<div allign="left">
{{ Form::select('Ruolo', array('DPO' => 'DPO', 'Responsabile al Trattamento' => 'Responsabile al Trattamento','Personale di Supporto' => 'Personale di Supporto','Amministratore_di_sistema' =>
								'Amministratore_di_sistema'))}}
</div>

							
<br>
							
								<label for="tipodati" class="control-label col-lg-5">Tipo di dati trattati*</label> <input id="TypeData" name="TypeData" type="tel"
								class="form-control"> @if ($errors->has('telephone'))
    									<div class="alert alert-danger" role="alert">{{ $errors->first('TypeData') }}</div>
									@endif
								<br>



							
								</div>
								
							<p class="pull-right">(*) Campi obbligatori</p>
				
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"
							onclick="window.location.reload()";>Annulla</button>
						{{ Form::submit('Salva', ['class' => 'btn btn-primary'])}}
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>


<hr>

@if($current_administrator->Ruolo != 'Amministratore_di_sistema')
<div align="center">

				<button type="button" style="width: 100%" class="btn3" data-toggle="modal"
					style="font-size: 16" data-target="#myModalCancel">
					<i class="fa fa-bitbucket"></i> Cancella Account Amministrativo
				</button>
			</div>

			<div class="modal fade" id="myModalCancel" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">Elimina Account Amministrativo</div>

						<div class="modal-body">

							{{ Form::open(['url' => '/administration/AdminDelete'])
							}}
							<div class="form-group">{{ Form::label('Id_Utente', 'ID Amministratore') }} {{ Form::text('Id_Admin2', null, ['class' =>
								'form-control']) }}</div>


							{{ Form::submit('Cancella', ['class' => 'btn btn-success']) }} {{
							Form::close() }}
						</div>
					</div>
				</div>
			</div>

@endif

@endif






<br>
		<h2>Amministratori Registrati</h2>
		<br> <input type="text" id="myInput1" onkeyup="myFunction1()" style="width: 100%"
			placeholder="Ricerca per Cognome..." title="Inserisci un cognome">

		<table id="tableP1" style="width: 100%">
			<tr   

			
			class="header">
			<th>#ID</th>
			<th>Cognome</th>
			<th>Nome</th>
			<th>Ruolo</th>



			</tr>

			@foreach($Admin as $activity)


			<tr>


				<td allign="center">{{$activity->id_utente}}</td>
				<td>{{$activity->Cognome}}</td>
				<td>{{$activity->Nome}}</td>
				<td>{{$activity->Ruolo}}</td>

			</tr>
			
			@endforeach
		</table>




<br>
		<h2>Attivita' registrate</h2>
		<br> <input type="text" id="myInput2" onkeyup="myFunction2()" style="width: 100%"
			placeholder="Ricerca per Tipologia..." title="Inserisci una tipologia">

		<table id="tableP2" style="width: 100%">
			<tr   

			
			class="header">
			<th>#ID</th>
			<th>#ID Utente</th>
			<th>Inizio</th>
			<th>Fine</th>
			<th>Tipologia_attivita</th>
			<th>Descrizione</th>
			<th>Anomalie_riscontrate</th>


			</tr>

			@foreach($Activitys as $activity)


			<tr>


				<td allign="center">{{$activity->id_attivita}}</td>
				<td>{{$activity->id_utente}}</td>
				<td>{{$activity->Start_Period}}</td>
				<td>{{$activity->End_Period}}</td>
				<td> <?php echo $activity->Tipologia_attivita ?></td>
				<td> <?php echo $activity->Descrizione ?> </td>
				<td> <?php echo $activity->Anomalie_riscontrate ?> </td>
				

			</tr>
			
			@endforeach
		</table>








	</div>
	
	
	
	
	
	
	
	
</div>


			<script>


function myFunction1() {
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput1");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("tableP1");
	  tr = table.getElementsByTagName("tr");
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[1];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    }       
	  }
	}


function myFunction2() {
		  var input, filter, table, tr, td, i;
		  input = document.getElementById("myInput2");
		  filter = input.value.toUpperCase();
		  table = document.getElementById("tableP2");
		  tr = table.getElementsByTagName("tr");
		  for (i = 0; i < tr.length; i++) {
		    td = tr[i].getElementsByTagName("td")[4];
		    if (td) {
		      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
		        tr[i].style.display = "";
		      } else {
		        tr[i].style.display = "none";
		      }
		    }       
		  }
		}


</script>



<!--END PAGE CONTENT -->
@endsection
