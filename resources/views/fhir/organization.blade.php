<?php
//To simplify and reduce the dependence of the following code
//Data are passed by FHIRController
$narrative       = $data_output["narrative"];
$organization    = $data_output['organization'];
$contacts        = $data_output['phone'];
?>
<?xml version="1.0" encoding="utf-8"?>
<Organization xmlns="http://hl7.org/fhir">
  <id value="{{$organization->getID()}}"/>
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
  <extension url="http://resp.local/resources/extensions/practitioner-id.xml">
    <valueString value="{{$organization->getIDCpp()}}"/>
  </extension>
  <extension url="http://resp.local/resources/extensions/organization-type.xml">
    <valueString value="{{$organization->getCenterTipology()}}"/>
  </extension>
  <identifier>
    <use value="usual"/>
    <system value="urn:ietf:rfc:3986"/>
    <value value="../fhir/Organization/{{$organization->getID()}}"/>
  </identifier>
    <name value="{{$organization->getName()}}" />
  <active value="true"/>
  <telecom>
    <system value="email"/>
    <value value="{{$organization->getContactEmail()}}"/>
    <use value="work"/>
  </telecom>
    @foreach ($contacts as $key => $phone_number)
   <telecom>
    	<system value="phone" />
    	<value value="{{$phone_number['contatto_valore']}}" />
    	<use value="mobile" />
    	<rank value="{{$key+1}}" />
    </telecom>
    @endforeach
  <type>
    <coding>
      <system value="http://hl7.org/fhir/organization-type"/>
      <code value="prov"/>
    </coding>
  </type>
  <address>
  	<line value="{{$organization->getAddress()}}" />
    <city value="{{$organization->getTown()}}" />
    <country value="IT" />
  </address>
  <contact>
      <name>
        <use value="usual"/>
        <family value="{{$organization->getCareProviderSurname()}}"/>
        <given value="{{$organization->getCareProviderName()}}"/>
      </name>
  </contact>
</Organization>
