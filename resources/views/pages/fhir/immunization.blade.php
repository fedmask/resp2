<?php 

$narrative = $data_output["narrative"];
$vaccinazione = $data_output["vaccinazione"];
?>

<?xml version="1.0" encoding="UTF-8"?>
<Immunization xmlns="http://hl7.org/fhir">
	<id value="{{$vaccinazione->getId()}}"/>
	
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
		<system value="http://resp.local"/>
		<value value="{{$vaccinazione->getId()}}"/>
	</identifier>
	
	<status value="{{$vaccinazione->getStato()}}"/>
	
	<notGiven value="{{$vaccinazione->getNotGiven()}}"/>
	
	<vaccineCode>
		<coding>
			<system value="urn:oid:1.2.36.1.2001.1005.17"/>
			<code value="{{$vaccinazione->getVaccineCode()}}"/>
		</coding>
		<text value="{{$vaccinazione->getVaccineCodeDisplay()}}"/>
	</vaccineCode>
	
	<patient>
		<reference value="RESP-PATIENT-{{$vaccinazione->getIdPaziente()}}"/>
	</patient>
	
	<date value="{{$vaccinazione->getData()}}"/>
	
	<primarySource value="{{$vaccinazione->getPrimarySource()}}"/>
	
	<route>
		<coding>
			<system value="http://hl7.org/fhir/v3/RouteOfAdministration"/>
			<code value="{{$vaccinazione->getRoute()}}"/>
			<display value="{{$vaccinazione->getRouteDisplay()}}"/>
		</coding>
	</route>
	
	<doseQuantity>
		<value value="{{$vaccinazione->getQuantity()}}"/>
		<system value="http://unitsofmeasure.org"/>
		<code value="mg"/>
	</doseQuantity>
	
	<practitioner>
		<role>
			<coding>
				<system value="http://hl7.org/fhir/v2/0443"/>
				<code value="{{$vaccinazione->getCppRole()}}"/>
			</coding>
		</role>
    		<actor>
     			<reference value="RESP-PRACTITIONER-{{$vaccinazione->getIdCpp()}}"/>
    		</actor>
	</practitioner>
	
	<note>
		<text value="{{$vaccinazione->getNote()}}"/>
	</note>

</Immunization>