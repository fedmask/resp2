<?xml version="1.0" encoding="utf-8"?>
<Observation xmlns="http://hl7.org/fhir">
  <id value="{{$data_output['observation']->id_indagine}}"/>
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
  <extension url="http://resp.local/resources/extensions/observation-type.xml">
  	<valueString value="{{$data_output['observation']->indagine_tipologia}}" />
  </extension>
  <extension url="http://resp.local/resources/extensions/observation-reason.xml">
  	<valueString value="{{$data_output['observation']->indagine_motivo}}" />
  </extension>
  <identifier>
    <use value="usual"/>
    <system value="urn:ietf:rfc:3986"/>
    <value value="../fhir/DiagnosticReport/{{$data_output['observation']->id_indagine}}"/>
  </identifier>
  <status value="{{$data_output['observation']->getStatus()}}" />
  <category>
  	<coding>
  		<system value="http://hl7.org/fhir/observation-category" />
  		<code value="exam" />
  		<display value="Exam" />
  	</coding>
  </category>
  @if($data_output['observation']->indagine_codice_loinc)
  <code>
  	<coding>
  		<system value="http://loinc.org" />
  		<code value="{{$data_output['observation']->indagine_codice_loinc}}" />
  		<display value="{{$data_output['observation']->getLoincDescription()}}" />
  	</coding>
  </code>
  @endif
  <subject>
  	<reference value="../fhir/Patient/{{$data_output['observation']->id_paziente}}" />
  </subject>
  <effectiveDateTime value="{{$data_output['observation']->indagine_data}}" />
  <issued value="{{$data_output['observation']->getDateATOM()}}" />
  <performer>
  	<reference value="../fhir/Practitioner/{{$data_output['observation']->id_cpp}}" />
  </performer>
  <interpretation>
  	<coding>
  		<system value="http://hl7.org/fhir/v2/0078" />
  		<code value="{{$data_output['observation']->getStatusObservation()}}" />
  		<display value="{{$data_output['observation']->getStatusDescriptionObservation()}}" />
  	</coding>
  </interpretation>
  @if($data_output['observation']->indagine_stato =="richiesta" || $data_output['observation']->indagine_stato =="programmata")
  <dataAbsentReason>
  	<coding>
  		<system value="http://hl7.org/fhir/data-absent-reason" />
  		<code value="temp" />
  		<display value="Temp" />
  	</coding>
  </dataAbsentReason>
  @endif
  @if($data_output['observation']->indagine_stato =="conclusa")
  <dataAbsentReason>
  	<coding>
  		<system value="http://hl7.org/fhir/data-absent-reason" />
  		<code value="{{$data_output['observation']->getResponse()}}" />
  		<display value="{{$data_output['observation']->getResponse()}}" />
  	</coding>
  </dataAbsentReason>  
  @endif
</Observation>
