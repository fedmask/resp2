<?xml version="1.0" encoding="utf-8"?>
<Patient xmlns="http://hl7.org/fhir">
  <id value="{{$data_output['patient']->id_paziente}}"/>
  <text>
    <status value="generated"/>
    <div xmlns="http://www.w3.org/1999/xhtml">
      <table border="2">
        <tbody>
        @foreach($data_output["narrative"] as $key => $value)
		<tr>
			<td>{{$key}}</td>
			<td>{{$value}}</td></tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </text>
  <extension url="http://resp.local/resources/extensions/blood-type.xml">
    <valueString value=""/>
  </extension>
  <extension url="http://resp.local/resources/extensions/user-fields.xml">
	@foreach($data_output["extensions"] as $i => $value) 
	<extension url="{{$i}}">
		<valueString value="{{$value}}"/>
	</extension>
	@endforeach
  </extension>
  <identifier>
    <use value="usual"/>
    <system value="urn:ietf:rfc:3986"/>
    <value value="../fhir/Patient/{{$data_output['patient']->id_paziente}}"/>
  </identifier>
  <active value="true"/>
  <name>
    <use value="usual"/>
    <family value="{{$data_output['patient']->paziente_cognome}}"/>
    <given value="{{$data_output['patient']->paziente_nome}}"/>
  </name>
  <telecom>
    <system value="phone"/>
    <value value="{{$data_output['patient']->getPhone()}}"/>
    <use value="{{$data_output['patient']->getPhoneType()}}"/>
  </telecom>
  <gender value="{{$data_output['patient']->paziente_sesso}}"/>
  <birthDate value="{{$data_output['patient']->paziente_nascita}}"/>
  <deceasedBoolean value="{{$data_output['patient']->isDeceased()}}"/>
  <address>
    <use value="home"/>
    <line value="{{$data_output['patient']->getLine()}}"/>
    <city value="{{$data_output['patient']->getCity()}}"/>
    <postalCode value="{{$data_output['patient']->getPostalCode()}}"/>
    <country value="{{$data_output['patient']->getCountryName()}}"/>
  </address>
  <maritalStatus>
    <coding>
      <system value="http://hl7.org/fhir/v3/MaritalStatus"/>
      <code value="{{$data_output['patient']->getStatusWeddingCode()}}"/>
      <display value="{{$data_output['patient']->getStatusWedding()}}"/>
    </coding>
  </maritalStatus>
    <contact>
  @foreach($data_output['contacts'] as $contatto)

  	<relationship>
  	  <coding>
  	  	<system value="http://hl7.org/fhir/patient-contact-relationship" />
  	  	<code value="{{$contatto->getTypeContact()}}"
  	  </coding>
  	</relationship>
	<name>
		<use value="usual" />
		<text value="{{$contatto->contatto_nominativo}}" />
	</name>
	<telecom>
		<system value="phone" />
		<value value="{{$contatto->contatto_telefono}}" />
		<use value="{{$contatto->getPhoneType()}}" />
	</telecom>
  @endforeach
    </contact>
  @foreach ($data_output['careproviders'] as $cpp)
  <careProvider>
      <reference value="./fhir/Practitioner/{{$cpp->id_cpp}}" />
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
