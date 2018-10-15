<?php 

$narrative = $data_output["narrative"];
$anamnesi = $data_output["anamnesi"];
$condition = $data_output["condition"];
?>

<?xml version="1.0" encoding="UTF-8"?>
<FamilyMemberHistory xmlns="http://hl7.org/fhir">
  <id value="{{$anamnesi->getId()}}"/>
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
	<value value="{{$anamnesi->getId()}}"/>
  </identifier>

  <status value="{{$anamnesi->getStatus()}}"/>
  
  <patient>
    <reference value="RESP-PATIENT-{{$anamnesi->getPazienteId()}}"/>
    <display value="{{$anamnesi->getPaziente()}}"/>
  </patient>
  
  <name value="{{$anamnesi->getParente()}}"/>

  <relationship>
    <coding>
      <system value="http://hl7.org/fhir/v3/RoleCode"/>
      <code value="{{$anamnesi->getRelationshipCode()}}"/>
      <display value="{{$anamnesi->getRelationship()}}"/>
    </coding>
  </relationship>

<gender value="{{$anamnesi->getGender()}}"/>
  <bornDate value="{{$anamnesi->getBorn()}}"/>
  
    <deceasedBoolean value="{{$anamnesi->isDeceased()}}"/>
  
  <condition>
    <code>
    <coding>
      <system value="http://snomed.info/sct"/>
      <code value="{{$condition->getCode()}}"/>
      <display value="{{$condition->getCodeDisplay()}}"/>
    </coding>
    <text value="{{$condition->getCodeDisplay()}}"/>
    </code>
  
    <outcome>
    <coding>
      <system value="http://snomed.info/sct"/>
      <code value="{{$condition->getOutcome()}}"/>
      <display value="{{$condition->getOutcomeDisplay()}}"/>
    </coding>
    <text value="{{$condition->getCodeDisplay()}}"/>
    </outcome>
    
    <note>
      <text value="{{$condition->getNote()}}"/>
    </note>
  </condition>
  





</FamilyMemberHistory>