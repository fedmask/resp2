<?php
//To simplify and reduce the dependence of the following code
//Data are passed by FHIRController
$Paziente= $data_output['Paziente'];
$AnamnesiF= $data_output['AnamnesiF'];
$Parente= $data_output['Parenti'];
$FamilyCondition= $data_output['observation'];
$Narrative = $data_output['narrative'];
?>

<FamilyMemberHistory xmlns="http://hl7.org/fhir">
  <id value="{{$AnamnesiF->getIDParentela()}}"/> 
  <text> 
    <status value="generated"/> 
    <div xmlns="http://www.w3.org/1999/xhtml">$AnamnesiF->getDesc()</div> 
  </text> 
  <identifier> 
  <value value="{{$AnamnesiF->getID()}}"/> 
  </identifier> 
  <status value="{{$AnamnesiF->getStatus()}}"/> 
  @if(!empty($AnamnesiF-> getNDR())
  <notDone value="{{$AnamnesiF-> getNDR()}}"/> 
  @endif
  <patient> 
    <reference value="Patient/{{$Paziente->getID()}}"/> 
    <display value="{{$Paziente->getFullName()}} Patient"/> 
  </patient> 
  <relationship> 
  	<reference value = "{{$AnamnesiF->getIDParentela()}}"/> 	
  </relationship>
  <date value="{{$AnamnesiF->getData()}}"/> 
  
  <relationship> 
    <coding> 
      <system value="http://hl7.org/fhir/v3/RoleCode"/> 
      <code value="{{$AnamnesiF->getCodice()}}"/> 
      <display value="{{$AnamnediF->getCDescrizione()}}"/> 
    </coding> 
  </relationship> 
  <gender value="{{$Parente->getSesso()}}"/> 
  @if(!empty($Parente->getEta())
  <?php //@TODO Implementare anche controlli sul tipo di dato disponibile: Age, Range, String?> 
  <age>
  	<Age value="{{$Parente->getEta()}}"/> 
    <unit value="yr"/>
  </age>
  @else
  <born>
  	@if(!empty($Parente->getDataN()))				<!-- Per GIOVANNI in vase di store assicurarsi che almeno uno dei due campi sia presente -->
  	<date value="{{$Parente->getDataN()}}"/>
  	@else
  	<string value = ""/>
  	@endid
  </born>
  @endif
  @foreach($FamilyCondition as $FC)
  <condition> 
    <code> 
    <coding> 
      <system value="ICD9"/> 
      <code value="{{$FC->getICD9()}}"/> 
      <display value="{{$FC->ICD9_Desc()}}"/> <?php //@TODO Controllare la referenza?>
    </coding> 
    </code> 
    @if($FC->getOSAge())
    <onsetAge> 
      <value value="{{$FC->getAgeValue()}}"/> 
      <unit value="yr"/> 
      <system value="http://unitsofmeasure.org"/> 
      <code value="a"/> 
    </onsetAge> 
    @endif
    <note> 
      <text value="{{$FC->getNote()}}"/> 
    </note> 
  </condition>
  @endforeach 
</FamilyMemberHistory> 