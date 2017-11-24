//funzione pulsante ANNULLA 
function annulla_anfis(form,btn){
"use_strict";
	document.getElementById(form).reset();
	$('#'+form+' :enabled').attr('disabled', true);
	$('#annulla'+btn).remove();
	$('#'+btn).html('<i class="icon-pencil icon-white"></i> Modifica');
}

//funzione per la generazione dei pulsanti SALVA + MODIFICA
function btn_anfis_sm(btn,div,form){
"use_strict";	
	if ($('#'+btn).html()=='<i class="icon-pencil icon-white"></i> Modifica'){
		$('#'+div).collapse('show');
		$('#'+btn).html('<i class="icon-save"></i> Salva');
		$('#'+btn).blur();
		$('#'+btn).parent().parent().append('<li><a href="javascript:annulla_anfis(\''+form+'\',\''+btn+'\');" id="annulla'+btn+'"><i class="icon-remove-sign"></i> Annulla</a></li>');
		$('#'+form+' :disabled').attr('disabled', false);
	} 
	else {
		//TODO: chiamare funzione SUBMIT
		$('#'+form+' :enabled').attr('disabled', true);
		$('#annulla'+btn).remove();
		$('#'+btn).html('<i class="icon-pencil icon-white"></i> Modifica');
	}
}

$(document).ready(function(){

	//---espandi/riduci tutti
	$('#espanditutti').click(function(){
		if($('#espanditutti').val()!='aperto')
		{
			$('#div-infanzia').collapse('show');
			$('#div-puberta').collapse('show');
			$('#div-matrimonio').collapse('show');
			$('#div-gravidanze').collapse('show');
			$('#div-sessualita').collapse('show');
			$('#div-menopausa').collapse('show');
			$('#div-stilivita').collapse('show');
			$('#div-alvo').collapse('show');
			$('#div-lavoro').collapse('show');
			$('#div-personalita').collapse('show');
			$('#espanditutti').val('aperto');
		}
		else {
			$('#div-infanzia').collapse('hide');
			$('#div-puberta').collapse('hide');
			$('#div-matrimonio').collapse('hide');
			$('#div-gravidanze').collapse('hide');
			$('#div-sessualita').collapse('hide');
			$('#div-menopausa').collapse('hide');
			$('#div-stilivita').collapse('hide');
			$('#div-alvo').collapse('hide');
			$('#div-lavoro').collapse('hide');
			$('#div-personalita').collapse('hide');
			$('#espanditutti').val('chiuso');
		}
	});
	
	//--click pulsante MODIFICA
	$('#btninfanzia').click(function(){
		btn_anfis_sm('btninfanzia','div-infanzia','forminfanzia');
		});
		
	$('#btnpuberta').click(function(){
		btn_anfis_sm('btnpuberta','div-puberta','formpuberta');
		});
		
	$('#btnmatrimonio').click(function(){
		btn_anfis_sm('btnmatrimonio','div-matrimonio','formmatrimonio');
		});
		
	$('#btnsessualita').click(function(){
		btn_anfis_sm('btnsessualita','div-sessualita','formsessualita');
		});
	
	$('#btnmenopausa').click(function(){
		btn_anfis_sm('btnmenopausa','div-menopausa','formmenopausa');
		});
		
	$('#btnstilivita').click(function(){
		btn_anfis_sm('btnstilivita','div-stilivita','formstilivita');
		});
		
	$('#btnalvo').click(function(){
		btn_anfis_sm('btnalvo','div-alvo','formalvo');
		});
	
	$('#btnlavoro').click(function(){
		btn_anfis_sm('btnlavoro','div-lavoro','formlavoro');
		});
		
	$('#btnpersonalita').click(function(){
		btn_anfis_sm('btnpersonalita','div-personalita','formpersonalita');
		});
	
	/*
	//--SUBMIT FORM
    $('#modpatdonorg').submit(function(){
		$.post("formscripts/modpatdonorg.php",
			{
				patdonorg:	function(){
								if ($("#negpatdonorg").prop("checked")) return false;
								else return true;
							}		
			},
  			function(status){
				//$('#modpatinfo')[0].reset();
    			alert("Status: " + status);
				$('#modpatdonorgmodal').modal('hide');
				location.reload();
  			});
    });
	*/	



});
