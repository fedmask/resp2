<?php
//To simplify and reduce the dependence of the following code
//Data are passed by FHIRController
$narrative       = $data_output['narrative'];
$visita    = 	$data_output['Visita'];
$paziente = $data_output['paziente'];
$cpp = $data_output['careprovider'];
$specialization = $data_output ["specialization"];
?>


<?xml version="1.0" encoding="utf-8"?>
<Appointment xmlns="http://hl7.org/fhir">
  <id value="{{$visita->getID()}}"/> 
  <text> 
    <status value="generated"/> 
    <div xmlns="http://www.w3.org/1999/xhtml">
    	<table border="2">
        <tbody>
        @foreach($narrative as $key => $value)
		<tr>
			<td>{{$key}}</td>
			<td>{{$value}}</td></tr>
        @endforeach
        </tbody>
      </table>
    </div> 
  </text> 
  <status value="{{$narrative->getStato()}}"/> 
  @foreach($specialization as $spec)
  <specialty>  <!--  -->
    <coding> 
      <system value="http://example.org/specialty"/> 
      <code value="gp"/> 
      <display value="{{$spec->getDesc()}}"/> 
    </coding> 
  </specialty> 
  @endforeach
  <reason> 
    <coding> 
      <system value="reason"/> 
      <code value="{{$narrative->getMotivazione()}}"/> 
    </coding> 
  </reason> 
  <priority value="{{$visita->getCodiceP()}}"/> 
  <start value="{{$narrative ->getData()}}"/> 
  <extension url="http://resp.local/resources/extensions/appointment_observation.xml">
  	<valueString value="{{$narrative->getOsservazione()}}" />
  </extension>
  <comment value="{{$narrative->getConclusione()}}"/> 
  <participant>
    <actor> 
      <reference value="Patient/$paz->getID_Paziente()"/> 
      <display value="$paz->getFullName()"/> 
    </actor>
    <required value="{{$visita->get0esta()}}"/> 
    <status value="{{$visita->getStatus()}}"/> 
    <actor> 
      <reference value="CareProvider/$cpp->getID()"/> 
      <display value="$cpp->getCpp_FullName()"/> 
    </actor>
    <required value="{{$visita->getTRichiesta()}}"/> 
    <status value="{{$visita->getStatus()}}"/> 
  </participant> 
  @if(!($visita->getRichiestaVI()==null))
  <requestedPeriod> 
    <start value="{{$visita->getRichiestaVI()}}"/> 
    <end value="{{$visita->getRichiestaVF()}}"/> 
  </requestedPeriod> 
  @endif 
</Appointment> 
