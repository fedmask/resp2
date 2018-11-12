<?php
// To simplify and reduce the dependence of the following code
// Data are passed by FHIRController
$narrative = $data_output["narrative"];
$relPers = $data_output["relPers"];
?>

<?xml version="1.0" encoding="UTF-8"?>
<RelatedPerson xmlns="http://hl7.org/fhir">
 <id value="{{$relPers->getId()}}"/>
  <text>

    <status value="generated"/>
    <div xmlns="http://www.w3.org/1999/xhtml">
      <table border="2">
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
    <use value="official"/>
    <system value="http://resp.local"/>
    <value value="{{$relPers->getId()}}"/>
  </identifier>

  <active value="{{$relPers->isActive()}}"/>

  <patient>
    <reference value="RESP-PATIENT-{{$relPers->getIdPaziente()}}"/>
  </patient>
  
  <relationship>
    <coding>
      <system value="http://hl7.org/fhir/v3/RoleCode"/>
      <code value="{{$relPers->getRelazioneCode()}}"/>
    </coding>
  </relationship>
  
  <name>
    <use value="official"/>
    <family value="{{$relPers->getCognome()}}"/>
    <given value="{{$relPers->getNome()}}"/>
  </name>

  <telecom>
    <system value="phone"/>
    <value value="{{$relPers->getTelefono()}}"/>
    <use value="home"/>
  </telecom>
  <telecom>
    <system value="email"/>
    <value value="{{$relPers->getMail()}}"/>
    <use value="home"/>
  </telecom>

	<gender value="{{$relPers->getSesso()}}"/>

  <birthDate value="{{$relPers->getDataNascita()}}"/>

</RelatedPerson>