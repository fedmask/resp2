$(document).on('click', "button.button-show", function() {
	var id = $(this).attr('id');

	$.get("/api/fhir/FamilyMemberHistory/" + id, function(data) {
		$(".modal-body").html(data);
	});

	$('#id_paziente').val(id);
	$("a.link-export").attr("href", "/api/fhir/FamilyMemberHistory/" + id);
	$("a.link-export").attr("download", "RESP-FAMILYMEMBERHISTORY-" + id + ".xml");

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
	document.getElementById("updateInputForm").action = "/api/fhir/FamilyMemberHistory/"
			+ document.getElementById("anamnesi_id").value;

}

function openInputFileUpdate(id) {
	document.getElementById("inputFileUpdate").hidden = false;
	document.getElementById("inputFileUpdate").style.display = 'block';
	document.getElementById("anamnesi_id").value = id;

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