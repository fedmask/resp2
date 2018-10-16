<?php 

$narrative = $data_output["narrative"];
$extensions =  $data_output["extensions"];
$indagine = $data_output["indagine"];

?>


<?xml version="1.0" encoding="UTF-8"?>
<Observation xmlns="http://hl7.org/fhir">
  <id value="{{$indagine->getId()}}"/>
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

<!--Reason-->
  <extension url="http://resp.local/resources/extensions/Observation/observation-reason.xml">
    <valueString value="{{$extensions['Reason']}}"/>
  </extension>

<!--Type-->
  <extension url="http://resp.local/resources/extensions/Observation/observatio-type.xml">
    <valueString value="{{$extensions['Type']}}"/>
  </extension>

  <identifier>
    <use value="official"/>
    <system value="http://resp.local"/>
    <value value="{{$indagine->getId()}}"/>
  </identifier>
  
  <status value="{{$indagine->getStatus()}}"/>
  
  <category>
	<coding>
		<system value="http://hl7.org/fhir/observation-category"/>
		<code value="{{$indagine->getCategory()}}"/>
		<display value="{{$indagine->getCategoryDisplay()}}"/>
	</coding>
	    <text value="{{$indagine->getCategoryDisplay()}}"/>
  </category>
  
  <code>
    <coding>
      <system value="http://loinc.org"/>
      <code value="{{$indagine->getCode()}}"/>
      <display value="{{$indagine->getCodeDisplay()}}"/>
    </coding>
  </code>
  
  <subject>
    <reference value="RESP-PATIENT-{{$indagine->getIdPaziente()}}"/>
    <display value="{{$indagine->getPaziente()}}"/>
  </subject>
  
  <effectivePeriod>
    <start value="{{$indagine->getDataFine()}}"/>
  </effectivePeriod>
  
  <issued value="{{$indagine->getIssued()}}"/>
  
  <performer>
    <reference value="RESP-PRACTITIONER-{{$indagine->getIdCpp()}}"/>
    <display value="{{$indagine->getCpp()}}"/>
  </performer>
  
  <interpretation>
    <coding>
      <system value="http://hl7.org/fhir/v2/0078"/>
      <code value="{{$indagine->getInterpretation()}}"/>
      <display value="{{$indagine->getInterpretationDisplay()}}"/>
    </coding>
  </interpretation>

</Observation>