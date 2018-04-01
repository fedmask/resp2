<?php 
//To simplify and reduce the dependence of the following code
//Data are passed by FHIRController
$narrative  = $data_output["narrative"];
$patient    = $data_output["patient"];
$contacts   = $data_output['contacts'];
$all_cpp    = $data_output['careproviders'];
?>
<?xml version="1.0" encoding="utf-8"?>
<Patient xmlns="http://hl7.org/fhir">
  <id value="{{$patient->getID()}}"/>
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
  <extension url="http://resp.local/resources/extensions/user-fields.xml">
	@foreach($data_output["extensions"] as $type => $value) 
	<extension url="{{$type}}">
		<valueString value="{{$value}}"/>
	</extension>
	@endforeach
  </extension>
  <identifier>
    <use value="usual"/>
    <system value="urn:ietf:rfc:3986"/>
    <value value="../fhir/Patient/{{$patient->getID()}}"/>
  </identifier>
  <active value="true"/>
  <name>
    <use value="usual"/>
    <family value="{{$patient->getName()}}"/>
    <given value="{{$patient->getSurname()}}"/>
  </name>
  <telecom>
    <system value="phone"/>
    <value value="{{$patient->getPhone()}}"/>
    <use value="{{$patient->getPhoneType()}}"/>
  </telecom>
  <gender value="{{$patient->getSex()}}"/>
  <birthDate value="{{$patient->getBirth()}}"/>
  <deceasedBoolean value="{{$patient->isDeceased()}}"/>
  <address>
    <use value="home"/>
    <line value="{{$patient->getLine()}}"/>
    <city value="{{$patient->getCity()}}"/>
    <postalCode value="{{$patient->getPostalCode()}}"/>
    <country value="{{$patient->getCountryName()}}"/>
  </address>
  <maritalStatus>
    <coding>
      <system value="http://hl7.org/fhir/v3/MaritalStatus"/>
      <code value="{{$patient->getStatusWeddingCode()}}"/>
      <display value="{{$patient->getStatusWedding()}}"/>
    </coding>
  </maritalStatus>
    <contact>
  @foreach($contacts as $contact)
  	<relationship>
  	  <coding>
  	  	<system value="http://hl7.org/fhir/patient-contact-relationship" />
  	  	<code value="{{$contact->getTypeContact()}}"
  	  </coding>
  	</relationship>
	<name>
		<use value="usual" />
		<text value="{{$contact->getFullName()}}" />
	</name>
	<telecom>
		<system value="phone" />
		<value value="{{$contact->getPhone()}}" />
		<use value="{{$contact->getPhoneType()}}" />
	</telecom>
  @endforeach
    </contact>
  @foreach ($all_cpp as $cpp)
  <careProvider>
      <reference value="./fhir/Practitioner/{{$cpp->getID()}}" />
  </careProvider>
  @endforeach
  <communication>
    <coding>
      <system value="https://tools.ietf.org/html/bcp47"/>
      <code value="it"/>
      <display value="Italiano"/>
    </coding>
  </communication>
</Patient>
