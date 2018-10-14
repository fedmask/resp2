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