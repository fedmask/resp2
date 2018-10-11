<?php 

$narrative = $data_output["narrative"];

?>


<?xml version="1.0" encoding="UTF-8"?>
<Observation xmlns="http://hl7.org/fhir">
  <id value=""/>
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
    <use value="official"/>
    <system value=""/>
    <value value=""/>
  </identifier>
  
  <status value=""/>
  
  <category>
	<coding>
		<system value="http://hl7.org/fhir/observation-category"/>
		<code value=""/>
		<display value=""/>
	</coding>
	    <text value=""/>
  </category>
  
  <code>
    <coding>
      <system value="http://loinc.org"/>
      <code value=""/>
      <display value=""/>
    </coding>
  </code>
  
  <subject>
    <reference value=""/>
    <display value=""/>
  </subject>
  
  <effectivePeriod>
    <start value=""/>
  </effectivePeriod>
  
  <issued value=""/>
  
  <performer>
    <reference value=""/>
    <display value=""/>
  </performer>
  
  <interpretation>
    <coding>
      <system value="http://hl7.org/fhir/v2/0078"/>
      <code value=""/>
      <display value=""/>
    </coding>
  </interpretation>

</Observation>