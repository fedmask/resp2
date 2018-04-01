<?php
//To simplify and reduce the dependence of the following code
//Data are passed by FHIRController
$narrative      = $data_output['narrative'];
$observation    = $data_output['observation'];
?>
<?xml version="1.0" encoding="utf-8"?>
<Observation xmlns="http://hl7.org/fhir">
  <id value="{{$observation->getID()}}"/>
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
  <extension url="http://resp.local/resources/extensions/observation-type.xml">
  	<valueString value="{{$observation->getTipology()}}" />
  </extension>
  <extension url="http://resp.local/resources/extensions/observation-reason.xml">
  	<valueString value="{{$observation->getReason()}}" />
  </extension>
  <identifier>
    <use value="usual"/>
    <system value="urn:ietf:rfc:3986"/>
    <value value="../fhir/DiagnosticReport/{{$observation->getID()}}"/>
  </identifier>
  <status value="{{$observation->getStatus()}}" />
  <category>
  	<coding>
  		<system value="http://hl7.org/fhir/observation-category" />
  		<code value="exam" />
  		<display value="Exam" />
  	</coding>
  </category>
  @if($observation->getCodeLoinc())
  <code>
  	<coding>
  		<system value="http://loinc.org" />
  		<code value="{{$observation->getCodeLoinc()}}" />
  		<display value="{{$observation->getLoincDescription()}}" />
  	</coding>
  </code>
  @endif
  <subject>
  	<reference value="../fhir/Patient/{{$observation->getID()}}" />
  </subject>
  <effectiveDateTime value="{{$observation->getDate()}}" />
  <issued value="{{$observation->getDateATOM()}}" />
  <performer>
  	<reference value="../fhir/Practitioner/{{$observation->getCppID()}}" />
  </performer>
  <interpretation>
  	<coding>
  		<system value="http://hl7.org/fhir/v2/0078" />
  		<code value="{{$observation->getStatusObservation()}}" />
  		<display value="{{$observation->getStatusDescriptionObservation()}}" />
  	</coding>
  </interpretation>
  @if(!$observation->isClosed())
  <dataAbsentReason>
  	<coding>
  		<system value="http://hl7.org/fhir/data-absent-reason" />
  		<code value="temp" />
  		<display value="Temp" />
  	</coding>
  </dataAbsentReason>
  @else
  <dataAbsentReason>
  	<coding>
  		<system value="http://hl7.org/fhir/data-absent-reason" />
  		<code value="{{$observation->getResponse()}}" />
  		<display value="{{$observation->getResponse()}}" />
  	</coding>
  </dataAbsentReason>  
  @endif
</Observation>
