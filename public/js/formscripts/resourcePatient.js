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

