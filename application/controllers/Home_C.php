<?php


class Home_C extends Main_C{
    /*
     Loads all the elements of the home and calls it's view
    */
    
    
    public function __construct(){
 

        
        $Piatti =    new Item_C(
                                            'piatti',
                                            'Public_Page',
                                            array(
                                            'custom_fields'=>'',
                                            'where'=>'',
                                            'limit'=>'0,5',
                                            'list_sons'=>true,
                                            'order_by'=>''
                                            )
                                            );
        
        
        
        $Piatti =   $Piatti->ItemData;
        
       //$Ristoranti =    new Item_C(
       //                                     'ristoranti',
       //                                     'Public_Page',
       //                                     array(
       //                                     'custom_fields'=>'',
       //                                     'where'=>'',
       //                                     'limit'=>'0,5',
       //                                     'list_sons'=>true,
       //                                     'order_by'=>''
       //                                     )
       //                                     );
       //
       // $Ristoranti =   $Ristoranti->ItemData;
        
        
        
        //$Eventi =    new Item_C(
        //                                    'eventi',
        //                                    'Public_Page',
        //                                    array(
        //                                    'custom_fields'=>'',
        //                                    'where'=>'',
        //                                    'limit'=>'0,5',
        //                                    'list_sons'=>true,
        //                                    'order_by'=>''
        //                                    )
        //                                    );
        //
        //
        //$Eventi =   $Eventi->ItemData;
        //
        //
        //
        //$Prodotti =    new Item_C(
        //                                    'prodotti',
        //                                    'Public_Page',
        //                                    array(
        //                                    'custom_fields'=>'',
        //                                    'where'=>'',
        //                                    'limit'=>'0,5',
        //                                    'list_sons'=>true,
        //                                    'order_by'=>''
        //                                    )
        //                                    );
        //
        //
        //$Prodotti =   $Prodotti->ItemData;
        //
        //
        //
        //
        //$Vini =    new Item_C(
        //                                    'vini',
        //                                    'Public_Page',
        //                                    array(
        //                                    'custom_fields'=>'',
        //                                    'where'=>'',
        //                                    'limit'=>'0,5',
        //                                    'list_sons'=>true,
        //                                    'order_by'=>''
        //                                    )
        //                                    );
        //
        //
        //$Vini =   $Vini->ItemData;
        //
        //
        //
        ////---Related
        //        $Related=EasyQuery::query('
        //                SELECT universal_id,name_or_title,item_url,item_lang,item_snippet
        //                from _item_generator NATURAL JOIN _item_metadata
        //                WHERE universal_id="149" or universal_id="150"
        //                ');
        
        $Antipasto=EasyQuery::query('SELECT * FROM _item_generator NATURAL JOIN _item_metadata WHERE parent='.CrudoQuery::getUID('antipasti').' AND foto=1 ORDER BY RAND() LIMIT 0,1');
        
        $Antipasto=EasyQuery::query('SELECT * FROM _item_generator NATURAL JOIN _item_metadata WHERE parent='.CrudoQuery::getUID('primi_piatti').' AND foto=1 ORDER BY RAND() LIMIT 0,1');
        
        $Primo=EasyQuery::query('SELECT * FROM _item_generator NATURAL JOIN _item_metadata WHERE parent='.CrudoQuery::getUID('primi_piatti').' AND foto=1 ORDER BY RAND() LIMIT 0,1');
        $Secondo=EasyQuery::query('SELECT * FROM _item_generator NATURAL JOIN _item_metadata WHERE parent='.CrudoQuery::getUID('secondi_piatti').' AND foto=1 ORDER BY RAND() LIMIT 0,1');
    
        
        $Piatti=array($Antipasto[0],$Primo[0],$Secondo[0]);
        
        
        
        $Prodotti=EasyQuery::query('SELECT * FROM _item_generator NATURAL JOIN _item_metadata WHERE parent=23 or parent=24 AND foto=1 ORDER BY RAND() LIMIT 0,3');
        
        $Vini=EasyQuery::query('SELECT * FROM _item_generator NATURAL JOIN _item_metadata WHERE parent=109 AND foto=1 ORDER BY RAND() LIMIT 0,3');
        
        $Eventi=EasyQuery::query('SELECT * FROM _item_generator NATURAL JOIN _item_metadata WHERE parent=105 AND foto=1 ORDER BY RAND() LIMIT 0,3');
        
            
         //echo $this->_selectPageView();
        include(self::_selectPageView());
        
    }
    
    
    
    
    
    
}