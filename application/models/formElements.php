<?php

//this class help generating form elements
//withouth retyping too much HTML each time

class FormElements extends FormBuilder{
    
    
    //hidden field
    function hidden($field_name,$value=1){
        
        return "<input type='hidden' name='$field_name' id='$field_name' value='$value'/>";
    
    }
    
    
    
    
    
    
    
    //--INPUT----------------------------//
    
    function input($nome,$value="",$maxlength='100',$class,$err_mess,$label='',$br='',$disabled=''){
    global $outPut;
    
    if(!$label): $label=$outPut->label($nome); endif;
    
    
    //se è stato sbagliato l'inserimento, popolo il campo con POST per lasciare l'esempio dell'errore
    if($_SESSION[err_mess][$nome])	:	$value	=	$_POST[$nome];	endif;
    
    if(!$value): $display_value=$_POST[$nome]; else:	$display_value=$value;	endif;
    
    
    
    if ($br!="NOBR"):$br="<br />"; else: unset($br); endif;
    
    if($disabled): $disabled=" disabled=\"disabled\""; endif;
    
    return
    
    
    
    "<label for=\"".$nome."\"><strong>".$label."</strong></label>
    ".$this->hidden('PRE_'.$nome,$outPut->text($value))."
    <input type=\"text\" name=\"".$nome."\" id=\"".$nome."\" value=\"".$outPut->text($display_value)."\" maxlength=\"".$maxlength."\"".$disabled."".$class." />
     ".$br.$err_mess."";
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //--SELECT----------------------------//
    
    function select($nome,$data_list,$selected='',$label='',$br='',$disabled=''){
    global $outPut;
    
    if(!$label): $label=$outPut->label($nome); endif;
    
    
    if(!$selected): $display_selected=$_REQUEST[$nome]; else: $display_selected=$selected;	endif;
    
    
    if($disabled): $disabled=" disabled=\"disabled\""; endif;
    
    
    if	(	!is_array(	$data_list	)	)	:	return "values list for ".$nome." is not an array<br/>";	endif;
    
    
    
    
    for	(	$i=0;	$i<	count(	$data_list	)	;	$i++	)	:
    
    
    if	(	$data_list[$i]	==	$display_selected	)	:	$_selected=" selected='selected'";	endif;
    
    $options	.=	"<option value='$data_list[$i]'$_selected>value_to_label($nome,$data_list[$i])</option>\n";
    
    unset(	$_selected	);
    
    endfor;
    
    return
    
    
    "<label for=\"".$nome."\"><strong>".$label."</strong></label>
    ".$this->hidden('PRE_'.$nome,$selected)."
     <select name=\"".$nome."\" id=\"".$nome."\" ".$disabled.">
     
     ".$options."
     
     </select>
    ";
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //--FILE----------------------------//
    
    function file_($fd,$tb,$item_id='',$label='',$br=''){
    global $upload,$outPut,$dbSwitch,$Gestione;
    
    
    if	(	!$tb	)	:	$tb=$_GET[cat];	endif;
    
    
    
    if	(	!$item_id	)	:	$item_id=$_GET[item_id];	endif;
    
    if	(	$item_id	)	:
    
    
    
            //se è stato caricato il file e se sappiamo a cosa associarlo lo carico
            
            
            if	(	$_FILES[$fd]	)	:	
            
                    $upload->load_file($fd,$tb);			
            
            endif;
            
            
            
            
            
            //determino percorso file
            
            $ext					=		$dbSwitch->select_one($fd,$tb,$item_id);
            
            $file_script_address	=		get_file_path(	"SCRIPT",$fd,$tb,$ext	);
            $file_http_address	=			get_file_path(	"HTTP"	,$fd,$tb,$ext	);
            
            
            
            
            
            
            // eseguo eventuale cancellazione richiesta
            
            if	(	(	$_REQUEST[_function]=="delete_file"	)	&&	(	$_REQUEST[file_field_name]	==	$fd	)	&&	(	!$GLOBALS[$fd]	)	)	:
            
            
                    $upload->overwrite($file_script_address);
            
            
            endif;	
            
            
            
            
            
            
            
            //indirizzo se è immagine
            $sz	=	explode(" ",UPLOAD_IMAGES_SIZES);
            $sz	=	$sz[count($sz)-1];
                    
            $image_script_address	=	preg_replace("/(.*)(\.jpg|\.gif|\.png)/","$1_".$sz."$2",$file_script_address);
            
            
            
            //se il file esiste pubblico il link per scaricarlo e per la cancellazione
            
            
            
            if	(	file_exists(	$file_script_address	)	)	:
            
            
                            $icon	=	SCRIPT_SHARED."file-icons/".$ext.".gif";
                            
                            
                            if	(	file_exists(	$icon	)	)	:
                            
                            
                                    $icon	=	SHARED."file-icons/".$ext.".gif";
                            
                            
                            else:
                            
                                    
                                    $icon	=	SHARED."file-icons/unknown.gif";
                            
                            
                            endif;
                            
                            
                            
                            $delete_address	.=	"_function=delete_file&file_field_name=".$fd;
                                            
                            $del_link="\n<a href='get_file_path(	HTTP',$fd,$tb,$ext	)' class='download-button' title='scarica il file sul tuo PC'><span>scarica</span></a>";
                            
                            $download_link="\n<a href='$delete_address' class='delete-button' title='elimina il file presente'>elimina</a>";
                    
                            
                            
                            print $image_script_address;
                            
                            
            elseif	(	file_exists(	$image_script_address	)	)	:
                    
                            $icon	=	$upload->print_image(	$file_http_address	);
                    
            
                    $delete_address	=	$_SERVER['REQUEST_URI'];
                    
                    if	(	preg_match("/\?/", $_SERVER['REQUEST_URI']	)	)	:
                    
                            $delete_address	.=	"&";	else:	$delete_address	.=	"?";
                    
                    endif;
                    
                    
                    $delete_address	.=	"_function=delete_file&file_field_name=".$fd;
                                    
                    /*$del_link="\n<a href='get_file_path(	"HTTP",$fd,$tb,$ext	)' class='download-button' title='scarica il file sul tuo PC'><span>scarica</span></a>";*/
                    
                    $download_link="\n<a href='$delete_address' class='delete-button' title='elimina il file presente'>elimina</a>";
                    
                    
            else:
            
            
                    $icon	=	SHARED."file-icons/empty.gif";
                    
            
            endif;
            
            
            
            
            if	(	!preg_match("/img src/",$icon)	)	:	//se non è stata già messo il tag img
            
                    $icon	=	"<img src='$icon' class='file-icon' />";
            
            endif;
            
            
    
    
    else:
    
            
            $disabled=" disabled='disabled'";
            $mess	.=	"&egrave; necessario salvare la pagina prima di associare file";
            
    
    endif;
    
    //--fine link per scaricare e per la cancellazione
    
    
    
    
    
    
    
    
    if(!$label): $label=$outPut->label($fd); endif;
    
    
    
    if ($br!="NOBR"):$br="\n<br />\n\n"; else: unset($br); endif;
    
    return
    $icon.
    "<label for=\"".$fd."\"><strong>".$label."</strong></label>
    ".$mess."
    <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".MAX_FILE_SIZE."\" />
    <input type=\"file\" name=\"".$fd."\" id=\"".$fd."\"".$disabled." />\n".
    
    $download_link.
    $del_link;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //--PASSWORD----------------------------//
    
    function password($nome,$value="",$maxlength='100',$label='',$br=''){
    
    if(!$label): $label=$outPut->label($nome); endif;
    
    if ($br!="NOBR"):$br="<br />"; else: unset($br); endif;
    
    return
    
    "<label for=\"".$nome."\"><strong>".$label."</strong></label>
     <input type=\"password\" name=\"".$nome."\" id=\"".$nome."\" value=\"".$value."\" maxlength=\"".$maxlength."\" />
     ".$br;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    //--TEXTAREA----------------------------//
    
    function textarea($nome,$value="",$maxlength='',$label='',$format_tips="NOTIPS"){
    global $outPut;
    
    if(!$label): $label=$outPut->label($nome); endif;
    
    $rows=4;
    
    
    if(!$value): $display_value=$_POST[$nome]; else:	$display_value=$value;	endif;
    
    
    /*
    
    if($format_tips!="NOTIPS"): $format_tips=
    
    "(suggerimenti per la formattazione:
     [T]<span class=\"titoletto\">Titoletto</span>[/T] -
     [G]".$GLOBALS[outPut]->text('[G]grassetto[/G]',0,1,0,0,0,0)."[/G]
     [L=www.indirizzolink.com]".$GLOBALS[outPut]->text('[L=www.indirizzolink.com]Titolo link[/L]',0,1,0,0,0,0)."[/L])<br /><br />
     ";
     
     else:*/ unset($format_tips); /* endif;*/
    
    if($maxlength):  $display_limit="<script type=\"text/javascript\">displaylimit(\"document.getElementById('$nome')\",".$maxlength.")</script>";$style="style='margin-bottom:0'"; endif;
     
     
    return
    
    $this->hidden('PRE_'.$nome,$value).
    
    "<label for=\"".$nome."\"><strong>".$label."</strong></label>
    ".$format_tips." 
    <textarea name=\"".$nome."\" id=\"".$nome."\" rows=\"".$rows."\" ".$style." cols=\"40\">".$display_value."</textarea><br />
    
    ".$display_limit
    ;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    //--CHECKBOX----------------------------//
    
    function checkbox($nome,$checked=false,$value=1,$label='',$code_after=''){
    global $outPut;
    
    
    if(!$label && ($label != "NO_LABEL")):
    
            $label=$outPut->label($nome);
    
    elseif (	$label == "NO_LABEL"	)	:
    
            unset($label);
    
    endif;
    
    
    
    if($checked): $check="checked='checked'"; endif;
    
    
    return
    
    "<input type='checkbox' name='$nome' id='$nome' value='$value' style='width:auto;float:left' ".$check."/>
     <label for='$nome'><strong>".$label."</strong></label>".$code_after."
     <div class='clear'></div>
     ";
    }
    
    
    
    
    
    
    
    
    
    
    
    
    //--HIDDEN FIELD----------------------------//
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //--SUBMIT----------------------------//
    
    function submit($label='salva e continua',$name='salva-e-continua',$class=''){
    
    if($class): $class=" ".$class; endif;
    
    return  "<input type='submit' name='$name' id='$name' value='$label' class='form-buttons'$class/> <br />";
    
    }
    
    
    
    
    
    //--TRIPLE SUBMIT----------------------------//
    
    function tripleSubmit(){
    
    return  
    "
    <fieldset id='triple-submit'>
    <input type='button' name='stampa' id='stampa' value='stampa' class='form-buttons stampa' onclick='window.print();' />
    <input type='submit' name='salva-e-chiudi' id='salva-e-chiudi' value='salva e chiudi' class='form-buttons salva-e-chiudi' />
    <input type='submit' name='salva-e-continua' id='salva-e-continua' value='salva e continua' class='form-buttons salva-e-continua' />
    
    </fieldset>";
    
    }
    
    
    
    
    
    
    
    
    
    
    //--REGIONI----------------------------//
    
    function regione($selected=''){
    
    global $dbSwitch;
    
     
    $dati=$dbSwitch->select('SELECT * FROM regione');
    
    
    
    if(!$selected): $selected=$_POST[regione]; endif;
    
    
    
    if(!is_array($dati)): return $dati; else:
    
    $sel_[$selected]="selected='selected'";
    
    for($i=0; $i<sizeof($dati); $i++):
    $options.="<option value='$dati[$i][id]' ".$sel_[$dati[$i][id]].">".$dati[$i][nome]."</option>\n";
    endfor;
    
    
    endif;//fine se  un'array
    
    
    
    
    
    
    
    return
    
           "<label for=\"regione\"><strong>regione</strong></label>\n
    ".$this->hidden('PRE_regione',$selected)."
            <select name='regione' id='regione'>
            ".$options."
            </select><br/>        
    ";
    
    
    }
    
    
    
    
    
    
    
    
    
    
    
    
    //--PROVINCIE----------------------------//
    
    function provincia($selected=0){
    
    global $dbSwitch;
    
     
    $dati=$dbSwitch->select('SELECT * FROM provincia');
    
    
    if(!$selected): $selected=$_POST[provincia]; endif;
      
    
    if(!is_array($dati)): return $dati; else:
    
    $sel_[$selected]="selected='selected'";
    
    for($i=0; $i<sizeof($dati); $i++):
    $options.="<option value='$dati[$i][id]' ".$sel_[$dati[$i][id]].">".$dati[$i][nome]."</option>\n";
    endfor;
    
    
    endif;//fine se  un'array
    
    
    return
    
           "<label for=\"provincia\"><strong>provincia</strong></label>
    ".$this->hidden('PRE_provincia',$selected)."
            <select name='provincia' id='provincia'>
            ".$options."
            </select><br/>        
    ";
    
    }
    
    
    
    
    
    //--IP----------------------------//
    
    function ip(){
    
    return "<input type='hidden' name='ip' id='ip' value=".$_SERVER['remote_addr']." />";
    
    }
    
    
    
    
    
    
    
    
    
    //--CLOSE FORM----------------------------//
    
    function close($fieldset=''){
    
    if($fieldset): $fieldset="\n</fieldset>\n"; endif;
    
    return $fieldset."<div class='clear'></div></form>\n<!--FINE FORM-->\n\n";
    
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    #################### CAMPI SPECIALI ####################
    
    function dynamic_select($name,$tb,$labels,$label='',$selected='',$where=''){
    
            global $dbSwitch;
            
            
            
            //se esiste una chiave primaria nella tabella, la uso per i valori del select altrimenti il valore sarà lo stesso dei labels.
            $values	=	primary_key($tb);
            
            
    //	if	(	!$selected	&&	$_REQUEST[$values]	)	:	$selected=$_REQUEST[$values];	endif;
            
                    
            if	(	$values	&&	$values	!=	$labels)	:	$sel_values	=	','.$values;	else:	unset($values);	endif;
            
             
                    $sql='SELECT '.$labels.$sel_values.' FROM '.$tb;
                    
                    $dati=$dbSwitch->select($sql);
              
            
                    if(!is_array($dati)): return $dati; else:
                    
                    $sel_[$selected]="selected='selected'";
                    
                            for($i=0; $i< sizeof($dati); $i++):
                            
                                                    
                                    if	(	!$dati[$i][$values]	)	:	$dati[$i][$values]	=	$dati[$i][$labels];	endif;
                            
                            $options.="<option value='$dati[$i][$values]' ".$sel_[$dati[$i][$values]].">".$dati[$i][$labels]."</option>\n";
                            endfor;
                            
                    
                    endif;//fine se  un'array
            
            
                    if	(	!$label	)	:	$label	=	$outPut->label($labels);	endif;
                    
                    
                    return
                    
                               "<label for=\"".$name."\"><strong>".$label."</strong></label>
                    ".$this->hidden('PRE_'.$name,$selected)."
                                    <select name='$name' id='$name'>
                                    ".$options."
                                    </select><br/>        
                    ";
    
    
    }
    
    
    
    
    
    
    
    
    
    function checkbox_list($related_values_field,$deepest_tb,$list_join_field,$quantity=false){
    
            /*	questa funzione prende la prima variabile $tb
                    durante la definizione della costante CUSTOM_FIELD_TYPES
                    presente nel file formconfig.php, ovvero prende il
                    nome del campo da rendere custom						*/
    
    //		print $related_values_field.$where;
    
            
            /*	in questo caso per la funzione list non specifichiamo
                    il $tb in quanto la prendiamo dal valore GET e passo
                    tutto nella seconda variabile WHERE						*/
    
            return checkbox_list($related_values_field,$deepest_tb,$list_join_field,$quantity);
            
    
    
    }
    
    
    
    
    
    
    function quantity_value($field_name,$tb='',$item_id='')	{
    
            global $dbSwitch,$outPut;
            
            $quantity	=	0;
            $value		=	0;
    
            if	(	!$tb	)	:
            
                    $tb	=	$_REQUEST[cat];
            
            endif;
            
            
            if	(	!$item_id	)	:
            
                    $item_id	=	$_REQUEST[item_id];
            
            endif;
            
            
            
            
            //effettuo eventuale aggiornamento
            if	(	$_POST[$field_name."_quantity"]	&& $_POST[$field_name."_value"]	)	:
            
                    //$dbSwitch->insert("UPDATE ".$tb." SET ".$field_name."='$_POST[$field_name."_quantity"]."[".$_POST[$field_name."_value"]."]' WHERE ".primary_key($tb)."='$item_id'");
            
            endif;
            
            
            
            
                    
            //seleziono l'eventuale quantità e valore
            
            $datas		=	$dbSwitch->select_one($field_name,$tb,$item_id);		//formato dati quantity[value] es 3[40,00] (3 ore da 40 euro)
            
            $value		=	preg_replace("/[^\[\]]*\[([^\[\]$]*)\].*/","$1",$datas)	;
            
            $quantity	=	preg_replace("/([^\[\]]*)\[[^\[\]$]*\].*/","$1",$datas)	;
            
    
            return "\n<fieldset id='$field_name'>
            <legend>".$outPut->label($field_name)."</legend>
            
            <div class='quantity_value'>
            
            <div class='quantity_value_q'>
            <label for='$field_name_quantity'>quantit&agrave;</label>
            <input type='text' id='$field_name_quantity' name='$field_name'_quantity' value='$quantity'	/>
            </div>
            
            <div class='quantity_value_v'>
            <label for='$field_name'_value'>costo orario</label>
            <input type='text' id='$field_name'_value' name='$field_name_value' value='$value'	/>
            </div>
            
            </div>
            
            </fieldset>\n\n";
            
            
            #CONTROLLARE#
    
            
            
    
    
    }
    
    
    
    
    
    
    function names_and_values($field_name,$tb='',$item_id=''){
            
            global $dbSwitch,$outPut;
            
            if	(	!$tb	)	:
            
                    $tb	=	$_REQUEST[cat];
            
            endif;
            
            
            if	(	!$item_id	)	:
            
                    $item_id	=	$_REQUEST[item_id];
            
            endif;
            
            
            
            
            $datas		=	$dbSwitch->select_one($field_name,$tb,$item_id);
            
            $datas		=	explode("|",$datas);
            
            
            
            
            
            
            //effettuo eventuale aggiornamento
            for	(	$i=0;	$i<=count($datas);	$i++		)	:
            
                    
                                    
                    $value		=	preg_replace("/[^\[\]]*\[([^\[\]$]*)\].*/","$1",$datas[$i])	;
                    
                    $name		=	preg_replace("/([^\[\]]*)\[[^\[\]$]*\].*/","$1",$data[$i])	;
                            
                    
                    $field_count=$i+1;
            
                    if	(	$_POST[$field_name."_".$field_count."_name"]	&&	(	(	$_POST[$field_name."_".$field_count."_name"]	!=	'nuova voce'	)	&&	(	$_POST[$field_name."_".$field_count."_value"]	!=	'-')	)	)	:
                    
                            
                            $to_add	.=	$_POST[$field_name."_".$field_count."_name"]."[".$_POST[$field_name."_".$field_count."_value"]."]"."|"	;

                    
                    
                    endif;
                            
            
            endfor;
            
            $sql="UPDATE ".$tb." SET ".$field_name."='$to_add'";
            
            if(	$to_add	)	:
            
                    $dbSwitch->insert("UPDATE ".$tb." SET ".$field_name."='$to_add' WHERE ".primary_key($tb)."='$item_id'");
                    
            endif;
            
            unset(	$to_add,$sql,$i);
            
            //fine eventuale aggiornamento
            
            
            
            
            
            
            
            //rileggo i dati dipo l'aggiornamento
            $datas		=	$dbSwitch->select_one($field_name,$tb,$item_id);	
            $datas		=	explode("|",$datas);
            //-----------------------------------//
            
            
            $fieldset.="<fieldset id='$field_name'>\n";
            $fieldset.="<legend>".$outPut->label($field_name)."</legend>\n";
            
            foreach	(	$datas	as	$data	)	:
            
                    $i++;
                    
                    $value		=	preg_replace("/[^\[\]]*\[([^\[\]$]*)\].*/","$1",$data)	;
                    
                    $name		=	preg_replace("/([^\[\]]*)\[[^\[\]$]*\].*/","$1",$data)	;
                    
                    
                    if	(	trim(	$name	)	)	:
                    
                            $fieldset.="
                            <div class='names_and_values'>
                            <div class='$field_name_name'>
                            <label for=".$field_name."_".$i."_name'>causale</label>
                            <input type='text' id=".$field_name."_".$i."_name' name=".$field_name."_".$i."_name' value='$name'	/>
                            </div>
                            
                            <div class='$field_name_value'>
                            <label for=".$field_name."_".$i."_value'>valore</label>
                          <input type='text' id=".$field_name."_".$i."_value' name='".$field_name."_".$i_value."' value='$value'	/>
                            </div>
                            </div>\n";
                            
                    endif;
                    
            
            endforeach;
            
            $i++;
            
            
            
                    $fieldset.="
                    <div class='names_and_values'>
                    
                    <div class='new_item ".$field_name."_name'>
                    <label for='".$field_name."_".$i."_name'>causale</label>
                    <input type='text' id='".$field_name."_".$i."_name' name='
                    ".$field_name."_".
                    $i."_name' value='nuova voce' onfocus=\"javascript:if(this.value=='nuova voce')this.value=''\" onblur=\"javascript:if(this.value=='')this.value='nuova voce'\"	/>
                    </div>
                    
                    <div class='new_item ".$field_name."_value'>
                    <label for='".$field_name."_".$i."_value'>valore</label>
                    <input type='text' id='".$field_name."_".$i."_value' name='
                    ".$field_name."_".$i.
                    "_value' value='-' onfocus=\"javascript:if(this.value=='-')this.value=''\" onblur=\"javascript:if(this.value=='')this.value='-'\"	/>
                    </div>
                    
                    </div>
                    ";
            
            unset($i);
            
            
            $fieldset.="</fieldset>\n\n";
            
            
            return $fieldset;
            
            
    }
















########################################################





}