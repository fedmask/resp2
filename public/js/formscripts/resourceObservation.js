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