<?php

class DbDefinitions{
    /*
     Here you can define some definitions
     in order to correctly use the universal fields
     in the DB.
     
     You have item virtual prefixes such as
     nome
     
     so you will know that nome_ristorante it
     refers to the field name_or_title in the
     RISTORANTI table, thanks to the SuperQuery Functions
     that use the following arrays to make translations.
     
     This way you can make selections by virtual names,
     without bothering about specifing the table each time.
    */
    
    static $PrefixToFieldNameTranslation=
        array(
            'datacreazione'=>'creation_date',
            'ultimoaggiornamento'=>'last_modify',
            'stato'=>'item_status',
            'idcreatore'=>'user_id',
            'nome'=>'name_or_title',
            'incipit'=>'item_snippet',
            'keywords'=>'item_keywords',
            'url'=>'item_url',
            'genitore'=>'parent',
            'lingua'=>'item_lang'
            );
    
    
    static $ItemNamesTablesTranslation=
        array(
            'concorso'=>'CONCORSI',
            'categoria_prodotto'=>'CATEGORIE_PRODOTTI',
            'commento'=>'COMMENTI',
            'cuoco_patron'=>'CUOCHI_PATRON',
            'piatto'=>'PIATTI',
            'prodotto'=>'PRODOTTI',
            'ristorante'=>'RISTORANTI',
            'voto'=>'VOTI_RISTORANTI',
            'utente'=>'UTENTI',
            'anagrafica_utente'=>'UTENTI_ANAGRAFICA',
        );

    
    

    
    
}