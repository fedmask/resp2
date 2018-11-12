<?php 

$narrative = $data_output["narrative"];
$narrative_participant = $data_output["narrative_participant"];
$visita = $data_output["visita"];
$participant = $data_output["participant"];
$extensions =  $data_output["extensions"];
?>

<?xml version="1.0" encoding="UTF-8"?>
<Encounter xmlns="http://hl7.org/fhir">
  <id value="{{$visita->getId()}}"/>
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
			
			@foreach($narrative_participant as $key => $value)
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
  	
  	<!--Altra Motivazione-->
  <extension url="http://resp.local/resources/extensions/Encounter/encounter-altra-motivazione.xml">
    <valueString value="{{$extensions['AltraMotivazione']}}"/>
  </extension>

<!--Osservazioni-->
  <extension url="http://resp.local/resources/extensions/Encounter/encounter-osservazioni.xml">
    <valueString value="{{$extensions['Osservazioni']}}"/>
  </extension>
  
  <!--Conclusioni-->
  <extension url="http://resp.local/resources/extensions/Encounter/encounter-conclusioni.xml">
    <valueString value="{{$extensions['Conclusioni']}}"/>
  </extension>

    <identifier>
        <use value="official"/>
        <system value="http://resp.local"/>
        <value value="{{$visita->getId()}}"/>
    </identifier>
    
    <status value="{{$visita->getStatus()}}"/>
    
    <class>
        <system value="http://hl7.org/fhir/v3/ActCode"/>
        <code value="{{$visita->getClass()}}"/> <!--   outpatient   -->
        <display value="{{$visita->getClassDisplay()}}"/>
    </class>
	
	<subject>
        <reference value="RESP-PATIENT-{{$visita->getIdPaziente()}}"/>
        <display value="{{$visita->getPaziente()}}"/>
    </subject>
    
        @foreach($participant as $p)
    <participant>
         <type>
            <coding>
                <system value="http://hl7.org/fhir/v3/ParticipationType"/>
                <code value="{{$p->getType()}}"/>
            </coding>
        </type>
        <period>
            <start value="{{$p->getStartPeriod()}}"/>
            <end value="{{$p->getEndPeriod()}}"/>
        </period>
        <individual>
            <reference value="RESP-PRACTITIONER-{{$p->getIndividualId()}}"/>
            <display value="{{$p->getIndividual()}}"/>
        </individual>
    </participant>
@endforeach
	
    <period>
        <start value="{{$visita->getStartPeriod()}}"/>
        <end value="{{$visita->getEndPeriod()}}"/>
    </period>

    <reason>
        <coding>
            <system value="http://snomed.info/sct"/>
            <code value="{{$visita->getReason()}}"/>
            <display value="{{$visita->getReasonDisplay()}}"/>
        </coding>
    </reason>
    



</Encounter>