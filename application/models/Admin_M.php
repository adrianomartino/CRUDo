<?php

class Admin_M{
    
    static function getAdminMenu(){
        
        $Maintopics=EasyQuery::query('SELECT _item_generator.universal_id, name_or_title, item_url, item_lang, parent FROM _item_generator natural join _item_metadata WHERE parent="0" ORDER BY name_or_title LIMIT 0,100');
        
        
     
        
        return $Maintopics;

    }
    
    
}