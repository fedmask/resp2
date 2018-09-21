<?php
// To simplify and reduce the dependence of the following code
// Data are passed by FHIRController
$narrative = $data_output["narrative"];
/*$narrative_patient_contact = $data_output["narrative_patient_contact"];
$narrative_patient_language = $data_output["narrative_patient_language"];
$extensions = $data_output["extensions"];
$codfis = $extensions["codicefiscale"];
$grupposan = $extensions["grupposanguigno"];
$donatore = $extensions["donatoreorgani"];
$patient = $data_output["patient"];
$patient_contacts = $data_output["patient_contacts"];
$patient_languages = $data_output["patient_languages"];
*/
// $all_cpp = $data_output['careproviders'];
?>

<?xml version="1.0" encoding="UTF-8"?>
<Patient xmlns="http://hl7.org/fhir"> <id value="" /> <text> <status
	value="generated" />
<div xmlns="http://www.w3.org/1999/xhtml">
	<table>
		<tbody>
			@foreach($narrative as $key => $value)
			<tr>
				<td>{{$key}}</td>
				<td>{{$value}}</td>
			</tr>
			@endforeach 
			
	
		</tbody>
	</table>
</div>
</text> 

<identifier> 
   <use value="usual" /> 
   <system value="RESP-PATIENT" /> 
   <value value="" /> 
</identifier>

<active value="" /> 

<name> 
   <use value="usual" /> 
   <family value="" />
   <given value="" /> 
</name> 

<telecom> 
   <system value="phone" /> 
   <value value="" /> 
   <use value="home" /> 
   <rank value="1" /> 
</telecom> 

<telecom> 
   <system value="email" /> 
   <value value="" /> 
   <use value="home" /> 
</telecom> 

<gender	value="" /> 

<birthDate value=""> 

<deceasedBoolean value="" />

<address>
	<use value="home" />
	<line value="" />
	<city value="" />
	<state value="" />
	<postalCode value="" />
</address>

<maritalStatus> 
   <coding> 
      <system value="http://hl7.org/fhir/v3/MaritalStatus" /> 
      <code value="" /> 
      <display value="" /> 
   </coding> 
</maritalStatus> 

<contact>

   <relationship>
      <coding> 
         <system value="http://hl7.org/fhir/v2/0131" /> 
         <code value="" />
      </coding> 
   </relationship> 
   <name> 
      <use value="official" /> 
      <family value="" /> 
      <given value="" /> 
   </name> 
   <telecom> 
      <system value="phone" />
      <value value="" /> 
      <use value="home" /> 
      <rank value="1" /> 
   </telecom> 
   <telecom>
      <system value="email" /> 
      <value value="" /> 
      <use value="home" /> 
   </telecom>

</contact> 

<communication>

   <language> 
      <coding> 
         <system value="http://hl7.org/fhir/ValueSet/languages" /> 
         <code value="" /> 
         <display value="" /> 
      </coding> 
   </language> 

</communication> 



<!--Codice Fiscale-->
<extension url="http://resp.local/resources/extensions/patient/codice-fiscale.xml">
   <valueString value="">
</extension> 

<!--Gruppo Sanguigno--> 
<extension url="http://resp.local/resources/extensions/patient/gruppo-sanguigno.xml"> 
   <valueString value="">
</extension> 

<!--Donazione Organi--> 
<extension url="http://resp.local/resources/extensions/patient/donazione-organi.xml"> 
   <valueBoolean value="">
</extension>

</Patient>