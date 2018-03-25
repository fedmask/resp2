<?xml version="1.0" encoding="utf-8"?>
<Practitioner xmlns="http://hl7.org/fhir">
  <id value="{{$data_output['careprovider']->id_utente}}"/>
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
  <identifier>
    <use value="usual"/>
    <system value="urn:ietf:rfc:3986"/>
    <value value="../fhir/Practitioner/{{$data_output['careprovider']->id_utente}}"/>
  </identifier>
  <active value="{{$data_output['careprovider']->persona_attivo == 1 ? 'true' : 'false'}}"/>
  <extension url="http://resp.local/resources/extensions/practitioner-comune.xml">
    <valueString value="{{$data_output['careprovider']->getTown()}}"/>
  </extension>
  <extension url="http://resp.local/resources/extensions/user-id.xml">
    <valueString value="{{$data_output['careprovider']->id_utente}}"/>
  </extension>
  <name>
    <use value="usual"/>
    <family value="{{$data_output['careprovider']->persona_cognome}}"/>
    <given value="{{$data_output['careprovider']->persona_nome}}"/>
  </name>
  <telecom>
    <system value="phone"/>
    <value value="{{$data_output['careprovider']->persona_telefono}}"/>
    <use value="{{$data_output['careprovider']->getPhoneType()}}"/>
  </telecom>
  <communication>
    <coding>
      <system value="https://tools.ietf.org/html/bcp47"/>
      <code value="it"/>
      <display value="Italiano"/>
    </coding>
  </communication>
</Practitioner>
