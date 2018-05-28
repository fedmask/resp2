<?php
//To simplify and reduce the dependence of the following code
//Data are passed by FHIRController
$narrative       = $data_output['narrative'];
$visita    = 	$data_output['Visita'];
$paziente = $data_output['paziente'];
$cpp = $data_output['careproviders'];

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
  
  <!-- COMPLETARE -->
  <specialty>  <!--  -->
    <coding> 
      <system value="http://example.org/specialty"/> 
      <code value="gp"/> 
      <display value="General Practice"/> 
    </coding> 
  </specialty> 
  <!-- COMPLETARE -->
 
  <reason> 
    <coding> 
      <system value="reason"/> 
      <code value="{{$narrative->getMotivazione()}}"/> 
    </coding> 
  </reason> 
  <priority value="{{visita->getCodiceP()}}"/> 
  <start value="{{narrative ->getData()}}"/> 
  <extension url="http://resp.local/resources/extensions/appointment_observation.xml">
  	<valueString value="{{narrative->getOsservazione()}}" />
  </extension>
  <comment value="{{narrative->getConclusione()}}"/> 
 

  <participant>
  @foreach($paziente as $paz){ 
    <actor> 
      <reference value="Patient/$paz->getID_Paziente()"/> 
      <display value="$paz->getFullName()"/> 
    </actor>
    <required value="required"/> <?php //@TODO Continuare l'implementazione?>
    <status value="accepted"/> 
  @endforeach 
  @foreach($cpp as $cpp){ 
    <actor> 
      <reference value="CareProvider/$cpp->getID()"/> 
      <display value="$paz->getCpp_FullName()"/> 
    </actor>
    <required value="required"/> 
    <status value="accepted"/> 
  @endforeach 
  </participant> 
  <participant> 
    <type> 
      <coding> 
        <system value="http://hl7.org/fhir/v3/ParticipationType"/> 
        <code value="ATND"/> 
      </coding> 
    </type> 
    <actor> 
      <reference value="Practitioner/example"/> 
      <display value="Dr Adam Careful"/> 
    </actor> 
    <required value="required"/> 
    <status value="accepted"/> 
  </participant> 
  <participant> 
    <actor> 
      <reference value="Location/1"/> 
      <display value="South Wing, second floor"/> 
    </actor> 
    <required value="required"/> 
    <status value="accepted"/> 
  </participant> 
</Appointment> 
