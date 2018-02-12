<?php
//NB crea il report per l'utente . In caso di modifiche le stesse  vanno  apportate a createPDFcareProvider che crea il report per il careprovider
include ('Utility.php');
include ('Login/Session.php'); 


foreach (glob("Security Framework/*.php") as $filename)
    include $filename;

foreach (glob("Security Framework/Algoritmi/*.php") as $filename)
    include $filename;

 include("graphic/pChart/pData.class");
 include("graphic/pChart/pChart.class");   
//$id è l'$idutente corrispondente all'$id della sessione
function createReport($id, $typeExam = null, $version = null){
                          	
          /**
          * 
	*  Funzione che crea il report clinico di un paziente filtrando i dati in base ai livelli di visibilitÃ 
	* 
	* @param id
	* @return true
	*/

	// estrazione informazioni
	
	if (!isLogged())
	{
		echo "Ripetere il login";
		return false;
	}
	
	$myRole = getDescription(getMyID());
	$maxConfidentiality = 0;
    		
    /*	if(defaultPermissions(getMyID()))
          	$maxConfidentiality = INF;*/
		
	if(defaultPermissions($id))
          	$maxConfidentiality = INF;
	
	//$hospital = getInfo('nome', 'ospedali', 'id = ' . $ospedale);
	$title = 'Report clinico';
	$date = date('d-m-Y', strtotime($date));
	
	$pdf = new PDF_MemImage();
	$pdf -> AliasNbPages();
	$pdf -> AddPage();

	// TITOLO 
	$pdf -> SetFont('courier','B',25);
	$pdf -> Cell(70,10, $title);
	$pdf -> Ln(20);
	
	
	// SEZIONE PARAMETRI VITALI
          $confPatSummary = INF;
   	if ($maxConfidentiality == 0)
	{	$confPatSummary = policyInfo('Patient Summary', 'Confidenzialita'); 
		//deve essere rivista la funzione policyInfo e tolta la riga successiva 
		$confPatSummary = 6;
	}
  	
	if ($confPatSummary >= 3){
		// PATIENT SUMMARY
		$nome = decryptData(deserializeData(getInfo('nome', 'pazienti', 'idutente = ' . $id)));
	          $cognome = decryptData(deserializeData(getInfo('cognome', 'pazienti', 'idutente = ' . $id)));
	          $cf = decryptData(deserializeData(getInfo('codicefiscale','utenti', 'id = ' . $id)));
	          $dataNascita = decryptData(deserializeData(getInfo('datanascita', 'pazienti', 'idutente = ' . $id)));
	          $age = getAge($dataNascita);
		$dataNascita = italianFormat($dataNascita);
		
		$gruppoSanguignoData = deserializeData(getInfo('grupposanguigno', 'pazienti', 'idutente = ' . $id));
	    	$gruppoSanguigno = decryptData($gruppoSanguignoData);
	    	$gruppoSangConf = $gruppoSanguignoData -> getConfidentiality();
	   	
	    	
	          // NOME
	          $pdf -> SetFont('courier','',8);
	          $pdf -> Cell(35,5,'Nome ',0,0,"L");
	    
	          $pdf -> SetFont('courier','B',8);
	          $pdf -> Cell(35,5,$nome,0,1,"L");
	          
	          // COGNOME
	          $pdf -> SetFont('courier','',8);
	          $pdf -> Cell(35,5,'Cognome ',0,0,"L");
	    
	          $pdf -> SetFont('courier','B',8);
	          $pdf -> Cell(35,5,$cognome,0,1,"L");
	          
	          // GRUPPO SANGUIGNO
    	
    		$pdf -> SetFont('courier','',8);
          	$pdf -> Cell(35,5,'Gruppo sanguigno',0,0,"L");
    
          	$pdf -> SetFont('courier','B',8);
          	$pdf->SetTextColor(194,8,8);
          	$pdf -> Cell(50,5,$gruppoSanguigno,0,1,"L");	
          	$pdf->SetTextColor(0,0,0);	
	
          
	          // CODICE FISCALE
	          $pdf -> SetFont('courier','',8);
	          $pdf -> Cell(35,5,'Codice fiscale ',0,0,"L");
	    
	          $pdf -> SetFont('courier','B',8);
	          $pdf -> Cell(35,5,$cf,0,1,"L");
	          
	          // DATA DI NASCITA
	          $pdf -> SetFont('courier','',8);
	          $pdf -> Cell(35,5,'Data di nascita ',0,0,"L");
	    
	          $pdf -> SetFont('courier','B',8);
	          if ($age == 1) $ageLabel = "  -  1 anno";
	          	else
	          $ageLabel =  "  -  " . $age . " anni";
	          
	          $pdf -> Cell(35,5,$dataNascita . $ageLabel,0,1,"L");
           }

	// CREAZIONE INDICE
	$pdf -> Ln(10);
	$pdf -> SetFont('courier','B',15);
	$pdf -> Cell(150,8,"Indice",0,1,'L');

	$linkAnamFam = $pdf->AddLink();
	$pdf->Image($_SERVER['DOCUMENT_ROOT'].'assets/img/Anamnesi familiare.jpg',10,108,40,40,'JPG',$linkAnamFam);
          
          $linkAnamFis = $pdf->AddLink();
	$pdf->Image($_SERVER['DOCUMENT_ROOT'].'assets/img/Anamnesi fisiologica.jpg',60,108,40,40,'JPG',$linkAnamFis);
	
	$linkAnamPat = $pdf->AddLink();
	$pdf->Image($_SERVER['DOCUMENT_ROOT'].'assets/img/Anamnesi patologica.jpg',110,108,40,40,'JPG',$linkAnamPat);
	
	$linkParamVit = $pdf->AddLink();
	$pdf->Image($_SERVER['DOCUMENT_ROOT'].'assets/img/Parametri vitali.jpg',160,108,40,40,'JPG',$linkParamVit);
	
	$linkTerapie = $pdf->AddLink();
	$pdf->Image($_SERVER['DOCUMENT_ROOT'].'assets/img/Terapie farm.jpg',10,170,40,40,'JPG',$linkTerapie);
	
	$linkLaboratorio = $pdf->AddLink();
	$pdf->Image($_SERVER['DOCUMENT_ROOT'].'assets/img/Laboratorio.jpg',60,170,40,40,'JPG',$linkLaboratorio);
          
          $pdf -> SetFont('courier','',9);
          $pdf -> Ln(45);
          $pdf -> Cell(50,5,'Anamnesi familiare',0,0,"L",false,$linkAnamFam);
          $pdf -> Cell(50,5,'Anamnesi fisiologica',0,0,"L",false,$linkAnamFis);
          $pdf -> Cell(50,5,'Anamnesi patologica',0,0,"L",false,$linkAnamPat);
          $pdf -> Cell(50,5,'Visite',0,1,"L",false,$linkParamVit);
          
          $pdf -> Ln(57);
          $pdf -> Cell(50,5,'Terapie farmacologiche',0,0,"L",false,$linkTerapie);
          $pdf -> Cell(50,5,'Indagini diagnostiche',0,0,"L",false,$linkLaboratorio);
          
          // PERMESSI PER ANAMNESI FAMILIARE
          $confAnamFam = INF;
   	if ($maxConfidentiality == 0)
          	$confAnamFam = policyInfo('Anamnesi familiare', 'Confidenzialita'); 
          
          	
          	
          	// ANAMNESI FAMILIARE
		$pageName = 'Anamnesi familiare';
		$pdf -> PrintFoglio($pageName);
		$pdf -> SetLink($linkAnamFam);
		 
         
         $testoFam = getInfo('familiare', 'anamnesiFamiliare', 'idpaziente = ' . $id);
         $aggFam = italianFormat(getInfo('dataAggiornamento','anamnesiFamiliare','idpaziente = ' . $id));
         $pdf -> Ln(10);
         $pdf -> SetFont('courier','B',12);
 		 $pdf -> Cell(100,7,'Testo anamnesi familiare - ',0,0,"R");
         $pdf -> SetFont('courier','',10);
         $pdf->MultiCell(0,7, 'Ultimo aggiornamento: '. $aggFam,0,"L");
         $pdf -> SetFont('courier','B',9);
   	     $pdf -> Cell(0,7,'___________________________________________________________________________________________________',0,1,"C");
         $pdf -> Ln(2);
         $pdf -> SetFont('courier','',9);
         $pdf -> MultiCell(0,5,$testoFam,0,"J");
         	
         
		
	
	
	

	
          // PERMESSI PER ANAMNESI FISIOLOGICA
          $confAnamFis= INF;
   	if ($maxConfidentiality == 0)
          	$confAnamFis = policyInfo('Anamnesi fisiologica', 'Confidenzialita'); 
            
           

          // ESTRAZIONE DATI
          $id2 = getInfo('id', 'anamnesiFisiologica', 'idpaziente = ' . $id);
          
          
          
          
	
		// ANAMNESI FISIOLOGICA
		$pageName = 'Anamnesi fisiologica';
		$pdf -> PrintFoglio($pageName);
		$pdf -> SetLink($linkAnamFis);
        
        
        $pdf -> Ln(7);
        $pdf -> SetFont('courier','B',12);
        $aggFis = italianFormat(getInfo('dataAggiornamento', 'anamnesiFisiologica', 'id = ' . $id2)); 
        $pdf->MultiCell(0,10, 'Ultimo aggiornamento: '. $aggFis,0,"C");
        $pdf -> Ln(4);
        
        //INFANZIA
        $pdf -> SetFont('courier','B',11);
        $pdf -> Cell(25,7,'Infanzia',0,1,"L");
        
       	$tempoparto = getInfo('tempoParto', 'anamnesiFisiologica', 'id = ' . $id2);
        $tipoparto = getInfo('tipoParto', 'anamnesiFisiologica', 'id = ' . $id2);
        $allattamento = getInfo('allattamento', 'anamnesiFisiologica', 'id = ' . $id2);
        $sviluppoVegRel = getInfo('sviluppoVegRel', 'anamnesiFisiologica', 'id = ' . $id2);
        $noteInfanzia = getInfo('noteInfanzia', 'anamnesiFisiologica', 'id = ' . $id2);
		
			
		

	// STAMPA ANAMNESI FISIOLOGICA
	$section1 = 0;
	$section2 = 0;
	$section3 = 0;
	$section4 = 0;
    $section5 = 0;
    $section6 = 0;
    $section7 = 0;
	
		$section1 = 1;
	
		if ($tempoparto != '' || $tipoparto != ''){
	          	$pdf -> SetFont('courier','',9);
	          	$pdf -> Cell(65,5,'Nato da parto ',0,0,"L");
	          	$pdf -> SetFont('courier','B',9);
	          	$pdf -> Cell(65,5,$tempoparto.' '.$tipoparto,0,1,"L");
	          	$section1 = 1;
          	}
          
          	if ($allattamento != ''){
			$pdf -> SetFont('courier','',9);
	          	$pdf -> Cell(65,5,'Allattamento ',0,0,"L");
	          	$pdf -> SetFont('courier','B',9);
	          	$pdf -> Cell(65,5,$allattamento,0,1,"L");
	          	$section1 = 1;
		}
          	
          	
          	if ($sviluppoVegRel != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Sviluppo vegetativo e relazionale ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $sviluppoVegRel,0,1,"L");
          		$section1 = 1;
		}
		
        if ($noteInfanzia != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Note infanzia ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $noteInfanzia,0,1,"L");
          		$section1 = 1;
		}
	
    $pdf -> SetFont('courier','',9);
		
		if ($section1 ==1)
			$pdf -> Cell(20,5,'------------------------------------------------------------------------------',0,1,"L");
            
            
            
      //SCOLARITA'
        $pdf -> Ln(2);
        $pdf -> SetFont('courier','B',11);
        $pdf -> Cell(25,7,'Scolarità ',0,1,"L");
      $livelloScol = getInfo('livelloScol', 'anamnesiFisiologica', 'id = ' . $id2); 
      
          $section2 = 1; 
      if ($livelloScol != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Livello scolastico ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $livelloScol,0,1,"L");
          		$section2 = 1;
		}      
            
      $pdf -> SetFont('courier','',9);
		
		if ($section2 ==1)
			$pdf -> Cell(20,5,'------------------------------------------------------------------------------',0,1,"L");    	
     //STILE DI VTA
      $pdf -> Ln(2);
        $pdf -> SetFont('courier','B',11);
        $pdf -> Cell(25,7,'Stile di vita ',0,1,"L");
      $attivitaFisica = getInfo('attivitaFisica', 'anamnesiFisiologica', 'id = ' . $id2);
      $abitudAlim = getInfo('abitudAlim', 'anamnesiFisiologica', 'id = ' . $id2);
      $ritmoSV = getInfo('ritmoSV', 'anamnesiFisiologica', 'id = ' . $id2);
      $fumo = getInfo('fumo', 'anamnesiFisiologica', 'id = ' . $id2);
      $freqFumo = getInfo('freqFumo', 'anamnesiFisiologica', 'id = ' . $id2);
      $alcool = getInfo('alcool', 'anamnesiFisiologica', 'id = ' . $id2);
      $freqAlcool = getInfo('freqAlcool', 'anamnesiFisiologica', 'id = ' . $id2);
      $droghe = getInfo('droghe', 'anamnesiFisiologica', 'id = ' . $id2);
      $freqDroghe = getInfo('freqDroghe', 'anamnesiFisiologica', 'id = ' . $id2);
      $noteStileVita = getInfo('noteStileVita', 'anamnesiFisiologica', 'id = ' . $id2);   
      
      $section3 = 1;
      if ($attivitaFisica != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Attività fisica ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $attivitaFisica,0,1,"L");
          		$section3 = 1;
		}
        
        if ($abitudAlim != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Abitudini alimentari ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $abitudAlim,0,1,"L");
          		$section3 = 1;
		}
        
        if ($ritmoSV != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Ritmo sonno veglia ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $ritmoSV,0,1,"L");
          		$section3 = 1;
		}
        
        if ($fumo != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Fumatore ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $fumo,0,1,"L");
          		$section3 = 1;
		}
        
        if($fumo == 'si'){
            if ($freqFumo != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Frequenza/Quantità sigarette ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $freqFumo,0,1,"L");
          		$section3 = 1;
		}
        }
        
        if ($alcool != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Uso alcolici ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $alcool,0,1,"L");
          		$section3 = 1;
		}
        
        if($alcool == 'si'){
            if ($freqAlcool != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Frequenza/Quantità alcool ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $freqAlcool,0,1,"L");
          		$section3 = 1;
		}
        }
        
        if ($droghe != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Uso droghe ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $droghe,0,1,"L");
          		$section3 = 1;
		}
        
        if($droghe == 'si'){
            if ($freqDroghe != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Frequenza/Quantità droghe ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $freqDroghe,0,1,"L");
          		$section3 = 1;
		}
        }
        
        if ($noteStileVita != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Note stile di vita ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(0,5, $noteStileVita,0,1,"L");
          		$section3 = 1;
		}
         
      $pdf -> SetFont('courier','',9);
		
		if ($section3 ==1)
			$pdf -> Cell(20,5,'------------------------------------------------------------------------------',0,1,"L");        
            
            
        //CICLO MESTRUALE
        $sessoPazient = decryptData(deserializeData(getInfo('sesso', 'pazienti', 'idutente = ' .  $id )));
        if($sessoPazient == "F"){
            $pdf -> Ln(2);
        $pdf -> SetFont('courier','B',11);
        $pdf -> Cell(25,7,'Ciclo mestruale ',0,1,"L");
      $etaMenarca = getInfo('etaMenarca', 'anamnesiFisiologica', 'id = ' . $id2); 
      $ciclo = getInfo('ciclo', 'anamnesiFisiologica', 'id = ' . $id2); 
      $etaMenopausa = getInfo('etaMenopausa', 'anamnesiFisiologica', 'id = ' . $id2); 
      $menopausa = getInfo('menopausa', 'anamnesiFisiologica', 'id = ' . $id2); 
      $noteCicloMes = getInfo('noteCicloMes', 'anamnesiFisiologica', 'id = ' . $id2); 
      
        $section4 = 1;   
      if ($etaMenarca != 0){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Età menarca ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $etaMenarca,0,1,"L");
          		$section4 = 1;
		}   
        
        if ($ciclo != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Ciclo ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $ciclo,0,1,"L");
          		$section4 = 1;
		}
        
         if ($etaMenopausa != 0){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Età menopausa ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $etaMenopausa,0,1,"L");
          		$section4 = 1;
		}
        
        if ($menopausa != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Menopausa ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $menopausa,0,1,"L");
          		$section4 = 1;
		}
        
        if ($noteCicloMes != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Note ciclo mestruale ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(0,5, $noteCicloMes,0,1,"L");
          		$section4 = 1;
		}
         
            
      $pdf -> SetFont('courier','',9);
		
		if ($section4 ==1)
			$pdf -> Cell(20,5,'------------------------------------------------------------------------------',0,1,"L");   
            
          
        }
            
        
        
        
      // GRAVIDANZE
		$idArray = getArray('id', 'gravidanze', 'idpaziente = ' . $id);
		
		if (!empty($idArray)){
			$pdf -> Ln(7);
			$pdf -> SetFont('courier','B',11);
          		$pdf -> Cell(45,5,'Dettaglio gravidanze ',0,0,"L");
          		
          		$section7 = 1;
          		
			$pdf -> Ln(7);
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(20,5,'Età',0,0,"L");
          		$pdf -> Cell(25,5,'Inizio',0,0,"L");
			$pdf -> Cell(25,5,'Fine',0,0,"L");
			$pdf -> Cell(20,5,'Esito',0,0,"L");
			$pdf -> Cell(20,5,'Sesso',0,0,"L");
			$pdf -> Cell(35,5,'Note',0,1,"L");
			
			$pdf -> SetFont('courier','',9);
			$pdf -> Cell(20,5,'______________________________________________________________________________',0,1,"L");
			
			foreach($idArray as $ida){
				
				$eta = getInfo('eta', 'gravidanze', 'id = ' . $ida);
				$inizio = italianFormat(getInfo('inizio', 'gravidanze', 'id = ' . $ida));
				$fine = italianFormat(getInfo('fine', 'gravidanze', 'id = ' . $ida));
				$esito = getInfo('esito', 'gravidanze', 'id = ' . $ida);
				$sesso = getInfo('sesso', 'gravidanze', 'id = ' . $ida);
				$note = getInfo('note', 'gravidanze', 'id = ' . $ida);
				
				$pdf -> Cell(20,5,$eta,0,0,"L");
 			    $pdf -> Cell(25,5,$inizio,0,0,"L");
				$pdf -> Cell(25,5,$fine,0,0,"L");
				$pdf -> Cell(20,5,$esito,0,0,"L");
				$pdf -> Cell(20,5,$sesso,0,0,"L");
				$pdf -> Cell(35,5,$note,0,1,"L");
				
			}
            if ($section4 ==1)
            $pdf -> SetFont('courier','B',9);
			$pdf -> Cell(20,5,'------------------------------------------------------------------------------',0,1,"L");  
		}  // FINE GRAVIDANZE
      
      
      //ATTIVITA' LAVORATIVA
        $pdf -> Ln(2);
        $pdf -> SetFont('courier','B',11);
        $pdf -> Cell(25,7,'Attività lavorativa ',0,1,"L");
      $professione = getInfo('professione', 'anamnesiFisiologica', 'id = ' . $id2); 
      $noteAttLav = getInfo('noteAttLav', 'anamnesiFisiologica', 'id = ' . $id2); 
        
        $section5 = 1;   
      if ($professione != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Professione ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $professione,0,1,"L");
          		$section5 = 1;
		} 
        
             
      if ($noteAttLav != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Note lavoro ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $noteAttLav,0,1,"L");
          		$section5 = 1;
		}     
            
      $pdf -> SetFont('courier','',9);
		
		if ($section5 ==1)
			$pdf -> Cell(20,5,'------------------------------------------------------------------------------',0,1,"L");    	
            
       //ALVO E MINZIONE
        $pdf -> Ln(2);
        $pdf -> SetFont('courier','B',11);
        $pdf -> Cell(25,7,'Alvo e minzione ',0,1,"L");
      $alvo = getInfo('alvo', 'anamnesiFisiologica', 'id = ' . $id2); 
      $minzione = getInfo('minzione', 'anamnesiFisiologica', 'id = ' . $id2);
      $noteAlvoMinz = getInfo('noteAlvoMinz', 'anamnesiFisiologica', 'id = ' . $id2); 
           
           $section6 = 1;
           
      if ($alvo != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Alvo ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $alvo,0,1,"L");
          		$section6 = 1;
		} 
        
             
      if ($minzione != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Minzione ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(65,5, $minzione,0,1,"L");
          		$section6 = 1;
		}  
        
        if ($noteAlvoMinz != ''){
			$pdf -> SetFont('courier','',9);
          		$pdf -> Cell(65,5,'Note alvo e minzione ',0,0,"L");
          		$pdf -> SetFont('courier','B',9);
          		$pdf -> Cell(0,5, $noteAlvoMinz,0,1,"L");
          		$section6 = 1;
		}   
            
      $pdf -> SetFont('courier','',9);
		
		if ($section6 ==1)
			$pdf -> Cell(20,5,'------------------------------------------------------------------------------',0,1,"L");    	     
            
           
            
          	
		
		
		
		
     $section8 = 0;   		
	
	
	// ANAMNESI PATOLOGICA REMOTA
    $confAnam = INF;
   	if ($maxConfidentiality == 0)
          	$confAnam = policyInfo('Diagnosi', 'Confidenzialita');
            
    $testoPatRem = getInfo('remota', 'anamnesiPatologica', 'idpaziente = ' . $id);
    if($testoPatRem != ''){
        
        $pageName = 'Anamnesi Patologica Remota';
	$pdf -> PrintFoglio($pageName);
	$pdf -> SetLink($linkAnamPat);
          $pdf -> Ln(10);

          
         
         $aggPat = italianFormat(getInfo('dataAggiornamento','anamnesiPatologica','idpaziente = ' . $id));
         $pdf -> Ln(4);
         $pdf -> SetFont('courier','B',12);
 		 $pdf -> Cell(105,7,'Testo anamnesi Patologica Remota - ',0,0,"R");
         $pdf -> SetFont('courier','',10);
         $pdf->MultiCell(0,7, 'Ultimo aggiornamento: '. $aggPat,0,"L");
         $pdf -> SetFont('courier','B',9);
   	     $pdf -> Cell(0,7,'___________________________________________________________________________________________________',0,1,"C");
         $pdf -> Ln(2);
         $pdf -> SetFont('courier','',9);
         $pdf -> MultiCell(0,5,$testoPatRem,0,"J");
         $pdf -> Ln(2);
         $section8 = 1;
         
         if($section8 == 1)
         $pdf -> Cell(0,5,'---------------------------------------------------------------------------------------------------',0,1,"L"); 
         $pdf -> Ln(2);
           
           $pdf -> SetFont('courier','B',10);	
           $pdf -> Cell(65,7,'Patologie pregresse ',0,1,"L");
           $idPat = getInfo('id', 'anamnesiPatologica', 'idpaziente = ' . $id);
           $groupPatContratte = getArray('icd9groupdiagcode_codeGroup', 'patologieContratte', 'stato = "remota" AND anamnesiPatologica_id = "'.$idPat.'"');
           if($groupPatContratte != null){
                
                $pdf -> SetFont('courier','',9);
                $patologie = getArray('codeGroup', 'icd9groupdiagcode', "descrizione != 'null'");
                $patdescrizione = getArray('descrizione', 'icd9groupdiagcode', "codeGroup != 'null'");
                    for($k = 0; $k < count($patologie); $k++){
                        if(in_array($patologie[$k],$groupPatContratte)){
                            $pdf -> MultiCell(0,7, '- ' . $patdescrizione[$k],0,"J");
                        }
                    }
            
           }
        
    }
	
    $testoPatPros = getInfo('prossima', 'anamnesiPatologica', 'idpaziente = ' . $id);
    
    if($testoPatPros != ''){
        
        $pdf -> SetFont('courier','B',15);
           $pdf -> Ln(20);
           $pdf -> SetFont('courier','B',15);
           $pdf -> Cell(35,5,'Anamnesi patologica prossima',0,1,"L");
           $pdf -> Ln(10);
           
         
         $pdf -> Ln(4);
         $pdf -> SetFont('courier','B',12);
 		 $pdf -> Cell(105,7,'Testo anamnesi Patologica Prossima - ',0,0,"R");
         $pdf -> SetFont('courier','',10);
         $pdf->MultiCell(0,7, 'Ultimo aggiornamento: '. $aggPat,0,"L");
         $pdf -> SetFont('courier','B',9);
   	     $pdf -> Cell(0,7,'___________________________________________________________________________________________________',0,1,"C");
         $pdf -> Ln(2);
         $pdf -> SetFont('courier','',9);
         $pdf -> MultiCell(0,5,$testoPatPros,0,"J");
         $pdf -> Ln(2);
         $section9 = 1;
         
         if($section9 == 1)
         $pdf -> Cell(0,5,'---------------------------------------------------------------------------------------------------',0,1,"L"); 
         $pdf -> Ln(2);
           
           $pdf -> SetFont('courier','B',10);	
           $pdf -> Cell(65,7,'Patologie recenti ',0,1,"L");
           $idPat = getInfo('id', 'anamnesiPatologica', 'idpaziente = ' . $id);
           $groupPatContrattePros = getArray('icd9groupdiagcode_codeGroup', 'patologieContratte', 'stato = "prossima" AND anamnesiPatologica_id = "'.$idPat.'"');
           if($groupPatContrattePros != null){
                
                $pdf -> SetFont('courier','',9);
                $patologie = getArray('codeGroup', 'icd9groupdiagcode', "descrizione != 'null'");
                $patdescrizione = getArray('descrizione', 'icd9groupdiagcode', "codeGroup != 'null'");
                    for($k = 0; $k < count($patologie); $k++){
                        if(in_array($patologie[$k],$groupPatContrattePros)){
                            $pdf -> MultiCell(0,7, '- ' . $patdescrizione[$k],0,"J");
                        }
                    }
            
           }
        
    }
           
	       


	
	//VISITE TODO
	/*/if (!empty($idDiagnosiFiltrate)){
		$pageName = 'Visite';
		$pdf -> PrintFoglio($pageName);
		$pdf -> SetLink($linkVisite);
          	$pdf -> Ln(10);
	/*/

	// PARAMETRI VITALI
	if ($confPatSummary >= 3){
		
		$pdf -> Ln(10);
	    	//$pageName = 'Parametri vitali';
			
			$pageName = 'Visite';
	    	$pdf -> PrintFoglio($pageName);
		$pdf -> SetLink($linkParamVit);
		$pdf -> Ln(2);
		
		$arrayVisite = getArray('id', 'visite', 'idpaziente = ' .  $id .  ' ORDER BY id DESC '); //ottengo l'array degli id delle visite effettuate  all'utente $id
		if (!empty($arrayVisite)){
		
		$numVisite = count ($arrayVisite); // ottengo gli elementi contenuti nell'array
	
		$pdf -> SetFont('courier','',8);
		for ( $i = 0; $i < $numVisite ; $i++ )	{
			$idp = $arrayVisite[$i]; //ottengo l'id in pos $i dell'array visite
			
			$data =  italianformat (getInfo('datavisita', 'visite', 'id = '  . $idp)); 
			
			$motivo = getInfo('motivo', 'visite', 'id = '  . $idp);
			$osservazioni =	getInfo('osservazioni', 'visite', 'id = '  . $idp);
			$conclusioni  =	getInfo('conclusioni', 'visite', 'id = '  . $idp);
			$pdf->MultiCell(180,10, $data. ': Motivo: '. $motivo . '; Osservazioni: '. $osservazioni . '; Conclusioni: '. $conclusioni . '.');
		}
	}
		
		
		$arrayParam = getAverageValues($id); // presa da Mpdello PBAC/Utility

		if (!empty($arrayParam)){
			
			$arrayPMax = array();
			$arrayPMin = array();
			$arrayData = array();
			$arrayBMI = array();
			$arrayFC = array();
			$arrayPeso = array();
			
			$pdf -> Ln(2);
			$pdf -> SetFont('courier','B',12);
			$pdf -> Cell(177,10,'Rilievi',0,1,"C");
			$pdf -> SetFont('courier','B',9);
			$pdf -> Cell(31,5,'Data rilev.',0,0,"C");
	          	$pdf -> Cell(21,5,'Altezza',0,0,"C");
	          	$pdf -> Cell(16,5,'Peso',0,0,"C");
	          	$pdf -> Cell(16,5,'BMI',0,0,"C");
	          	$pdf -> Cell(31,5,'Press. max',0,0,"C");
	          	$pdf -> Cell(31,5,'Press. min',0,0,"C");
	          	$pdf -> Cell(31,5,'Freq. cardiaca',0,1,"C");
	          	
	          	// UNITA' DI MISURA
			$pdf -> Cell(31,5,'',0,0,"C");
	          	$pdf -> Cell(21,5,'(cm)',0,0,"C");
	          	$pdf -> Cell(16,5,'(Kg)',0,0,"C");
	          	$pdf -> Cell(16,5,'',0,0,"C");
	          	$pdf -> Cell(31,5,'(mmHg)',0,0,"C");
	          	$pdf -> Cell(31,5,'(mmHg)',0,0,"C");
	          	$pdf -> Cell(31,5,'(bpm)',0,1,"C");
			$pdf -> SetFont('courier','',8);
			$pdf -> Cell(31,5,'_________________________________________________________________________________________________________',0,1,"L");
			
			foreach($arrayParam as $idp){
				$altezza = getInfo('altezza', 'parametrivitali', 'id = ' . $idp);
				 
				$peso = getInfo('peso', 'parametrivitali', 'id = '  . $idp);
				if ($altezza) //se l'altezza è diversa da zero
				$BMI = round($peso/pow(($altezza/100),2),2);
				$PA_min = getInfo('pressioneminima', 'parametrivitali', 'id = '  . $idp); //diastolica
				$PA_max = getInfo('pressionemassima', 'parametrivitali', 'id = '  . $idp); //sistolica
				$FC = getInfo('frequenzacardiaca', 'parametrivitali', 'id = '  . $idp);
				$aggiornamento = getInfo('data', 'parametrivitali', 'id = '  . $idp);
				
				array_push($arrayPMin, $PA_min);
				array_push($arrayPMax, $PA_max);
				array_push($arrayPeso, $peso);
				
				$date = DateTime::createFromFormat("Y-m-d", $aggiornamento);
				$date = $date -> format('d-m');
			
				array_push($arrayData, $date);
				array_push($arrayBMI, $BMI);
				array_push($arrayFC, $FC);
				
				$aggiornamento = italianFormat($aggiornamento);
				$pdf -> SetFont('courier','',8);
				
		        
				$pdf -> Cell(2,5,' |',"T",0,"C");
				$pdf -> Cell(29,5, " " . $aggiornamento . " ","T",0,"C");
				
				$pdf -> Cell(2,5,' |',0,0,"R");
		          	$pdf -> Cell(19,5,$altezza  . " ", "T",0,"C");	
		          	
		          	$pdf -> Cell(2,5,' |',0,0,"R");
		          	$pdf -> Cell(14,5,$peso . " ", "T",0,"C");	
		          	
		          	$pdf -> Cell(2,5,' |',"T",0,"R");
		          	$pdf = getColor($pdf, $version,  $BMI, 'B', 1);
		          	$pdf -> Cell(14,5,$BMI . " ", "T",0,"C");	
		          	$pdf = setDefaultValues($pdf);
		          	
		          	$pdf -> Cell(2,5,' |',"T",0,"R");
		          	$pdf = getColor($pdf, $version,  $PA_max, 'B', null, 1);
		          	$pdf -> Cell(29,5,$PA_max . " ", "T",0,"C");	
		          	$pdf = setDefaultValues($pdf);
		          	
		          	$pdf -> Cell(2,5,' |',0,0,"R");
		          	$pdf = getColor($pdf, $version,  $PA_min, 'B', null, null, 1);
		          	$pdf -> Cell(29,5,$PA_min . " ", "T",0,"C");
		          	$pdf = setDefaultValues($pdf);
		          	
		          	$pdf -> Cell(2,5,' |',"T",0,"R");
		          	$pdf = setHeartRate($pdf, $FC, $age, $version);
		          	
		          	$pdf -> Cell(29,5,$FC . " ", "T",0,"C");
		          	$pdf = setDefaultValues($pdf);
		          	$pdf -> Cell(2,5,'|',"T",1,"C");
		          	
			}
			
			$pdf -> Cell(29,5,'---------------------------------------------------------------------------------------------------------',0,1,"L");	
		}	
         }
       
         // LEGENDA PARAMETRI VITALI
         
         $pdf = legendaAnamnesi($pdf, $version);
         	
         	if (!empty($arrayParam)){
         		
		// GRAFICO DELLA PRESSIONE
		$arrayArrays = array();
		$arrayPalette = array();
		$arrayGradient = array();
		$arrayX = array();
		 
		array_push($arrayArrays, $arrayPMax);    // valori di pressione massima
		array_push($arrayArrays, $arrayPMin);	    // valori di pressione minima
		array_push($arrayArrays, $arrayData);	    // ascisse
		array_push($arrayX, 'Press. Max');
		array_push($arrayX, 'Press. Min');
		 
		$arrayPalette[0] = 150;   // colore RGB della linea che congiunge i valori di press massima
		$arrayPalette[1] = 0;
		$arrayPalette[2] = 0;
		 
		$arrayPalette[3] = 255;   // colore RGB della linea che congiunge i valori di press minima
		$arrayPalette[4] = 138;
		$arrayPalette[5] = 0;
		 
		$arrayGradient[0] = 255;    // colore RGB dell'area sottesa tra le linee disegnate
		$arrayGradient[1] = 239;
		$arrayGradient[2] = 221;
		 
		createGraph($pdf, $arrayArrays, $arrayX, 'Pressione', 'Andamento pressione', $arrayPalette, $arrayGradient);
		
		// GRAFICO DEL BMI
		$arrayArrays = array();
		$arrayPalette = array();
		$arrayGradient = array();
		$arrayX = array();
		 
		array_push($arrayArrays, $arrayBMI);     // valori di BMI
		array_push($arrayArrays, $arrayData);   // valori di ascisse
		array_push($arrayX, 'BMI');
		 
		$arrayPalette[0] = 102;   // colore RGB della linea che congiunge i valori di BMI
		$arrayPalette[1] = 142;
		$arrayPalette[2] = 255;
		 
		$arrayGradient[0] = 228;   // colore RGB dell'area sottesa tra le ascisse e la linea disegnata
		$arrayGradient[1] = 255;
		$arrayGradient[2] = 255;
		 
		createGraph($pdf, $arrayArrays, $arrayX, 'BMI', 'Body Mass Index', $arrayPalette, $arrayGradient);
		 
		 // GRAFICO FREQUENZA CARDIACA
		 
		$arrayArrays = array();
		$arrayPalette = array();
		$arrayGradient = array();
		$arrayX = array();
		 
		array_push($arrayArrays, $arrayFC);
		array_push($arrayArrays, $arrayData);
		array_push($arrayX, 'Freq. card.');
		 
		$arrayPalette[0] = 255;
		$arrayPalette[1] = 0;
		$arrayPalette[2] = 0;
		 
		$arrayGradient[0] = 255;
		$arrayGradient[1] = 226;
		$arrayGradient[2] = 226;
		 
		createGraph($pdf, $arrayArrays, $arrayX, 'bpm', 'Frequenza cardiaca', $arrayPalette, $arrayGradient);
		
		 // GRAFICO PESO CORPOREO
		  
		$arrayArrays = array();
		$arrayPalette = array();
		$arrayGradient = array();
		$arrayX = array();
		 
		array_push($arrayArrays, $arrayPeso);
		array_push($arrayArrays, $arrayData);
		array_push($arrayX, 'Peso');
		 
		$arrayPalette[0] = 21;
		$arrayPalette[1] = 110;
		$arrayPalette[2] = 0;
		 
		$arrayGradient[0] = 255;
		$arrayGradient[1] = 255;
		$arrayGradient[2] = 218;
		 
		createGraph($pdf, $arrayArrays, $arrayX, 'Kg', 'Andamento peso', $arrayPalette, $arrayGradient);

		
		
         

	}
	
	
	// TERAPIE FARMACOLOGICHE

	if (!empty($idDiagnosiFiltrate)){
		$pageName = 'Terapie farmacologiche';
		$pdf -> PrintFoglio($pageName);
		$pdf -> SetLink($linkTerapie);
          	$pdf -> Ln(10);

 
		foreach($idDiagnosiFiltrate as $ida){
			$idTherapy = getInfo('id', 'terapiefarmacologiche', 'iddiagnosi = ' . $ida);
			$codPat = getInfo('patologia', 'diagnosi', 'id = ' . $ida);
			$patologia = getInfo('nome', 'patologie', 'id = ' . $codPat);
	
			if ($idTherapy > 0){
				$pdf -> SetFont('courier','',10);
				$pdf -> Ln(3);
				$pdf -> Cell(30,5,$patologia,0,1,"L");
				$pdf -> Ln(5);
          			
				$arrayDrugs = getArray('id', 'terapie_farmacologiche_farmaci', 'idterapia = ' . $idTherapy);
				$drugsIndex = 0;
		
				if (!empty($arrayDrugs)) {
					$pdf -> Ln(5);
					$pdf -> SetFont('courier','B',9);
					$pdf -> Cell(35,5,'Farmaco',0,0,"L");
					$pdf -> Cell(25,5,'Stato',0,0,"L");
					$pdf -> Cell(30,5,'Forma farm.',0,0,"L");
					$pdf -> Cell(40,5,'Somministraz.',0,0,"L");
					$pdf -> Cell(35,5,'Inizio somm.',0,0,"C");
					$pdf -> Cell(25,5,'Fine somm.',0,1,"C");
				          $pdf -> SetFont('courier','B',8);
					$pdf -> Cell(45,5,'______________________________________________________________________________________________________________',0,1,"L");
				}
				
				$terapieSospese = 0;
				$arraySospensione  = array();
				
				foreach($arrayDrugs as $ad){
				
					$codiceATC = getInfo('codiceATC', 'terapie_farmacologiche_farmaci', 'id = ' . $ad);
					$codiceFF = getInfo('codiceformafarmaceutica', 'terapie_farmacologiche_farmaci', 'id = ' . $ad);
					$codiceSS = getInfo('codicesomministrazione', 'terapie_farmacologiche_farmaci', 'id = ' . $ad);
				
					$stato = getInfo('stato', 'terapie_farmacologiche_farmaci', 'id = ' . $ad);
					if ($stato == 'Sospesa'){// da completare
					
						$terapieSospese++;
						$idTerminazione = getInfo('terminazione', 'terapie_farmacologiche_farmaci', 'id = ' . $ad);
					
						// dati sulla motivazione della sospensione
						$idEffCol = getInfo('ideffcol', 'motivazionesospensione', 'id = ' . $idTerminazione);
					
						if (!$idEffCol) $motivazione = getInfo('motivazione', 'motivazionesospensione', 'id = ' . $idTerminazione);
							else {
								$idPatologia = getInfo('patologia', 'effetticollaterali', 'id = ' . $idEffCol);
								$motivazione = getInfo('nome', 'patologie', 'id = ' . $idPatologia);
							}
						array_push($arraySospensione, $motivazione);		
					}
				
					$farmaco = getInfo('nome', 'farmaci', 'codice = "' . $codiceATC . '"');
					$formaFarmaceutica = getInfo('descrizione', 'forma_farmaceutica', 'codice = "' . $codiceFF . '"');
					$somministrazione = getInfo('descrizione', 'somministrazione', 'codice = "' . $codiceSS . '"');
				
					$dataInizio = italianFormat(getInfo('datainizio', 'terapie_farmacologiche_farmaci', 'id = ' . $ad));
					$dataFine = italianFormat(getInfo('datafine', 'terapie_farmacologiche_farmaci', 'id = ' . $ad));

          				$pdf -> SetFont('courier','',8);
          				$pdf -> Cell(35,5,$farmaco,0,0,"L");
          				
          				if ($stato == 'Sospesa')
          					if (is_null($version) or $version === 1)
          						$pdf->SetTextColor(194,8,8);
          					else
          						$pdf -> SetFont('courier','B',8);
          				//postille
          				$postille = '(';
          		
          				for($i = 0; $i < $terapieSospese; $i++)
          					$postille = $postille . '*';
          					
          				$postille = $postille .  ')';	

          				if ($terapieSospese > 0)
          					$pdf -> Cell(25,5,$stato . $postille,0,0,"L");
          				else
          					$pdf -> Cell(25,5,$stato,0,0,"L");
          					
          				$pdf -> SetFont('courier','',8);	
          				$pdf->SetTextColor(0,0,0);
          				
          				$pdf -> Cell(30,5, $formaFarmaceutica,0,0,"L");
          				$pdf -> Cell(40,5, $somministrazione,0,0,"L");
          				$pdf -> Cell(35,5, $dataInizio,0,0,"C");
          				$pdf -> Cell(25,5, $dataFine,0,1,"C");
          				$pdf -> SetFont('courier','',8);
				}
		}
		
	}
		$pdf -> SetFont('courier','',8);
		if ($idTherapy > 0)
			$pdf -> Cell(30,5,'------------------------------------------------------------------------------------------------------------',0,1,"L");
	}

	if (!empty($arraySospensione)){
		
		
		for($i = 0; $i < count($arraySospensione); $i++){
			$postilla = '(';
			
			for ($j = 0; $j <= $i; $j++)
				$postilla = $postilla . '*';
				
			$motivazione = $arraySospensione[$i];
			$postilla = $postilla . ')';
		
			$pdf -> Ln(7);
			if (is_null($version) or $version === 1)
				$pdf->SetTextColor(194,8,8);	
			else
				$pdf -> SetFont('courier','B',8);
				
			$pdf -> Cell(7,5, $postilla,0,0,"L");
			$pdf -> Cell(10,5, $motivazione,0,1,"L");
			
			$pdf -> SetFont('courier','',8);
		}	
	}
	
	// PERMESSO SUI FARMACI VIETATI - PER DEFAULT E' 3
	// IMPLEMENTARE PANNELLO DELLE VISIBILITA' CON LA VOCE FARMACI VIETATI
	
	$confFarmViet = INF;
   	if ($maxConfidentiality == 0)
   		$confFarmViet = 3;
	
	$arrayFarmaciVietati = getArray('id', 'farmacivietati', 'idutente = ' . $id);
	
	$filteredArray = array();
	// FILTRAGGIO FARMACI VIETATI
	
	foreach($arrayFarmaciVietati as $idFV){
		$visibilita = getInfo('confidenzialita', 'farmacivietati', 'idutente = ' . $id);
		
		if ($visibilita <= $confFarmViet)
			array_push($filteredArray, $idFV);
	}
		
	if (!empty($filteredArray)){
		
		$pdf->SetTextColor(0,0,0);		
		$pdf -> Ln(10);
          	$pdf -> SetFont('courier','B',15);
		$pdf -> Cell(70,10, 'Farmaci vietati');
		$pdf -> Ln(15);
		
		$pdf -> Ln(5);
	          $pdf -> SetFont('courier','B',9);
		$pdf -> Cell(30,5,'Farmaco',0,0,"L");
		$pdf -> Cell(50,5,'Motivo',0,1,"L");
		$pdf -> SetFont('courier','B',8);
		$pdf -> Cell(50,5,'_________________________________',0,1,"L");
	
		$pdf -> SetFont('courier','',8);
		foreach($arrayFarmaciVietati as $idf){
			$codiceATC = getInfo('codiceATC', 'farmacivietati', 'id = ' . $idf);
			$farmaco = getInfo('nome', 'farmaci', 'codice = "' . $codiceATC . '"');
			$motivo = getInfo('motivo', 'farmacivietati', 'id = ' . $idf);
		
			$pdf -> Cell(30,5,$farmaco,0,0,"L");
			$pdf -> Cell(30,5,$motivo,0,1,"L");
		}
		
		$pdf -> Cell(30,5,'---------------------------------',0,1,"L");
	}
				
	// INDAGINI DIAGNOSTICHE
	
	$pageName = 'Indagini diagnostiche';
	$pdf -> PrintFoglio($pageName);
	$pdf -> SetLink($linkLaboratorio);
          $pdf -> Ln(10);
          
          $confIndDiagn = INF;
   	if ($maxConfidentiality == 0)
          	$confIndDiagn = policyInfo('Indagini diagnostiche', 'Confidenzialita'); 
	
	if ($confIndDiagn >= 3){
		
		if (!is_null($typeExam)) $typeExam = ' AND codice = "' . $typeExam . '"';
		
	          $arrayImmDiagn = getArray('id', 'indagini', 'idutente = ' . $id . $typeExam);

	          if (!empty($arrayImmDiagn))
			foreach($arrayImmDiagn as $idi){

	         			$esecuzione = italianFormat(getInfo('esecuzione', 'indagini', 'id = ' . $idi));
	         			$tipo  = getInfo('tipo', 'indagini', 'id = ' . $idi);
	         			$nome  = getInfo('nome', 'indagini', 'id = ' . $idi);
	         			$validata  = getInfo('validata', 'indagini', 'id = ' . $idi);
	         			$codice  = getInfo('codice', 'indagini', 'id = ' . $idi);
	         			
	         			$titolare = getCredentials(getInfo('idente', 'indagini', 'id = ' . $idi));
	         			$cpp  = getCredentials(getInfo('idcpp', 'indagini', 'id = ' . $idi));

				$image = getInfo('contenuto', 'indagini', 'id = ' . $idi);
				$width  = toPoints(getInfo('lunghezza', 'indagini', 'id = ' . $idi));
				$height  = toPoints(getInfo('larghezza', 'indagini', 'id = ' . $idi));
				$ratio = getRatio($width, $height);
				
	         			if ($validata == 1){

					$currentY = $pdf -> GetY();
					
					if (!is_null($version))
						if ( 268 - $currentY < $height){
							$pageName = 'Indagini diagnostiche';
							$pdf -> PrintFoglio($pageName);
		          				$pdf -> Ln(10);
		          				$oldValue = 0;
						}
					
					$pdf -> SetFont('courier','',8);
			          	$pdf -> Cell(35,5,'Tipo indagine ',0,0,"L");
			    
			          	$pdf -> SetFont('courier','B',8);
			          	$pdf -> Cell(35,5,$tipo,0,1,"L");
			          	
			          	$pdf -> SetFont('courier','',8);
			          	$pdf -> Cell(35,5,'Titolare ',0,0,"L");
			          		
			          	$pdf -> SetFont('courier','B',8);
			          	$pdf -> Cell(35,5,$titolare,0,1,"L");
			          	
			          	$pdf -> SetFont('courier','',8);
			          	$pdf -> Cell(35,5,'Ordinata da ',0,0,"L");
			          		
			          	$pdf -> SetFont('courier','B',8);
			          	$pdf -> Cell(35,5,$cpp,0,1,"L");
			          		
			          	$pdf -> SetFont('courier','',8);
			          	$pdf -> Cell(35,5,'Data di emissione ',0,0,"L");
			    
			          	$pdf -> SetFont('courier','B',8);
			          	$pdf -> Cell(35,5,$esecuzione,0,1,"L");
			          	$pdf -> ln(2);
			          	$pdf -> SetFont('courier','',8);

	         				if ($image != false)
	         					if (is_null($version)){
	         					$pdf -> Cell(30,5,'-----------------------------------------------------------------',0,1,"L");
	         					
	         					$imageIcon = getImageExamination($codice);
						file_put_contents($_SERVER['DOCUMENT_ROOT'].'assets/img/' . $nome, $image);
						$pdf->Image($imageIcon,100,$currentY ,16,20,'PNG',
						                         'www.fsem.eu/assets/img/' . $nome);

						} 
						else {
							
		         					if ($width > 180){
		         						$width = 180;
								$height = intval(180/$ratio);
							}
		         					
		         					if ($height > 260)
								$height = intval($ratio/$width);

							$currentY = $pdf -> GetY();
							
				          		$pdf -> Ln(10);
							
							$pdf -> MemImage($image,'10','85' + $oldValue, $width, $height);
							
							$pdf -> ln($height + 10);
							$oldValue = $height + 30;
							$oldX = $width + 10;
							
							$pdf -> SetFont('courier','',8);
						}
					
					$pdf -> ln(5);
				}	
			}
	}
	$pdf -> Output();

	return true;
 
}

function createGraph($pdf, $arrayArrays, $arrayX, $nameY, $fileName, $arrayPalette, $arrayGradient){

		$pdf -> Ln(10);
		$DataSet = new pData;
		
		$index = 0;

		foreach($arrayArrays as $array){
			$index++;
			$DataSet->AddPoint(array_reverse($array),"Serie" . $index);	
		}
			
		// CONTROLLO SULLA DIMENSIONE DELL'ARRAY DELLE ASCISSE
		if (count($arrayArrays[$index-1]) < 2) return false;
		
		$DataSet->AddAllSeries();
		
		for ($i = 0; $i < $index - 1; $i++){
			$j = $i+1;
			$DataSet->SetSerieName($arrayX[$i],"Serie" . $j);
		}

				
		$DataSet->SetAbsciseLabelSerie("Serie" . $index);
	          $DataSet->SetYAxisName($nameY);
		
		$Test = new pChart(700,230);
		
		// COLORI DELLE SERIE
		$number = count($arrayPalette)/3;
		
		if (is_int($number)){
			
			$k = 0;
			
			for ($i = 0; $i < $number; $i++){
				$R = $arrayPalette[$k];
				$G = $arrayPalette[$k + 1];
				$B = $arrayPalette[$k + 2];

				$k = $k + 3;
				$Test -> setColorPalette($i, $R, $G, $B);
			}
		}
		
		// ESTRAZIONE MINIMO
		
		if (count($arrayArrays) == 2) {
			$array = $arrayArrays[0];
			
			$min = min($array);
			$max = max($array);
		}else {
			
			// escludo dall'Array l'array delle date facendone prima una copia
			
			$filteredArray = array_merge(array(), $arrayArrays);
			unset($filteredArray[$index -1]);
			
			$arrayMax = array();
			$arrayMin = array();
			
			foreach($filteredArray as $array){
				array_push($arrayMin, min($array));   // estraggo il min di ogni array
				array_push($arrayMax, max($array)); // estraggo il max di ogni array
			}
			
			// estraggo la posizione del min dei minimi e del max dei massimi
			$indexMin = array_search(min($arrayMin), $arrayMin);
			$indexMax = array_search(max($arrayMax), $arrayMax);
			
			$min = min($arrayArrays[$indexMin]);   // estraggo il min dei minimi in base alla posizione trovata
			$max = max($arrayArrays[$indexMax]);
		}

		$Test->setFixedScale($min - 10, $max +10,5);
		$Test->setFontProperties("graphic/Fonts/tahoma.ttf",10);   
		$Test->setGraphArea(65,30,570,185);   
		$Test->drawGraphAreaGradient(245,245,245,-50);  
		
		$step = count($arrayArrays[$index - 1]);
		
		if ($step < 5)
			$step = 1;
		else
			$step = intval($step/5);
			
		$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,0,0,0,TRUE,0,0,TRUE,$step);   
		
		$Test->drawGrid(6,TRUE,215,215,215,50);    
	          $Test->setShadowProperties(3,3,0,0,0,30,4);
		$Test->drawCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription());
		$Test->clearShadow(); 
		
		// RGB DELL'AREA DEL GRAFICO
		
		if (count ($arrayGradient) == 3){
			$R = $arrayGradient[0];
			$G = $arrayGradient[1];
			$B = $arrayGradient[2];	
		} else {
			$R = 255;
			$G = 255;
			$B = 255;
		}
		
		$extreme = count($arrayArrays) - 1;
		

	 	$Test->setLineStyle(1,10);
		$DataSet->RemoveAllSeries();

		$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);   

		if (count($arrayArrays[0]) < 11){
		 	$Test->setFontProperties("graphic/Fonts/tahoma.ttf",10);   
		 	
		 	for($i = 1; $i < count($arrayArrays[0]) - 1; $i++)
		 		$Test->writeValues($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie" . $i);   	
		}
			  
		$Test->setFontProperties("graphic/Fonts/tahoma.ttf",10);   
		$Test->drawLegend(590,90,$DataSet->GetDataDescription(),255,255,255);   
		$Test->setFontProperties("graphic/Fonts/tahoma.ttf",10);   
		$Test->drawTitle(60,22,$fileName,0,0,0,585);
		
		// La copertura dell'area compresa tra due linee funziona solo per la prima e ultima serie (escluse le ascisse)
		if (count($arrayArrays) == 2)
			$Test->drawArea($DataSet->GetData(),"Serie1",0, $R, $G, $B);
		else
			$Test->drawArea($DataSet->GetData(),"Serie1", "Serie" . $extreme, $R, $G, $B, 50);

		$Test->Render($fileName . ".png");      
			 
		$pdf->Image($_SERVER['DOCUMENT_ROOT'].'modello PBAC/' . $fileName . '.png');  
		$target = $fileName .  ".png";
		
		if (file_exists($target)) 
   		 	unlink($target); 
}


function getColor($pdf, $version,  $value, $bold = null, $BMI = null, $pMax = null, $pMin = null, $fC = null){
	
	
	switch($value){
		
		case '' :  {
			$pdf -> SetTextColor(0,0,0);
			$pdf -> SetFont('courier', $bold, 8);
			break;
		}
		
		case "critica":
		case ($value >= 40 and !is_null($BMI)) : 
		case ($value > 140 and !is_null($pMax)) :
		case ($value > 90 and !is_null($pMin)) :  {
			if ($version === 1 or is_null($version) ){
				$pdf -> SetTextColor(150,0,0);
				$pdf -> SetFont('courier',$bold,8);	
			}
			else
				$pdf -> SetFont('courier','B',8);	
				
			break;
		}
		
		case "Infettiva" :
		case ($value >= 35 and $value <= 39.9 and !is_null($BMI)) : 
		case ($value < 100 and !is_null($pMax)) : 
		case ($value < 60 and !is_null($pMin)) : {
			if ($version === 1 or is_null($version) ){
				$pdf -> SetTextColor(255,0,0);
				$pdf -> SetFont('courier',$bold,8);	
			}
			elseif (!is_null($BMI) or !is_null($pMax) or !is_null($pMin))
				$pdf -> SetFont('courier','B',8);
			
			break;
		}
		
		case "Allergia" :
		case ($value >= 25 and $value <= 29.9 and  !is_null($BMI)) : { 
			if ($version === 1 or is_null($version) ){
				$pdf -> SetTextColor(255,162,0);
				$pdf -> SetFont('courier',$bold,8);	
			}elseif (!is_null($BMI) or !is_null($pMax) or !is_null($pMin))
				$pdf -> SetFont('courier','B',8);
				
			break;
		}
		
		case "Intolleranza" : {
			if ($version === 1 or is_null($version) ){
				$pdf -> SetTextColor(255,137, 137);
				$pdf -> SetFont('courier',$bold,8);	
			}elseif (!is_null($BMI) or !is_null($pMax) or !is_null($pMin))
				$pdf -> SetFont('courier','B',8);
		
			break;
		}
		
		case "Allergia farmacologica" : 
		case ($value >= 30 and $value <= 34.9 and  !is_null($BMI)) : {
			if ($version === 1 or is_null($version) ){
				$pdf -> SetTextColor(255,102, 0);
				$pdf -> SetFont('courier',$bold,8);	
			}elseif (!is_null($BMI) or !is_null($pMax) or !is_null($pMin))
				$pdf -> SetFont('courier','B',8);
				
			break;
		}
		
		case "Guarita recentemente" :  
		case ($value <= 18.5 and !is_null($BMI)) : {
			if ($version === 1 or is_null($version) ){
				$pdf -> SetTextColor(18,173, 43);
				$pdf -> SetFont('courier',$bold,8);	
			}elseif (!is_null($BMI) or !is_null($pMax) or !is_null($pMin))
				$pdf -> SetFont('courier','B',8);
			
			break;
		}
		
		case "Guarita in passato" : {
			if ($version === 1 or is_null($version) ){
				$pdf -> SetTextColor(0,106, 3);
				$pdf -> SetFont('courier',$bold,8);	
			}
			
			break;
		}
		
	}
	
	return $pdf;
}


function setHeartRate($pdf, $fC, $age, $version = null){
	
	switch($age){
		
		case($age < 3): {

			if ($fC < 100)
				if (is_null($version)  or $version === 1) {
					$pdf -> SetFont('courier','B',8);
					$pdf -> SetTextColor(255,137,137);
				} 
				else 
					$pdf -> SetFont('courier','B',8);
				
			if ($fC >  180)
				if (is_null($version)  or $version === 1) {
					$pdf -> SetTextColor(255,137,137);
					$pdf->SetTextColor(255,102,0);
				}
				else 
					$pdf -> SetFont('courier','B',8);
				
			break;	
		}
		
		case($age > 3 and $age < 13) : {
			
			if ($fC < 70)
				if (is_null($version)  or $version === 1) {
					$pdf -> SetTextColor(255,137,137);
					$pdf -> SetFont('courier','B',8);
				}
				else 
					$pdf -> SetFont('courier','B',8);
					
			if ($fC >  110) 
				if (is_null($version)  or $version === 1) {
					$pdf->SetTextColor(255,102,0);
					$pdf -> SetFont('courier','B',8);
				}
				else 
					$pdf -> SetFont('courier','B',8);
			break;	
		}
		
		case($age > 13 and $age < 20) : {
			
			if ($fC < 70 )
				if (is_null($version)  or $version === 1) {
					$pdf -> SetTextColor(255,137,137);
					$pdf -> SetFont('courier','B',8);
				}
				else 
					$pdf -> SetFont('courier','B',8);
				
			if ($fC >  90)
				if (is_null($version)  or $version === 1) {
					$pdf->SetTextColor(255,102,0);
					$pdf -> SetFont('courier','B',8);
				}
				else 
					$pdf -> SetFont('courier','B',8);

			break;	
		}
		
		case($age > 20) : {
			
			if ($fC < 65)
				if (is_null($version)  or $version === 1) {
					$pdf -> SetTextColor(255,137,137);
					$pdf -> SetFont('courier','B',8);
				}
				else 
					$pdf -> SetFont('courier','B',8);

			if ($fC >  85)
				if (is_null($version)  or $version === 1)  {
					$pdf->SetTextColor(255,102,0);
					$pdf -> SetFont('courier','B',8);
				}
				else 
					$pdf -> SetFont('courier','B',8);
			break;	
		}
	}

	return $pdf;
}


function getImageExamination($type){
	
	$type = strtolower($type);
	
	switch($type){
		
		case 'ecg': {
			$type = $_SERVER['DOCUMENT_ROOT'].'assets/img/ECG.png';
			break;
		}
		
		case 'rad': {
			$type = $_SERVER['DOCUMENT_ROOT'].'assets/img/Radiography.png';
			break;
		}
		
		case 'bld': {
			$type = $_SERVER['DOCUMENT_ROOT'].'assets/img/bloodExam.png';
			break;
		}
		
		case 'urn': {
			$type = $_SERVER['DOCUMENT_ROOT'].'assets/img/urineExam.png';
			break;
		}
		
		default:  $type = $_SERVER['DOCUMENT_ROOT'].'assets/img/Exams.png';
	}

	return $type;
	
}

function setDefaultValues($pdf){
	
	$pdf -> SetFont('courier','',8);
	$pdf->SetTextColor('0,0,0');
	
	return $pdf;
	
}

function toPoints($pixels){
	
	return intval (0.75 * $pixels);
	
}

function getRatio($width, $height){
	
	return $width/$height;

}


function loadImage($pdf, $name, $title, $carriage, $trasbordo = null){
	
	$pdf -> SetFont('courier','',7);
	$currentY = $pdf -> GetY() + 1;
	
	if ($carriage == true){
		$currentY = $currentY + 7;
		$pdf -> SetX(10);
	}
		
		
	$currentX = $pdf -> GetX() + 1;
	
	$pdf -> Image($_SERVER['DOCUMENT_ROOT'].'assets/img/' . $name , $currentX + $trasbordo, $currentY,3,3);
	
	$pdf -> SetXY($currentX + 10 + $trasbordo, $currentY - 1);
	
	$pdf -> Cell(45,5,$title,0,0,"L");
	$pdf -> SetFont('courier','',8);
	
	return $pdf;
	
}


function legendaPatologie($pdf, $version = null){
	
	if ($version === 0) return $pdf;
	
	$currentY = $pdf -> GetY();

	if ( $currentY > 222)
		$pdf -> AddPage();	
		
	$pdf -> SetY(222);
	
	$pdf -> Ln(15);
	$pdf -> SetFont('courier','B',12);
	$pdf -> Cell(45,5,'Legenda',0,1,"L");
	
	$pdf -> ln(7);
	$pdf =  loadImage($pdf, 'Rosso scuro.jpg', 'Patologia critica', false);
	$pdf =  loadImage($pdf, 'Rosso chiaro.jpg', 'Patologia infettiva', false);
	$pdf =  loadImage($pdf, 'Arancione chiaro.jpg', 'Patologia allergica', false);
	
	$pdf =  loadImage($pdf, 'Arancione scuro.jpg', 'Allergia farmacologica', true);
	$pdf =  loadImage($pdf, 'Rosa.jpg', 'Intolleranze',  false);
	
	$pdf =  loadImage($pdf, 'Verde chiaro.jpg', 'Guarita recentemente', true);
	$pdf =  loadImage($pdf, 'Verde scuro.jpg', 'Guarita in passato', false);
	
	return $pdf;
}


function legendaAnamnesi($pdf, $version = null){
	
	if ($version === 0) return $pdf;
	
	$currentY = $pdf -> GetY();

	if ( $currentY > 222)
		$pdf -> AddPage();	
		
	$pdf -> SetY(222);
	
	$pdf -> Ln(15);
	$pdf -> SetFont('courier','B',12);
	$pdf -> Cell(45,5,'Legenda per valori non nella norma',0,1,"L");
	
	$pdf -> ln(7);
	$pdf =  loadImage($pdf, 'Rosso scuro.jpg', 'Ipertensione (bpm) - Obesità III (BMI)', false);
	$pdf =  loadImage($pdf, 'Rosa.jpg', 'Bradicardia', false, 20);
		
	$pdf =  loadImage($pdf, 'Rosso chiaro.jpg', 'Ipotensione (bpm) - Obesità II (BMI)', true);
	$pdf =  loadImage($pdf, 'Sabbia.jpg', 'Sovrappeso', false, 20);
	
	$pdf =  loadImage($pdf, 'Arancione scuro.jpg', 'Tachicardia (bpm) - Obesità I (BMI)', true);
	$pdf =  loadImage($pdf, 'Verde chiaro.jpg', 'Sottopeso', false, 20);
	
	return $pdf;
}


// PER UTENTE ID = 1
// versione a colori con thumbnails per indagini diagnostiche, nessun limite

//createReport(1);
// modificato da fg per qualsiasi utente è loggato

//if (isLogged()){
	if ( isset ( $_GET["pz_Id"])){
		$idUtente = $_GET["pz_Id"];
	}

	else
	$idUtente = $_SESSION['id'];;


	createReport($idUtente);
//}
/* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// versione a colori stampabile, nessun filtro
createReport(1, null, 1);

// versione in bianco e nero (solo per i valori e per le malattie in condizioni critiche) stampabile, nessun filtro
createReport(1, null, 0);

*/

?>