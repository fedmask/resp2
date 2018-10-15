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

<?xml version="1.0" encoding="UTF-8"?>
<Patient xmlns="http://hl7.org/fhir"> 
<id value="{{$patient->id_paziente}}" /> 
<text> 
<status value="generated" />
<div xmlns="http://www.w3.org/1999/xhtml">
	<table border="2">
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
</text> 

<!-- Paziente donatore organi -->
<extension url="http://hl7.org/fhir/StructureDefinition/patient-cadavericDonor">
      <valueBoolean value="{{$donatore}}"/>
</extension>

<!--Codice Fiscale-->
<extension url="http://resp.local/resources/extensions/patient/codice-fiscale.xml">
   <valueString value="{{$codfis}}">
</extension> 

<!--Gruppo Sanguigno--> 
<extension url="http://resp.local/resources/extensions/patient/gruppo-sanguigno.xml"> 
   <valueString value="{{$grupposan}}">
</extension> 


<identifier> 
   <use value="official" /> 
   <system value="http://resp.local" /> 
   <value value="{{$patient->getID_Paziente()}}" /> 
</identifier>

<active value="{{$patient->isActive()}}" /> 

<name> 
   <use value="usual" /> 
   <family value="{{$patient->getSurname()}}" />
   <given value="{{$patient->getName()}}" /> 
</name> 

<telecom> 
   <system value="phone" /> 
   <value value="{{$patient->getPhone()}}" /> 
   <use value="home" /> 
   <rank value="1" /> 
</telecom> 

<telecom> 
   <system value="email" /> 
   <value value="{{$patient->getMail()}}" /> 
   <use value="home" /> 
</telecom> 

<gender	value="{{$patient->getGender()}}" /> 

<birthDate value="{{$patient->getBirth()}}"/> 

<deceasedBoolean value="{{$patient->getDeceased()}}" />

<address>
	<use value="home" />
	<line value="{{$patient->getLine()}}" />
	<city value="{{$patient->getCity()}}" />
	<state value="{{$patient->getCountryName()}}" />
	<postalCode value="{{$patient->getPostalCode()}}" />
</address>

<maritalStatus> 
   <coding> 
      <system value="http://hl7.org/fhir/v3/MaritalStatus" /> 
      <code value="{{$patient->getMaritalStatusCode()}}" /> 
      <display value="{{$patient->getMaritalStatusDisplay()}}" /> 
   </coding> 
</maritalStatus> 

@foreach($patient_contacts as $pc) 
<contact>
   <relationship>
      <coding> 
         <system value="http://hl7.org/fhir/v2/0131" /> 
         <code value="{{$pc->getRelationship()}}" />
      </coding> 
   </relationship> 
   <name> 
      <use value="official" /> 
      <family value="{{$pc->getSurname()}}" /> 
      <given value="{{$pc->getName()}}" /> 
   </name> 
   <telecom> 
      <system value="phone" />
      <value value="{{$pc->getTelephone()}}" /> 
      <use value="home" /> 
      <rank value="1" /> 
   </telecom> 
 <!--    <telecom>
      <system value="email" /> 
      <value value="{{$pc->getMail()}}" /> 
      <use value="home" /> 
   </telecom> -->
</contact> 
@endforeach

<communication>
   <language> 
      <coding> 
         <system value="urn:ietf:bcp:47" /> 
         <code value="{{$patient->paziente_lingua}}" /> 
      </coding> 
   </language> 
</communication> 

</Patient>