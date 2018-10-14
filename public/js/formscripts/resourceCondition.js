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