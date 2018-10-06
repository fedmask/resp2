$(document).on('click', "button.button-show", function() {
	var id = $(this).attr('id');

	$.get("/api/fhir/Practitioner/" + id, function(data) {
		$(".modal-body").html(data);
	});

	$("a.link-export").attr("href", "/api/fhir/Practitioner/" + id);
	$("a.link-export").attr("download", "RESP-PRACTITIONER" + id + ".xml");

	$("#myModal").modal("show");
});

function openInputFileUpdate(id) {
	document.getElementById("inputFileUpdate").hidden = false;
	document.getElementById("inputFileUpdate").style.display = 'block';
	document.getElementById("practitioner_id").value = id;
}
function updateInputForm() {

	var action = document.getElementById("updateInputForm").action;
	document.getElementById("updateInputForm").action = "/api/fhir/Practitioner/"
			+ document.getElementById("practitioner_id").value;

}

function openInputFile() {
	document.getElementById("inputFile").hidden = false;
	document.getElementById("inputFile").style.display = 'block';
}

$(document).ready(function() {
	$("#import-annulla").click(function() {
		$('#inputFile').hide();
	});
});

$(document).ready(function() {

	$("#file").change(function() {
		$("#import-file").prop('disabled', false);
	});
});

$(document).ready(function() {
	$("#import-annulla").click(function() {
		$("#file").val('');
		$("#import-file").prop('disabled', true);
		$('#inputFile').hide();
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

    $("#fileUpdate").change(function() {
    	$("#upload").prop('disabled', false);
    });
});

$(document).ready(function(){
    $("#annulla").click(function(){
    	$('#inputFileUpdate').hide();
    });
});

$(document).on('click', "button.button-export", function() {
	$(".modal-body").html("");
	
	$("<input class='check' type='checkbox' name='Patient' value='Patient'> Patient<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='Practitioner' value='Practitioner'> Practitioner<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Related Person<br>").appendTo(".modal-body");
	$("<input class='check' type='checkbox' name='' value=''> Encounter<br>").appendTo(".modal-body");
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