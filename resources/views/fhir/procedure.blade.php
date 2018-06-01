<?php
//To simplify and reduce the dependence of the following code
//Data are passed by FHIRController
$narrative       = $data_output["narrative"];
$procedure    = 	$data_output["procedure"];
$paz = $data_output["paziente"];
$cpp = $data_output["careprovider"];
$dia = $data_output ["diagnosi"];
$icd = $data_output ["icd9"];
$status = $data_output ["status"];
$cat = $data_output ["categoria"];
$out = $data_output ["OutCome"];
?>

<Procedure xmlns="http://hl7.org/fhir">
  <id value="{{$procedure->getID()}}"/> 
  
  @if(!($procedure->getDesc()==null))
  <extension url="http://resp.local/resources/extensions/procedure_doc.xml">
  	<valueString value="{{$procedure->getDesc()}}" />
  </extension>
  @endif 
  <text> 
    <status value="generated"/> 
    <div xmlns="http://www.w3.org/1999/xhtml">Routine Appendectomy</div> 
  </text> 
  <status value="{{$status->getID()}}"/> 
  <notDone value = "{{$procedure->getnotDone()}}"/>
  <extension url="http://resp.local/resources/extensions/procedure_category.xml">
  	<valueString value="{{$procedure->getCategory()}}" />
  </extension>
  <code> 
    <coding> 
      <system value="Codice ICD9"/> 
      <code value="{{$icd->getID()}}"/> 
      <display value="{{$icd->getDescizione_ICD9()}}"/> 
    </coding> 
  </code> 
  <subject> 
    <reference value="Patient/{{$procedure->getID()}}"/> 
  </subject> 
  <performedDateTime value="{{$procedure->getData()}}"/> 
  <extension url="http://resp.local/resources/extensions/procedure_diagnosi.xml">
  	<valueString value="{{$procedure->getDiagnosisID()}}" />
  </extension>
  <performer> 
    <role> 
      <coding> 
        <system value="{{$cpp-> getSpecializationDesc()}"/>  
      </coding> 
    </role> 
    <actor> 
      <reference value="{{$cpp->getID()}"/> 
      <display value="{{$cpp->getCpp_FullName()}"/> 
    </actor> 
    <actor> 
      <reference value="{{$paz->getID_Paziente()}"/> 
      <display value="{{$paz->getFullName())}"/> 
    </actor> 
  </performer>   
  <extension url="http://resp.local/resources/extensions/procedure_outcome.xml">
  	<valueString value="{{$procedure->getOutcome()}}" />
  </extension>
  @if(!($procedure->getNote()==null))
  <note> 
    <text value="{{$procedure->getNote()}}"/> 
  </note> 
  @endif
</Procedure> 