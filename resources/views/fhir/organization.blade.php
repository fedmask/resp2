<?xml version="1.0" encoding="utf-8"?>
<Organization xmlns="http://hl7.org/fhir">
  <id value="{{$data_output['organization']->id_centro}}"/>
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
  <extension url="http://resp.local/resources/extensions/practitioner-id.xml">
    <valueString value="{{$data_output['organization']->id_ccp_persona}}"/>
  </extension>
  <extension url="http://resp.local/resources/extensions/organization-type.xml">
    <valueString value="{{$data_output['organization']->getCenterTipology()}}"/>
  </extension>
  <identifier>
    <use value="usual"/>
    <system value="urn:ietf:rfc:3986"/>
    <value value="../fhir/Organization/{{$data_output['organization']->id_centro}}"/>
  </identifier>
    <name value="{{$data_output['organization']->centro_nome}}" />
  <active value="true"/>
  <telecom>
    <system value="email"/>
    <value value="{{$data_output['organization']->getContactEmail()}}"/>
    <use value="work"/>
  </telecom>
    @foreach ($data_output['phone'] as $key => $phone_number)
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
  	<line value="{{$data_output['organization']->centro_indirizzo}}" />
    <city value="{{$data_output['organization']->getTown()}}" />
    <country value="IT" />
  </address>
  <contact>
      <name>
        <use value="usual"/>
        <family value="{{$data_output['organization']->getCareProviderSurname()}}"/>
        <given value="{{$data_output['organization']->getCareProviderName()}}"/>
        <prefix value="Dott."/>
      </name>
  </contact>
</Organization>
