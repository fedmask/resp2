<?php 
$id_paz = $current_user->data_patient()->first()->id_paziente;
?>
<!-- MENU SECTION -->
<div id="left">
<div class="row" >
			<div class="well well-sm">
			</div>
						<div class="well well-sm">
			</div>

</div>
		<ul id="menu" class="collapse">
			<li class="panel" style="font-size:15px"> <a href="/fhirPatientIndex/{{$id_paz}}" > <em class="glyphicon glyphicon-user" ></em> Patient </a>
			</li>
			<li class="panel" style="font-size:15px"> <a href="/fhirPractitionerIndex/{{$id_paz}}"> <em class="icon-stethoscope"></em> Practitioner </a>
			</li>
			<li class="panel" style="font-size:15px"> <a href="/fhirRelatedPersonIndex/{{$id_paz}}"> <em class="icon-group"></em> Related Person </a>
			</li>
			<li class="panel" style="font-size:15px"> <a href="/fhirObservationIndex/{{$id_paz}}"> <em class="glyphicon glyphicon-eye-open"></em> Observation </a>
			</li>
			<li class="panel" style="font-size:15px"> <a href="/fhirImmunizationIndex/{{$id_paz}}"> <em class="icon-shield"></em> Immunization </a>
			</li>
			<li class="panel" style="font-size:15px"> <a href="/fhirEncounterIndex/{{$id_paz}}"> <em class="glyphicon glyphicon-map-marker"></em> Encounter </a>
			</li>
			<li class="panel" style="font-size:15px"> <a href="/fhirConditionIndex/{{$id_paz}}"> <em class="glyphicon glyphicon-search"></em> Condition </a>
			</li>
		<!--  	<li class="panel" style="font-size:15px"> <a href="/"> <em class="icon-hospital"></em> Organization </a>
			</li>
			<li class="panel" style="font-size:15px"> <a href="/"> <em class="glyphicon glyphicon-exclamation-sign"></em> Allergy Intollerance </a>
			</li>
			<li class="panel" style="font-size:15px"> <a href="/"> <em class="icon-file-text-alt"></em> Device </a>
			</li>
			<li class="panel" style="font-size:15px"> <a href="/"> <em class="icon-hospital"></em> Procedure </a>
			</li>
			<li class="panel" style="font-size:15px"> <a href="/"> <em class="icon-file-text-alt"></em> Medication </a>
			</li>-->
		</ul>
<!--END MENU SECTION -->
</div>
