$(document).ready(function () {
	$('#dataTables-anampatpros').dataTable({
		 paging: false
	});
	$('#dataTables-anampatrem').dataTable({
	});
	$('.tooltip-diagnosi').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
});