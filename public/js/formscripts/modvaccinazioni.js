$(document).ready(function () {
	$('#dataTables-vaccinazioni').dataTable({
		 "order": [ 4, 'desc' ],
		 //paging: false
	});
	$('.tooltip-vaccinazioni').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
});