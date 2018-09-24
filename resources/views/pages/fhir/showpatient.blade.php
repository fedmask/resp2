<?php
// To simplify and reduce the dependence of the following code
// Data are passed by FHIRController
$narrative = $data_output["narrative"];
$narrative_patient_contact = $data_output["narrative_patient_contact"];
$extensions = $data_output["extensions"];
$codfis = $extensions["codicefiscale"];
$grupposan = $extensions["grupposanguigno"];
$donatore = $extensions["donatoreorgani"];
$patient = $data_output["patient"];
$patient_contacts = $data_output["patient_contacts"];
// $all_cpp = $data_output['careproviders'];
?>

<style>
  html, body {
    height: 100%;
  }
  #tableContainer-1 {
    height: 100%;
    width: 100%;
    display: table;
  }
  #tableContainer-2 {
    vertical-align: middle;
    display: table-cell;
    height: 100%;
  }
  #myTable {
    margin: 0 auto;
  }
  
  .button {
    position: absolute;
    top: 50%;
}
  
</style>

<div id="tableContainer-1">
  <div id="tableContainer-2">
	<table id="myTable" border>
		<tbody>
			@foreach($narrative as $key => $value)
			<tr>
				<td>{{$key}}</td>
				<td>{{$value}}</td>
			</tr>
			@endforeach 
			
			@foreach($narrative_patient_contact as $key => $value)
			<tr>
				<td>{{$key}}</td>
				<td>{{$value}}</td>
			</tr>
			@endforeach 
			
			@foreach($extensions as $key => $value)
			<tr>
				<td>{{$key}}</td>
				<td>{{$value}}</td>
			</tr>
			@endforeach
	
		</tbody>
		
	</table>
	</div>