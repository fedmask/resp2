$(document).ready(function () {
	$('#dataTables-allergie').dataTable({
		 "order": [ 2, 'desc' ],
		 paging: false
	});
	$('#dataTables-intolleranze').dataTable({
		 "order": [ 2, 'desc' ],
		 paging: false
	});
	$('.tooltip-allergie').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
});