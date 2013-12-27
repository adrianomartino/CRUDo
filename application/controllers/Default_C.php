<?php


class Default_C extends Main_C{
    
    
    
    public function __construct(){

            //get main page info
            $CurrentItem=new Item_C(
                                            CURRENT_UID,
                                            'Public_Page',
                                            array(
                                            'custom_fields'=>'',
                                            'where'=>'',
                                            'limit'=>'0,1',
                                            'order_by'=>''
                                            )
                                            );
            
            
            $CurrentItem=$CurrentItem->ItemData[0];
            
            
            $page_title=$CurrentItem['name_or_title'];
            $long_desc=$CurrentItem['long_desc'];
            


            //---list format
      //      $format=Lists_VH::$public_snippets_format;
            
            
            //---Sons
             $Sons=new Item_C(
                                            CURRENT_UID,
                                            'Public_Snippets',
                                            array(
                                            'custom_fields'=>'',
                                            'where'=>'universal_id!='.CURRENT_UID,
                                            'limit'=>'',
                                            'list_sons'=>true,
                                            'order_by'=>'ordine ASC,foto DESC,name_or_title ASC'
                                            )
                                            );
             
             
            $Sons=$Sons->ItemData;
            
            
            
            //---Siblings
            //get parent item
            $Parent=CrudoQuery::getItemParent(CURRENT_UID);
            
            
            if($Parent['universal_id']){
                $Siblings=new Item_C(
                                               $Parent['universal_id'],
                                               'Public_Snippets',
                                               array(
                                               'custom_fields'=>'',
                                               'where'=>'universal_id!='.CURRENT_UID .' AND foto=1',
                                               'limit'=>'',
                                               'list_sons'=>true,
                                               'order_by'=>'foto DESC,name_or_title ASC'
                                               )
                                               );
                
                
               $Siblings=$Siblings->ItemData;
            }
            
            
            
            
            //---Related
                $Related=EasyQuery::query('
                        SELECT universal_id,name_or_title,item_url,item_lang,item_snippet
                        from _item_generator NATURAL JOIN _item_metadata
                        WHERE universal_id="149" or universal_id="150"
                        ');
                
                
                
     if(file_exists(VIEWS_DIR.'public/'.PAGE_TOPIC.'_V.php'))
        include(VIEWS_DIR.'public/'.PAGE_TOPIC.'_V.php');
    elseif(file_exists(VIEWS_DIR.'public/'.MAIN_TOPIC.'_V.php'))
        include(VIEWS_DIR.'public/'.MAIN_TOPIC.'_V.php');
    else
         include('Default_V.php');
            

        
            
            
        
    }


}