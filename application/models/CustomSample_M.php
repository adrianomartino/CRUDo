<?php


class Ristoranti_M extends Item_M{
    
    public $item_main_table='RISTORANTI';
    public $item_primary_key;

    
    //only in specific items
    public function selectPublicPage(){

        $sql=
        $this->composeSelect(
            'name_or_title,item_snippet,item_keywords,
             item_url,item_lang,indirizzo_ristorante,
             cap_ristorante,telefono_ristorante,email_ristorante,
             punti_di_forza_ristorante,descrizione_ristorante,
             last_modify'
            );

        return EasyQuery::query($sql);
        
        
    }
    
    
    public function selectAdminPage(){
        
        
        $sql=
        $this->composeSelect(
            'name_or_title,item_snippet,keywords,
             url,item_lang,indirizzo_ristorante,
             cap_ristorante,telefono_ristorante,email_ristorante,
             punti_di_forza_ristorante,descrizione_ristorante,
             last_modify'
            );

        return EasyQuery::query($sql);
        
       
    }
    

}