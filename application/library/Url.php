<?php

class Url{
    
    /*
     
     
     ###ADD USE OF $current_language_url TO DISPLAY THE SIBLING URL IN THE CURRENT USER LANGUAGE
     
    */
    
    static function _($Item_url_or_uid,$admin=false,$current_language_url=false){
        /*Creates url from Item resource array*/
        
        //if I got the Url or UID I retrieve the item info
        if(!is_array($Item_url_or_uid)) $Item_url_or_uid=CrudoQuery::getItemInfo($Item_url_or_uid);
        
        //check input
         if(!is_array($Item_url_or_uid)):
            Notify::developer(__CLASS__.' '.__FUNCTION__.'() source provided is not valid');
            return false;
        endif;
        
        //generate eventual admin part
        $admin=($admin) ? 'admin/' :'';
        
        //in admin url
        $url_format=($admin) ? 'full_path' : URL_FORMAT;
        
        //take care of the language
        $lang = ( $Item_url_or_uid['item_lang'] != DEFAULT_LANGUAGE ) ? $Item_url_or_uid['item_lang'].'/' : '';
        
        //verify if item corresponds to main topic and save the information
        $is_main_topic=(CrudoQuery::isMainTopic($Item_url_or_uid['universal_id']));
       
        
        //if item is main topic or if user wants short URL I return the URL right away
        if($is_main_topic or $url_format=='short')
            return ROOT.$admin.$Item_url_or_uid['item_url'];
            
            
        if($url_format=='medium'):
        
            $ItemParent=CrudoQuery::getItemMainTopic($Item_url_or_uid['universal_id']);
            $url_main_topic=$ItemParent['item_url'].'/';
            
            return ROOT.$admin.$url_main_topic.$Item_url_or_uid['item_url'];

        endif;
        
        
        if($url_format=='full_path'):
        
            $Parents=CrudoQuery::getItemParentsInfo($Item_url_or_uid['universal_id']);
            
            foreach($Parents as $Parent )
                $UrlLevels[]=$Parent['item_url'];
                
            $url_levels=implode('/',$UrlLevels);


                

			$url=ROOT.$admin.$url_levels;

            return $url;

        endif;
            

    }
    
    
    
    static function pathToUrl($path){
        /*Transforms a sistem path to it's correspondent http url*/
        ###to finish and do the reverse function
        //take off doc root
        $path=substr($path,strlen(DOC_ROOT),1000);
        
        return ROOT.$path;
        
    }
    
    
    
}