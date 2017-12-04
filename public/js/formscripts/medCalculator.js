function calcolaDose()
{
	dose = document.getElementById("dose").value;
	dosemq = document.getElementById("dose_mq").value;
	peso = document.getElementById("peso").value;
	altezza = document.getElementById("altezza").value;
	supCorporea = Math.sqrt( (altezza * peso ) / 3600 );
	
	nSomm = document.getElementById("somministrazioni").value;
	if (dose != 0)
		doseTot =(peso * dose);
	else
		doseTot =  Math.round(supCorporea * dosemq);
	
	result = "&nbsp &nbsp" + doseTot;
	
	risultato = document.getElementById("doseCalcolata");
	risultato.innerHTML =  result;
	if (nSomm == 0)
		nSomm = 1;
	//singSomm = (peso * dose) / nSomm; 
	singSomm = Math.round(doseTot / nSomm); 
	somministrazione =  document.getElementById("singSomm");
	somministrazione.innerHTML = singSomm;
}

function cancella(){
	document.getElementById("dose").value = "";
	//peso = document.getElementById("peso");
	risultato =  document.getElementById("doseCalcolata");
	somministrazione =  document.getElementById("singSomm");
	somministrazione.innerHTML = "";
	risultato.innerHTML =  "";
}

function calcolaVel(){
	//peso = document.getElementById("pesoVel").value; // kg
	peso = document.getElementById("peso").value;
	doseDaInf = document.getElementById("doseDaInf").value; // microgrammi/kg/min
	doseFiala = document.getElementById("doseFiala").value; // valore in mg
	num_fiale =	document.getElementById("num_fiale").value; // numero intero
	volFlebo =	document.getElementById("volFlebo").value;	//volome in millilitri
	
	concentrazione = document.getElementById("concentrazione");
	velInfusione   = document.getElementById("velInfusione");
	
	conc = ( doseFiala * num_fiale) / volFlebo; // mg /ml
	velInf = Math.round ((peso * doseDaInf * 60 )/(conc * 1000) ); // ml/ora
	
	concentrazione.innerHTML = "&nbsp &nbsp" + conc + "&nbsp &nbsp";
	velInfusione.innerHTML = "&nbsp &nbsp" + velInf + "&nbsp &nbsp";
	
}

function cancellaVel(){
	document.getElementById("dose").value = "";
	concentrazione = document.getElementById("concentrazione");
	velInfusione   = document.getElementById("velInfusione");
	
	document.getElementById("doseDaInf").value= ""; // microgrammi/kg/min
	document.getElementById("doseFiala").value = ""; // valore in mg
	document.getElementById("num_fiale").value = 1; // numero intero
	document.getElementById("volFlebo").value = 250;
	concentrazione.innerHTML = "";
	velInfusione.innerHTML =  "";
}
/*Uomini  VFG = (140-età) x peso ideale (kg) / (72 x Creatininemia)
Donne  VFG = idem x 0,85 
Nella formula sopra riportata è specificato “peso ideale” (peso ideale = BMI ideale per quadrato dell’altezza in metri

http://www.torrinomedica.it/studio/vfg.asp#axzz3utmtikPU */
function calcolaCreat(){
	//altezza = document.getElementById("altezzaCreat").value;
	altezza = document.getElementById("altezza").value;
	eta 	= document.getElementById("eta").value;
	sesso	= document.getElementById("sesso").value;
	creat   = document.getElementById("creatininemia").value;
	
	peso_ideale = 23 * Math.pow( altezza/100, 2) ;
	
	VFG =  ((( 140 - eta ) * peso_ideale ) / ( 72 * creat) ) ;
	
	creatClear = document.getElementById("creatClear");
	
	if ( document.getElementById("sesso").value == "F")
	VFG	 = VFG * 0.85;
	
	VFG = Math.round( VFG ) ;
	creatClear.innerHTML = "&nbsp &nbsp" + VFG +"&nbsp &nbsp"  ;
}

function cancellaCreat(){
	
	document.getElementById("creatininemia").value = 1;
	creatClear = document.getElementById("creatClear");
	creatClear.innerHTML ="";
	
}

function calcolaCreat1(){
	
	creatininemia   = document.getElementById("creatininemia").value;
	creatininuria	= document.getElementById("creatininuria").value;
	diuresi 		= document.getElementById("diuresi").value;
	
	VFG =  Math.round((creatininuria * diuresi )/( creatininemia * 1440 ) ) ;
	
	creatClear = document.getElementById("creatClear1");
	
	VFG = Math.round( VFG ) ;
	creatClear.innerHTML = "&nbsp &nbsp" + VFG +"&nbsp &nbsp"  ;
}

function cancellaCreat1(){	
	creatClear = document.getElementById("creatClear1");
	document.getElementById("creatininemia1").value = 1;
	document.getElementById("creatininuria").value = 1;
	document.getElementById("diuresi").value = 0;
	creatClear.innerHTML ="";
	
}

/*funzione che chiede in input il volume in ml, il contenuto in mg di una soluzione il numero di gocce contenute in un ml e la posologia da somministrare
Calcola la  concentrazione  in mg/ml il numero di ml e le gocce da somministrare*/
function calcolaMl(){
	
	cont_Sol   		= document.getElementById("Cont_Sol").value;
	
	vol_Sol			= document.getElementById("Vol_Sol").value;
	posologiaMg 	= document.getElementById("posologiaMg1").value;
	goccePerMl		= document.getElementById("goccePerMl").value;
	
	
	concSol 		= cont_Sol / vol_Sol ; // calcolo la concentrazione in mg/ml
	mlDaSomm 		= posologiaMg / concSol; // calcolo i ml da somministrae
	gocceDaSomm		= mlDaSomm * goccePerMl; // calcolo il numero di gocce da somministrae
	
	n_millilitri = document.getElementById("N_millilitri");
	n_gocce = document.getElementById("N_gocce");
	
	
	n_millilitri.innerHTML = "&nbsp &nbsp" + mlDaSomm +"&nbsp &nbsp"  ;
	n_gocce.innerHTML = "&nbsp &nbsp" + gocceDaSomm +"&nbsp &nbsp"  ;
	
}

function cancellaMl(){	
	
	n_millilitri = document.getElementById("N_millilitri");
	n_gocce = document.getElementById("N_gocce");
	
	cont_Sol   		= document.getElementById("Cont_Sol").value = 1;
	vol_Sol			= document.getElementById("Vol_Sol").value = 1;
	posologiaMg 	= document.getElementById("posologiaMg1").value = 1;
	
	n_millilitri.innerHTML = "__"  ;
	n_gocce.innerHTML = ""  ;
	
}
