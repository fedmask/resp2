<?php
// To simplify and reduce the dependence of the following code
// Data are passed by FHIRController
$narrative = $data_output["narrative"];
$narrative_practictioner_qualifications = $data_output["narrative_practictioner_qualifications"];
$extensions = $data_output["extensions"];
$practictioner = $data_output["practictioner"];
$practictioner_qualifiations = $data_output["practictioner_qualifiations"];
?>


<?xml version="1.0" encoding="UTF-8"?>
<Practitioner xmlns="http://hl7.org/fhir">
  <id value="{{$practictioner->getIdCpp()}}"/>

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
			
			@foreach($narrative_practictioner_qualifications as $key => $value)
			<tr>
				<td>{{$key}}</td>
				<td>{{$value}}</td>
			</tr>
			@endforeach
			 
			 @foreach($extensions as $key => $value)
			<tr>
				<td>{{$key}}</td>
				<td>{{$value}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
    </div>
  </text>


@if(array_key_exists('Comune', $extensions))
<!--Comune Residenza-->
  <extension url="http://resp.local/resources/extensions/practictioner/practitioner-comune.xml">
    <valueString value="{{$extensions['Comune']}}"/>
  </extension>
@endif


@if(array_key_exists('Id_Utente', $extensions))
<!--Id Persona Cpp-->
  <extension url="http://resp.local/resources/extensions/practictioner/cpp-persona-id.xml">
    <valueString value="{{$extensions['Id_Utente']}}"/>
  </extension>
@endif

  <identifier>
    <use value="official"/>
    <system value="http://resp.local"/>
    <value value="{{$practictioner->getIdCpp()}}"/>
  </identifier>

  <active value="{{$practictioner->isActive()}}"/>
  
  <name>
    <family value="{{$practictioner->getSurname()}}"/>
    <given value="{{$practictioner->getName()}}"/>
    <prefix value="Dr"/>
  </name>

@if(!empty($practictioner->getPhone()))
  <telecom>
    <system value="phone"/>
    <value value="{{$practictioner->getPhone()}}"/>
    <use value="home"/>
  </telecom>
@endif  

@if(!empty($practictioner->getMail()))
  <telecom>
    <system value="email"/>
    <value value="{{$practictioner->getMail()}}"/>
    <use value="home"/>
  </telecom>
@endif
  
  <address>
    <use value="home"/>
    @if(!empty($practictioner->getLine()))
    <line value="{{$practictioner->getLine()}}"/>
    @endif
    <city value="{{$practictioner->getCity()}}"/>
    <state value="{{$practictioner->getCountryName()}}"/>
    <postalCode value="{{$practictioner->getPostalCode()}}"/>
  </address>
	
  <gender value="{{$practictioner->getGender()}}"/>
  
  <birthDate value="{{$practictioner->getBirth()}}"/>

@foreach($practictioner_qualifiations as $pq)
  <qualification>
		<code>
      <coding>
        <system value="http://hl7.org/fhir/v2/0360/2.7"/>
        <code value="{{$pq->getCode()}}"/>
        <display value="{{$pq->getQualificationDisplay()}}"/>
      </coding>
			<text value="{{$pq->getQualificationDisplay()}}"/>
		</code>
		@if(!empty($pq->getStartPeriod()) && !empty($pq->getEndPeriod()))
		<period>
		@if(!empty($pq->getStartPeriod()))
			<start value="{{$pq->getStartPeriod()}}"/>
		@endif
		@if(!empty($pq->getEndPeriod()))
			<end value="{{$pq->getEndPeriod()}}"/>
		@endif
		</period>
		@endif
		@if(!empty($pq->getIssuer()))
		<issuer>
			<display value="{{$pq->getIssuer()}}"/>
		</issuer>
		@endif
	</qualification>
@endforeach

  <communication>
      <coding>
          <system value="urn:ietf:bcp:47"/>
          <code value="{{$practictioner->getCodeLanguage()}}"/>
          <display value="{{$practictioner->getLanguage()}}"/>
      </coding>
  </communication>


</Practitioner>