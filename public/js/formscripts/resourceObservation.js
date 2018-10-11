$(document).on('click', "button.button-show", function() {
	var id = $(this).attr('id');

	$.get("/api/fhir/Observation/" + id, function(data) {
		$(".modal-body").html(data);
	});

	$('#id_paziente').val(id);
	$("a.link-export").attr("href", "/api/fhir/Observation/" + id);
	$("a.link-export").attr("download", "RESP-OBSERVATION-" + id + ".xml");

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