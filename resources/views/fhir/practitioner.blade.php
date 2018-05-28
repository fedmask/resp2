<?php
//To simplify and reduce the dependence of the following code
//Data are passed by FHIRController
$narrative       = $data_output['narrative'];
$careprovider    = $data_output['careprovider'];
?>
<?xml version="1.0" encoding="utf-8"?>
<Practitioner xmlns="http://hl7.org/fhir">
  <id value="{{$careprovider->getUserID()}}"/>
  <text>
    <status value="generated"/>
    <div xmlns="http://www.w3.org/1999/xhtml">
      <table border="2">
        <tbody>
        @foreach($narrative as $key => $value)
		<tr> <!-- Crea nuova row -->
			<td>{{$key}}</td>  <!-- Crea nuova cella -->
			<td>{{$value}}</td></tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </text>
  <identifier>
    <use value="usual"/>
    <system value="urn:ietf:rfc:3986"/>
    <value value="../fhir/Practitioner/{{$careprovider->getUserID()}}"/>
  </identifier>
  <active value="{{$careprovider->isActive() ? 'true' : 'false'}}"/>
  <extension url="http://resp.local/resources/extensions/practitioner-comune.xml">
    <valueString value="{{$careprovider->getTown()}}"/>
  </extension>
  <extension url="http://resp.local/resources/extensions/user-id.xml">
    <valueString value="{{$careprovider->getUserID()}}"/>
  </extension>
  <name>
    <use value="usual"/>
    <family value="{{$careprovider->getName()}}"/>
    <given value="{{$careprovider->getSurname()}}"/>
  </name> 
  <telecom>
    <system value="phone"/>
    <value value="{{$careprovider->getPhone()}}"/>
    <use value="{{$careprovider->getPhoneType()}}"/>
  </telecom>
  <communication>
    <coding>
      <system value="https://tools.ietf.org/html/bcp47"/>
      <code value="it"/>
      <display value="Italiano"/>
    </coding>
  </communication>
</Practitioner>
