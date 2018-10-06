function updateInputForm() {

	var action = document.getElementById("updateInputForm").action;
	document.getElementById("updateInputForm").action = "/api/fhir/Patient/"
			+ document.getElementById("patient_id").value;

}

function openInputFile() {
	document.getElementById("inputFile").hidden = false;
	document.getElementById("inputFile").style.display = 'block';
}

function openInputFileUpdate(id) {
	document.getElementById("inputFileUpdate").hidden = false;
	document.getElementById("inputFileUpdate").style.display = 'block';
	document.getElementById("patient_id").value = id;

}

$(document).on('click', "button.button-show", function() {
	var id = $(this).attr('id');

	$.get("/api/fhir/Patient/" + id, function(data) {
		$(".modal-body").html(data);
	});

	$('#id_paziente').val(id);
	$("a.link-export").attr("href", "/api/fhir/Patient/" + id);
	$("a.link-export").attr("download", "RESP-PATIENT" + id + ".xml");

	$("#myModal").modal("show");
});




$(document).ready(function(){
    $("#annulla").click(function(){
    	$('#inputFileUpdate').hide();
    });
});

$(document).ready(function(){
    $("#import-annulla").click(function(){
    	$('#inputFile').hide();
    });
});


$(document).ready(function(){

    $("#fileUpdate").change(function() {
    	$("#upload").prop('disabled', false);
    });
});

$(document).ready(function(){

    $("#file").change(function() {
    	$("#import-file").prop('disabled', false);
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
    $("#import-annulla").click(function(){
    	$("#file").val('');
    	$("#import-file").prop('disabled', true);
    	$('#inputFile').hide();
    });
});

$(document).on('click', "button.button-export", function() {
	$(".modal-body").html("");
	
	$("<input class='check' type='checkbox' name='Patient' value='Patient'> Patient<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='Practitioner' value='Practitioner'> Practitioner<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Encounter<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Related Person<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Observation<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Immunization<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Allergy & Intollerance<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Device<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Procedure<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Condiction<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Medication<br>").appendTo(".modal-body");

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
	window.location.href = "/fhirExportResources/Patient/"+id+"/"+list;
	
});

