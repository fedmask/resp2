$(document).on('click', "button.button-show", function() {
	var id = $(this).attr('id');

	$.get("/api/fhir/RelatedPerson/" + id, function(data) {
		$(".modal-body").html(data);
	});

	$("a.link-export").attr("href", "/api/fhir/RelatedPerson/" + id);
	var i = id.split(',');

	$("a.link-export").attr("download", "RESP-RELATEDPERSON-" + i[1] + "-" + i[0] + ".xml");

	$("#myModal").modal("show");
});

function openInputFileUpdate(id) {
	document.getElementById("inputFileUpdate").hidden = false;
	document.getElementById("inputFileUpdate").style.display = 'block';
	document.getElementById("contatto_id").value = id;
}

function openInputFileUpdateRel(id) {
	document.getElementById("inputFileUpdateRel").hidden = false;
	document.getElementById("inputFileUpdateRel").style.display = 'block';
	document.getElementById("parente_id").value = id;
}

function updateInputForm() {

	var action = document.getElementById("updateInputForm").action;
	document.getElementById("updateInputForm").action = "/api/fhir/RelatedPerson/"
			+ document.getElementById("contatto_id").value;

}

function updateInputFormRel() {

	var action = document.getElementById("updateInputFormRel").action;
	document.getElementById("updateInputFormRel").action = "/api/fhir/RelatedPerson/"
			+ document.getElementById("parente_id").value;

}

function openInputFile() {
	document.getElementById("inputFile").hidden = false;
	document.getElementById("inputFile").style.display = 'block';
}

function openInputFileRel() {
	document.getElementById("inputFileRel").hidden = false;
	document.getElementById("inputFileRel").style.display = 'block';
}


$(document).ready(function() {
	$("#import-annulla").click(function() {
		$('#inputFile').hide();
	});
});

$(document).ready(function() {
	$("#import-annullaRel").click(function() {
		$('#inputFileRel').hide();
	});
});

$(document).ready(function() {

	$("#file").change(function() {
		$("#import-file").prop('disabled', false);
	});
});

$(document).ready(function() {

	$("#fileRel").change(function() {
		$("#import-fileRel").prop('disabled', false);
	});
});

$(document).ready(function() {
	$("#import-annulla").click(function() {
		$("#file").val('');
		$("#import-file").prop('disabled', true);
		$('#inputFile').hide();
	});
});

$(document).ready(function() {
	$("#import-annullaRel").click(function() {
		$("#file").val('');
		$("#import-fileRel").prop('disabled', true);
		$('#inputFileRel').hide();
	});
});


$(document).ready(function(){
    $("#annulla").click(function(){
    	$("#fileUpdate").val('');
    	$("#upload").prop('disabled', true);
    	$('#inputFileUpdate').hide();
    });
});

$(document).ready(function(){
    $("#annullaRel").click(function(){
    	$("#fileUpdateRel").val('');
    	$("#upload").prop('disabled', true);
    	$('#inputFileUpdateRel').hide();
    });
});


$(document).ready(function(){
    $("#fileUpdate").change(function() {
    	$("#upload").prop('disabled', false);
    });
});


$(document).ready(function(){
    $("#fileUpdateRel").change(function() {
    	$("#uploadRel").prop('disabled', false);
    });
});

$(document).ready(function(){
    $("#annulla").click(function(){
    	$('#inputFileUpdate').hide();
    });
});

$(document).ready(function(){
    $("#annullaRel").click(function(){
    	$('#inputFileUpdateRel').hide();
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
	$("<td><input class='check' type='checkbox' name='Organization' value='Organization'> Organization</td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Encounter' value='Encounter'> Encounter</td>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Practitioner' value='Practitioner'> Practitioner</td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Device' value='Device'> Device</td>").appendTo(".modal-body");
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
	$("<td><input class='check' type='checkbox' name='AllergyIntolerance' value='AllergyIntolerance'> AllergyIntolerance</td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Observation' value='Observation'> Observation</td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Medication' value='Medication'> Medication</td>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Condition' value='Condition'> Condition</td>").appendTo(".modal-body");
	$("<td></td>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Immunization' value='Immunization'> Immunization</td>").appendTo(".modal-body");
	$("</tr>").appendTo(".modal-body");
	$("<tr>").appendTo(".modal-body");
	$("<td><input class='check' type='checkbox' name='Procedure' value='Procedure'> Procedure</td>").appendTo(".modal-body");
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
	
	
	window.location.href = "/fhirExportResources/Patient/"+id+"/"+list;
	
});