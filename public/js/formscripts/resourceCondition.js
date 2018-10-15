$(document).on('click', "button.button-show", function() {
	var id = $(this).attr('id');

	$.get("/api/fhir/Condition/" + id, function(data) {
		$(".modal-body").html(data);
	});

	$('#id_paziente').val(id);
	$("a.link-export").attr("href", "/api/fhir/Condition/" + id);
	$("a.link-export").attr("download", "RESP-CONDITION-" + id + ".xml");

	$("#myModal").modal("show");
});

function openInputFile() {
	document.getElementById("inputFile").hidden = false;
	document.getElementById("inputFile").style.display = 'block';
}

$(document).ready(function(){
    $("#import-annulla").click(function(){
    	$('#inputFile').hide();
    });
});

$(document).ready(function(){

    $("#file").change(function() {
    	$("#import-file").prop('disabled', false);
    });
});

function updateInputForm() {

	var action = document.getElementById("updateInputForm").action;
	document.getElementById("updateInputForm").action = "/api/fhir/Condition/"
			+ document.getElementById("diagnosi_id").value;

}

function openInputFileUpdate(id) {
	document.getElementById("inputFileUpdate").hidden = false;
	document.getElementById("inputFileUpdate").style.display = 'block';
	document.getElementById("diagnosi_id").value = id;

}

$(document).ready(function(){
    $("#annulla").click(function(){
    	$('#inputFileUpdate').hide();
    });
});

$(document).ready(function(){

    $("#fileUpdate").change(function() {
    	$("#upload").prop('disabled', false);
    });
});

$(document).ready(function(){
    $("#annulla").click(function(){
    	$("#fileUpdate").val('');
    	$("#upload").prop('disabled', true);
    	$('#inputFileUpdate').hide();
    });
});

$(document).on('click', "button.button-export", function() {
	$(".modal-body").html("");
	$("<table style='width:100%;' padding='15'>").appendTo(".modal-body");
	$("<h2>Base</h2>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<th>Individuals</th>").appendTo(".modal-body");
	$("<th>Entities</th>").appendTo(".modal-body");
	$("<th>Management</th>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Patient' value='Patient'> Patient</td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Organization' value='Organization' disabled> Organization</td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Encounter' value='Encounter'> Encounter</td>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Practitioner' value='Practitioner'> Practitioner</td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Device' value='Device' disabled> Device</td>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='RelatedPerson' value='RelatedPerson'> Related Person</td>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	
	$("<h2>Clinical</h2>").appendTo(".modal-body");
	$("<th>Summary</th>").appendTo(".modal-body");
	$("<th>Diagnostics</th>").appendTo(".modal-body");
	$("<th>Medications</th>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='AllergyIntolerance' value='AllergyIntolerance' disabled> AllergyIntolerance</td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Observation' value='Observation'> Observation</td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Medication' value='Medication' disabled> Medication</td>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Condition' value='Condition'> Condition</td>").appendTo(".modal-body");
	$("<td></td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Immunization' value='Immunization'> Immunization</td>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Procedure' value='Procedure' disabled> Procedure</td>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='FamilyMemberHistory' value='FamilyMemberHistory'> FamilyMemberHistory</td>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	
	$("</table>").appendTo(".modal-body");
	var id = $(this).attr('id');
	$("#myModalExport").modal("show");
});


$(document).on('click', "button.button-export1", function() {
	var id = $(this).attr('id');
	var list = new Array();

	if($('input[name=Patient]').is(':checked')){
		list.push("Patient");
	}
	
	if($('input[name=Practitioner]').is(':checked')){
		list.push("Practitioner");
	}
	
	if($('input[name=RelatedPerson]').is(':checked')){
		list.push("RelatedPerson");
	}
	
	if($('input[name=Observation]').is(':checked')){
		list.push("Observation");
	}
	
	if($('input[name=Immunization]').is(':checked')){
		list.push("Immunization");
	}
	
	if($('input[name=Encounter]').is(':checked')){
		list.push("Encounter");
	}
	
	if($('input[name=Condition]').is(':checked')){
		list.push("Condition");
	}
	
	if($('input[name=FamilyMemberHistory]').is(':checked')){
		list.push("FamilyMemberHistory");
	}
	
	
	window.location.href = "/fhirExportResources/Patient/"+id+"/"+list;
	
});