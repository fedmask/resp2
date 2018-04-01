<?xml version="1.0" encoding="utf-8"?>
<OperationOutcome xmlns="http://hl7.org/fhir">
  <text>
    <status value="generated"/>
    <div xmlns="http://www.w3.org/1999/xhtml">
      <h1>{{$errorMessage}}</h1>
    </div>
  </text>
  <issue>
    <severity value="error"/>
    <code value="invalid"/>
    <diagnostics value="{{$errorMessage}}"/>
  </issue>
</OperationOutcome>