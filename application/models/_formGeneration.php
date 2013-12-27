<?php

//--------- FUNZIONE PER GENERARE IL FORM DAL DB ----------//


function generate_form_from_table($tb,$item_id=0)	{

	global $Form,$dbSwitch,$outPut,${$tb},$customInserts,$customPrints;
	
	
//	print_r($_POST);
	
	
	
//		se quel tipo di form ha bisogno di una variabile per creare una nuova voce
//		in caso di assenza di questa variabile restituisco messaggio e back.
	
	
	if	(	(	preg_match(	"/".$tb."\[/",	REQUEST_MANDATORY_VALUES)	)	&&	(	!$_REQUEST[item_id]	)	)	:
	
		$value	=	preg_replace(	"/.*".$tb."\[([A-Za-z0-9_]*)\].*/","$1",	REQUEST_MANDATORY_VALUES	);
		
		if	(	!$_REQUEST[$value]	)	:		
			
			$form	.=	$Form->open("clarify",FORM_ACTION,'POST',true,'Associazione');
			
			
			
	//		$sql	=	"SELECT ".$value." FROM ".find_primary_key_parent($value);	###CONTROLLARE###
			
	//		$data_list	=	$dbSwitch->select($sql);
			
			$form	.=	$Form->dynamic_select(codice_cliente,CLIENTI,ragione_sociale,cliente);
			
			$form	.=	$Form->submit("avanti");
			
			$form	.=	$Form->close(true);
			
			return	$form;			
		
		endif;
	
	endif;
	
	
	
	
	
	
	
	
	
	
	
	

	
	if	(	!$item_id	)	:	$item_id	=	$_GET[item_id];	endif;


	//definisco i tipi di campi
	$fields	=	field_types($tb);
	
	










//------- SE E' STATO POSTATO IL FORM IN QUESTIONE AGGIORNO -------//

	if	(	$_POST[$tb.'_is_sent']	)	:
	
		
		if	(	form_is_correct(	$tb,	$fields	)	)	:	
		
		
		
				//definisco il tipo di query
				
					
					if	(	$item_id	)	:
					
						$action	=	"UPDATE "; $where	=	" WHERE ".primary_key($tb)."='".$item_id."'";
					
					else:
					
						$action	=	"INSERT INTO ";
					
					endif;
					
					
				//preparo i pezzi di query
					
					
					for	(	$i=0;	$i	<	count($fields);	$i++	)	:
					
					
#************			//COMBO INSERT da rivedere!!!!!!!!!!!!!!!!!!!!!! (3 variabili)
					
						if	(	preg_match(	"/".$fields[$i][Field]."/",	COMBO_INSERTS	)	)	:
						
						/*	ATTENZIONE LA LISTA DELLE ATTREZZATURE ASSOCIATE VANNO PRESE DALLA TABELLA PRODOTTI SPECIFICI!	*/
						
							$ins_funct	=	preg_replace("/.*".$fields[$i][Field]."\[([^\[\]$]*)\].*/","$1",COMBO_INSERTS	);
							
								$sets	.=	$ins_funct($fields[$i][Field],$tb,$item_id);
							
						
						//SPECIAL INSERT (1 variabile)
						elseif	(	preg_match(	"/".$fields[$i][Field]."/",	SPECIAL_INSERTS	)	):
						
								$ins_funct	=	preg_replace("/.*".$fields[$i][Field]."\[([^\[\]$]*)\].*/","$1",SPECIAL_INSERTS	);
							
								$toPost	=	$ins_funct($_POST[$fields[$i][Field]]);	
								
								$sets.=" ".$fields[$i][Field]."='".$toPost."', ";
										
													
						
						//NORMAL INSERT
						else:
												
							
							if	(	$_POST[$fields[$i][Field]]	!=	$_POST['PRE_'.$fields[$i][Field]]	)	:
												
								$sets.=" ".$fields[$i][Field]."='".trim($_POST[$fields[$i][Field]])."', ";
								
							endif;
							
												
						endif;
							
											
					endfor;	
					
					
					
					
					
				
				
			
		
		
		//se è stato immesso/modificato almeno un campo metto insieme la query
		
				
				if	(	$sets	)	:
				
				
					//preparo gli aggiornamenti di data e ora
					
					$time=time();
					
					
					
					
					if	(	has_date_to_be_updated($fields)	)	:
					
					
					
					
						if	(	!$_POST[mod]	)	:
						
							$update_entry_date=", entry_date=".$time;	//data inserimento
						
						endif;	
						
						$update_mod_date=", mod_date=".$time;				//data modifica
					
					
					endif;
					
						
					
					
								
					
					
					
					
					
					
					
					
					
					if	(	isClosing()	)	:
					
						$update_close_date=", close_date=".$time;		//data chiusura
					
					endif;
						
						
						
						
						
						
						
					
					
					
				
			
					$sql=$action.$tb." SET ".substr($sets,-strlen($sets),strlen($sets)-2).$update_entry_date.$update_mod_date.$update_close_date.$where;
					
					
#					print $sql;
					
					
					$form	.=	$dbSwitch->insert($sql);
					
					
					unset($sets,$sql);
					
				
				endif;





					//------se è stato fatto salva e chiudi ed il form è corretto 
					//porto di nuovo all'elenco della categoria in questione-------//
					
					if	(	$_POST['salva-e-chiudi']	)	:					
					
						header("Location: ".ROOT."?cat=".$_REQUEST[cat]);
					
					endif;		

	
			
		
		endif;//fine se il form è corretto
	
	
	endif;//fine se c'è post

//------- FINE AGGIORNAMENTO DATI IN PRESENZA DI POST -------//






















//apro il form
	$form	.=	$Form->open($tb);





//Se è stato specificato l'item ID vado ad aprire la voce
	
	if	(	$item_id	)	:
	
		$dati	=	$dbSwitch->select(	"SELECT * FROM ".$tb." WHERE ".primary_key($tb)."='".$item_id."'"	);
		
		if	(	!is_array($dati)	)	:		$_SESSION[err_mess]	.= $dati;	endif;
		
		if	(	!count($dati)		)	:		$_SESSION[err_mess]	.= "non sono state trovate le informazioni.<br/>";	endif;
		
		$form	.=	$Form->hidden(	"mod"	,	$item_id	);
		
			
		
	endif;
	




//per ogni campo creo l'apposito campo form


	for	(	$i=0;	$i	<	count($fields);	$i++	)	:
	
	
		//se il value va convertito lo converto ora		
		$dati[0][$fields[$i][Field]]	=	display_converted_form_value($fields[$i][Field],$dati[0][$fields[$i][Field]]);
		
			
	
	//definisco il fieldset al quale aqppartiene questo specifico campo

	
	
	foreach (${$tb}[fieldsets] as $k => $v) {
		
		if	(	preg_match(	"/".$fields[$i][Field]."/", $v)	)	:	$fieldset=$k; endif;
		
	}
	
	if	(	!$fieldset	)	:	$fieldset="altro";	endif;
	
	
	$FORM[$fieldset]	.=	"\n<div class='".$fields[$i][Field]."'>\n";
	
	
	
		//-- stampo eventuali messaggi e stili di errore --//
		
		if	(	$_POST[$tb.'_is_sent']	&&	!is_valid(	$tb,$fields[$i][Field],true	)	)	:	
		
			$class=" class='error'";
		
		endif;
		
		//-- fine eventuali messaggi e stili di errore--//
		
		
		
		
			
		
		//se il campo è da trattare in modo speciale
		if	(	is_special_field($fields[$i][Field])	)	:
		
			//richiamo l'apposita funzione dalla classe form
			$FORM[$fieldset]	.=	$Form->$fields[$i][Field]($dati[0][$fields[$i][Field]],$err_mess);
		
		
		//se viene specificato un fieldtype diverso
		elseif	(	is_custom_field_type(	$fields[$i][Field]	)	)	:
		
			//richiamo l'apposita funzione dalla classe form
			
			//print get_custom_field_type(	$fields[$i][Field]	);
			
			$function=get_custom_field_type(	$fields[$i][Field]	);
			
			//se il campo personalizzato ha bisogno di variabili immetto fino alle prima 6 variabili presenti dopo la prima voce, separate da virgole nel file formconfig.php
			
			$FORM[$fieldset]	.=	$Form->$function[0]($fields[$i][Field],$function[1],$function[2],$function[3],$function[4],$function[5],$function[6]);
				
				
			
			
					
		
		
		
		
		else:	//altrimenti se è un campo normale
		
				
			//se è varchar o smallint
			if	(	preg_match('/varchar/',	$fields[$i][Type]	)	||
					preg_match('/smallint/',	$fields[$i][Type]	)	||
					preg_match('/int/',	$fields[$i][Type]	)
				)	:
			
				$maxlength	=	preg_replace('/[a-z]+\(([0-9]+)\)/','$1',$fields[$i][Type]);
				
				$FORM[$fieldset]	.=	$Form->input($fields[$i][Field],$dati[0][$fields[$i][Field]],$maxlength,$class,$err_mess);
			
			
			endif;
			
			
			//----------
			
			
			
			
			
			
			
			
			
			//se  SET o ENUM
			if	(	preg_match('/set/',	$fields[$i][Type]	)	||	preg_match('/enum/',	$fields[$i][Type]	)	)	:
			
			
			$labels	=	preg_replace('/\'/','',$fields[$i][Type]);
			$labels	=	preg_replace('/set\((.*)\)/','$1',$labels);
			$labels	=	preg_replace('/enum\((.*)\)/','$1',$labels);
			$labels	=	explode(",", $labels); //metto tutti i valori in un array
			
			
			
			
			$FORM[$fieldset]	.=	$Form->select($fields[$i][Field],$labels,$dati[0][$fields[$i][Field]]);
			
			
			endif;
			
			
			//----------
			
			
			
			
			
			
			
			
			
			
			//se  TEXT
			if	(	$fields[$i][Type] === "text"	)	:
			
			$FORM[$fieldset]	.=	$Form->textarea($fields[$i][Field],$dati[0][$fields[$i][Field]]);
			
			endif;
			
			
			//----------
		
		
		
		

		endif;	//fine se il campo non  speciale
		
				
		
	
	
		
		
		//$FORM[$fieldset]	.= is_valid($tb,$dati[0][$fields[$i][Field]]);
		
		
		
		$FORM[$fieldset]	.=	$_SESSION[err_mess][$fields[$i][Field]];
		
		unset($_SESSION[err_mess]);
		
		$FORM[$fieldset]	.=	"</div>\n\n";
	
	
	
	
	
	//se c'è un'inserto da mettere dopo questo fieldset lo metto
//	print "preg_match(\"/".$fieldset."/".${$tb}[custom_inserts].")";
			
	if(	(	preg_match("/".$fieldset."/",${$tb}[custom_inserts])	)	&&	(	!$FORM[custom_field]	)	):
	
	$custom_field	=	preg_replace("/.*".$fieldset."\[([^\[\]$]*)\].*/","$1",${$tb}[custom_inserts]	)	;
	
	$FORM[$custom_field]	=	$customInserts->$custom_field();
	
	endif;
	
	
	
	
	
	unset($fieldset,$class, $err_mess);
//		print $fields[$i][Field].$i.$tb;
	endfor;
	
	
	

print_r($FORM);exit;


foreach ($FORM as $key => $value) {
    
	$FIELDSET[$key]	.=	"\n\n<fieldset id='".$key."'>\n";	
	$FIELDSET[$key]	.=	"\n<legend>";
	$FIELDSET[$key]	.=	$outPut->label($key);
	$FIELDSET[$key]	.=	"</legend>\n";
	$FIELDSET[$key]	.=	$value;
	$FIELDSET[$key]	.=	"\n</fieldset>\n\n";
	
}


//se non è stato stabilito l'ordine dei fieldset seguo l'ordine di apparizione da DB

if	(	!trim(${$tb}[fieldset_order])		)	:

	foreach ($FIELDSET as $key => $value) :
		
		$form	.=	$FIELDSET[$key];
		
	endforeach;
	
	
else:

	foreach (explode(" ",${$tb}[fieldset_order]) as $value) :
		
		$form	.=	$FIELDSET[$value];
		
	endforeach;
	

endif;







$form	.=$Form->tripleSubmit();


$form	.=$Form->close();












//aggiungo eventuale lista correlata
if	(	preg_match(	"/".$tb."\[[^\[\]]*\]/",FORM_RELATED_LISTS	)	)	:
				
	$related_list	=	preg_replace(	"/.*".$tb."\[([^\[\]]*)\].*/","$1",FORM_RELATED_LISTS	);
	
	$form	.=	list_($related_list," WHERE ".primary_key($tb)."='".$_GET[item_id]."'",1,1,'scroll');	
	
endif;

//print_r($_POST);

return $form;


}



//-------------------------------------------------//





?>