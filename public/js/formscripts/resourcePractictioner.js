$(document).on('click', "button.button-show", function() {
	var id = $(this).attr('id');

	$.get("/api/fhir/Practictioner/" + id, function(data) {
		$(".modal-body").html(data);
	});

	$("a.link-export").attr("href", "/api/fhir/Practictioner/" + id);
	$("a.link-export").attr("download", "RESP-PRACTICTIONER" + id + ".xml");

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

$(document).ready(function(){
    $("#import-annulla").click(function(){
    	$("#file").val('');
    	$("#import-file").prop('disabled', true);
    	$('#inputFile').hide();
    });
});