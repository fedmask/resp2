$(document).on('click', "button.button-show", function() {
	var id = $(this).attr('id');

	$.get("/api/fhir/Immunization/" + id, function(data) {
		$(".modal-body").html(data);
	});

	$('#id_paziente').val(id);
	$("a.link-export").attr("href", "/api/fhir/Immunization/" + id);
	$("a.link-export").attr("download", "RESP-IMMUNIZATION-" + id + ".xml");

	$("#myModal").modal("show");
});