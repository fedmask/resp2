var canvas, canvasback;
var ctx, ctxback;
var flag = false, flagback = false;
var prevX = 0;
var currX = 0;
var prevY = 0;
var currY = 0;
var dot_flag = false;

var prevXback = 0;
var currXback = 0;
var prevYback = 0;
var currYback = 0;
var dot_flagback = false;

var colorepennello = "white";
var dimpennello = 15;

var	outlineImage = new Image();
	
	
var	outlineImageBack = new Image();
	

$(document).ready(function(){
	if($('#canvasimg').hasClass('F')){
		outlineImage.src="img/taccuino/female_front_.png";	
		outlineImageBack.src="img/taccuino/female_back_.png";	
	}else{
		outlineImage.src="img/taccuino/male_front_.png";	
		outlineImageBack.src="img/taccuino/male_back_.png";	
	}
	outlineImage.onload=function(){
	prepareCanvas("");  
	save_dolore("");	
	}
	
	outlineImageBack.onload=function(){
	prepareCanvas("_back");  
	save_dolore("_back");	
	}
	
	$('#canvas_dolore_back').hide();
});	

function toggleBackFront(){
	if($('#canvas_dolore_back').is(":visible")){
		$('#canvas_dolore_back').hide();
		$('#canvas_dolore').show();
	}else{
		$('#canvas_dolore').hide();
		$('#canvas_dolore_back').show();		
	}
	
}
	
function prepareCanvas(fb){
	//console.log("Canvas: " + 'canvas_dolore' + fb);
	if(fb == "_back"){
		canvasback = document.getElementById('canvas_dolore'+fb);
		ctxback = canvasback.getContext("2d");
		ctxback.fillStyle="#00ff00";
		
		w = canvasback.width;
		h = canvasback.height;
		ctxback.fillRect(0,0,w,h);
		
		ctxback.drawImage(outlineImageBack, 0, 0, w, h);
		
	}else{
		canvas = document.getElementById('canvas_dolore'+fb);
		ctx = canvas.getContext("2d");
		ctx.fillStyle="#00ff00";
		w = canvas.width;
		h = canvas.height;
		ctx.fillRect(0,0,w,h);
		ctx.drawImage(outlineImage, 0, 0, w, h);
	}

	$("#canvas_dolore"+fb).mousemove(function (e) {
        findxy('move', e, fb);});
	$("#canvas_dolore"+fb).mousedown(function (e) {
        findxy('down', e, fb);});
	$("#canvas_dolore"+fb).mouseup(function (e) {
        findxy('up', e, fb);});
	$("#canvas_dolore"+fb).mouseout(function (e) {
        findxy('out', e, fb);});
	

}
	


function findxy(res, e, fb) {
    if(fb == "_back"){
		if (res == 'down') {
			prevXback = currXback;
			prevYback = currYback;
			currXback = e.offsetX;// - canvas.offsetLeft;
			currYback = e.offsetY;// - canvas.offsetTop;

			flagback = true;
			dot_flagback = true;
			if (dot_flagback) {
				ctxback.beginPath();
				ctxback.fillStyle = colorepennello;
				ctxback.fillRect(currXback, currYback, 0, 0);
				ctxback.closePath();
				dot_flagback = false;
			}
		}
		if (res == 'up' || res == "out") {
			flagback = false;
		}
		if (res == 'move') {
			if (flagback) {
				prevXback = currXback;
				prevYback = currYback;
				currXback = e.offsetX;// - canvas.offsetLeft;
				currYback = e.offsetY;// - canvas.offsetTop;
				draw(fb);
			}
		}
	}else{
		if (res == 'down') {
			prevX = currX;
			prevY = currY;
			currX = e.offsetX;// - canvas.offsetLeft;
			currY = e.offsetY;// - canvas.offsetTop;

			flag = true;
			dot_flag = true;
			if (dot_flag) {
				ctx.beginPath();
				ctx.fillStyle = colorepennello;
				ctx.fillRect(currX, currY, 0, 0);
				ctx.closePath();
				dot_flag = false;
			}
		}
		if (res == 'up' || res == "out") {
			flag = false;
		}
		if (res == 'move') {
			if (flag) {
				prevX = currX;
				prevY = currY;
				currX = e.offsetX;// - canvas.offsetLeft;
				currY = e.offsetY;// - canvas.offsetTop;
				draw(fb);
			}
		}
	}
}

function draw(fb) {
	if(fb == "_back"){
		ctxback.beginPath();
		ctxback.moveTo(prevXback, prevYback);
		ctxback.lineTo(currXback, currYback);
		ctxback.strokeStyle = colorepennello;
		ctxback.lineWidth = dimpennello;
		ctxback.lineJoin = 'round';
		ctxback.lineCap = 'round';
		 
		//ctxback.stroke();
		//ctxback.closePath();
		
		//ctxback.clearRect(0, 0, w, h);
		
		ctxback.stroke();
		ctxback.closePath();
		
		ctxback.drawImage(outlineImageBack, 0, 0, w, h);
	}else{
		
		ctx.beginPath();
		ctx.moveTo(prevX, prevY);
		ctx.lineTo(currX, currY);
		ctx.strokeStyle = colorepennello;
		ctx.lineWidth = dimpennello;
		ctx.lineJoin = 'round';
		ctx.lineCap = 'round';
		
		
		//ctx.clearRect(0, 0, w, h);
		
		ctx.stroke();
		ctx.closePath();
		
		ctx.drawImage(outlineImage, 0, 0, w, h);
	}
}
	
function color_dolore(obj) {
	colorepennello=obj;
}


function erase_dolore() {
    var m = confirm("Cancellare tutte le modifiche?");
    if (m) {
		ctx.fillStyle="#00ff00";
		ctx.fillRect(0,0,w,h);
		ctx.drawImage(outlineImage, 0, 0);
    }
}

function erase_dolore_back() {
    var m = confirm("Cancellare tutte le modifiche?");
    if (m) {
		ctxback.fillStyle="#00ff00";
		ctxback.fillRect(0,0,w,h);
		ctxback.drawImage(outlineImageBack, 0, 0);
    }
}

function save_dolore(fb) {
    if(fb == "_back"){
		//document.getElementById("canvasimg"+fb).style.border = "2px solid";
		var dataURL = canvasback.toDataURL();
		document.getElementById("canvasimg"+fb).src = dataURL;
	}else{
		//document.getElementById("canvasimg"+fb).style.border = "2px solid";
		var dataURL = canvas.toDataURL();
		document.getElementById("canvasimg"+fb).src = dataURL;
	}
	
    //document.getElementById("canvasimg").style.display = "inline";
}

$('.showPain').click(function(){
		var idShow = $(this).attr('id').split('_')[1]
		
		//document.getElementById("canvasimg").style.border = "2px solid";
		document.getElementById("canvasimg_back").src = $('#painBack_'+idShow).val();
		document.getElementById("canvasimg").src = $('#painFront_'+idShow).val();
		//document.getElementById("canvasimg_back").style.border = "2px solid";
		
		
});
//save all data in the db
function save_pain() {
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		//document.getElementById("canvasimg").style.border = "2px solid";
		var dataURLFront = canvas.toDataURL('image/png');
		
		//document.getElementById("canvasimg_back").style.border = "2px solid";
		var dataURLBack = canvasback.toDataURL('image/png');
		
		if($('#save_pain_textarea').val() == '')
			$('#save_pain_textarea').val('Nessun commento.');
		
		$.ajax({
        url: "/pazienti/taccuino/addReporting",
        method: "POST",
        headers: {
      		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
        data: {_token: CSRF_TOKEN, description: "$('#save_pain_textarea').val()"},
        dataType: "json",
        success: function(response){
            $("#preview").html(
                $("<img>").attr("src", response.filename)
            );
        }
    });		
}

function getFront(){
	prepareCanvas("");
	return canvas.toDataURL('image/png');
}
function getBack(){
	prepareCanvas("_back");
	return canvasback.toDataURL('image/png');
}

//delete data from the db
$('.removePain').click(function(){
		var idDelete = $(this).attr('id').split('_')[1];
		
		$.post("formscripts/deleteTaccuino.php", 
			{
				id: idDelete
			},
			function(data,status){
				//alert(data + status);
				$('#canvasModal').modal('hide');
				location.reload();
			}
		);
		
});