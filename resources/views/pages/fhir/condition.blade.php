<?php 
$narrative = $data_output["narrative"];
$diagnosi = $data_output["diagnosi"];
?>

<?xml version="1.0" encoding="UTF-8"?>
<Condition xmlns="http://hl7.org/fhir">
  <id value="example"/>
 
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
    <value value="{{$diagnosi->getId()}}"/>
  </identifier>

  <clinicalStatus value="{{$diagnosi->getClinicalStatus()}}"/>
 
  <verificationStatus value="{{$diagnosi->getVerificationStatus()}}"/>
 
  <severity>
    <coding>
      <system value="http://snomed.info/sct"/>
      <code value="{{$diagnosi->getSeverity()}}"/>
      <display value="{{$diagnosi->getSeverityDisplay()}}"/>
    </coding>
  </severity>
 
  <code>
    <coding>
      <system value="http://snomed.info/sct"/>
      <code value="{{$diagnosi->getCode()}}"/>
      <display value="{{$diagnosi->getCodeDisplay()}}"/>
    </coding>
    <text value="{{$diagnosi->getCodeDisplay()}}"/>
  </code>
  
  <bodySite>
    <coding>
      <system value="http://snomed.info/sct"/>
      <code value="{{$diagnosi->getBodySite()}}"/>
      <display value="{{$diagnosi->getBodySiteDisplay()}}"/>
    </coding>
    <text value="{{$diagnosi->getBodySiteDisplay()}}"/>
  </bodySite>
  
    <subject>
    <reference value="RESP-PATIENT-{{$diagnosi->getPazienteId()}}"/>
  </subject>

  <stage>
    <!--  The problem is temporary and will not become permanent renal insufficiency  -->
    <summary>
      <coding>
        <system value="http://snomed.info/sct"/>
        <code value="{{$diagnosi->getStage()}}"/>
        <display value="{{$diagnosi->getStageDisplay()}}"/>
      </coding>
    </summary>
  </stage>

  <evidence>
    <detail>
      <reference value="{{$diagnosi->getEvidence()}}"/>
      <display value="{{$diagnosi->getEvidenceDisplay()}}"/>
    </detail>
  </evidence>

  <note>
    <text value="{{$diagnosi->getNote()}}"/>
  </note>

</Condition>