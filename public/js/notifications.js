function Notifications() {
    "use strict";

    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
	
	$('.tooltip-retefam').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
	
	$('.tooltip-gravidanze').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
    // popover demo
    $("[data-toggle=popover]")
        .popover()
};