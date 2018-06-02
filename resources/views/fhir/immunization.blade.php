<?php 
//To simplify and reduce the dependence of the following code
//Data are passed by FHIRController
$vaccinazione = $data_output['immunization'];
$narrative  = $data_output["narrative"];
$pazienti   = $data_output["pazienti"];
$extensions   = $data_output['extensions'];
$all_cpp    = $data_output['careprovider'];
$vaccini= $data_output['vaccini'];
$reactions = $data_output['reactions'];
?>

<?xml version="1.0" encoding="utf-8"?>

<Immunization xmlns="http://hl7.org/fhir">
  <id value="{{$vaccinazione->getID()}}"/> 
  
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
  <status value="{{$narrative['Vaccinazione Stato']}}"/> 
  <notGiven value="false"/> 
  <?php //@TODO Implementare i codici ATC ?>
  <vaccineCode> 
    <coding> 
      <system value="urn:oid:1.2.36.1.2001.1005.17"/> 
      <code value="FLUVAX"/> 
    </coding>
    
    <text value="Fluvax (Influenza)"/> 
  </vaccineCode> 
  <?php ?>
  <patient> 
    <reference value="Patient/$pazienti->getID()"/> 
  </patient> 
  <date value="$narrative['Vaccinazione Data']"/> 
  <primarySource value="true"/> 
 <?php //@TODO Possibile implementazione della location?>
  <location> 
    <reference value="Location/1"/> 
  </location> 
  <manufacturer> 
    <reference value="$vaccini->getManufactured()"/> 
  </manufacturer> 
  <expirationDate value="$vaccini->getExpDate()"/> 
  <doseQuantity> 
    <value value="{{$narrative['Vaccinazione Quantity']}}"/> 
    <system value="http://unitsofmeasure.org"/> 
    <code value="mg"/> 
  </doseQuantity> 
  <practitioner> 
    <role> 
      <coding> 
        <system value="http://hl7.org/fhir/v2/0443"/> 
        <code value="OP"/> 
      </coding> 
    </role> 
        <actor> 
           <reference value="Practitioner/{{$all_cpp->getID()}}"/> 
        </actor> 
  </practitioner> 
  <note> 
    <text value="{{$vaccinazione->getNote()}}"/> 
  </note>  
  @foreach($reactions as $reaction)
  <reaction> 
    <date value="{{$reaction->getDate()}}"/> 
    <detail> 
      <reference value="Observation/{{$reaction->getIDCentro()}}"/> 
    </detail> 
    <reported value="{{$reaction->getReported()}}"/> 
  </reaction>
  @endforeach
  <vaccinationProtocol> 
    <doseSequence value="1"/> 
    <description value="Vaccination Protocol Sequence 1"/> 
    <authority> 
      <reference value="Organization/hl7"/> 
    </authority> 
    <series value="Vaccination Series 1"/> 
    <seriesDoses value="2"/> 
    <targetDisease> 
      <coding> 
        <system value="http://snomed.info/sct"/> 
        <code value="1857005"/> 
      </coding> 
    </targetDisease> 
    <doseStatus> 
      <coding> 
        <system value="http://hl7.org/fhir/vaccination-protocol-dose-status"/> 
        <code value="count"/> 
        <display value="Counts"/> 
      </coding> 
    </doseStatus> 
    <doseStatusReason> 
      <coding> 
        <system value="http://hl7.org/fhir/vaccination-protocol-dose-status-reason"/> 
        <code value="coldchbrk"/> 
        <display value="Cold chain break"/> 
      </coding> 
    </doseStatusReason> 
  </vaccinationProtocol> 
</Immunization> 