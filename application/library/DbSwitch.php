<?php

class DbSwitch{
    
    static function convertForDb($field_name, $value){
        
        //youtube
        if($field_name=='youtube_video' and trim($value))
            return YouTube::UrlToVideoId($value);
        
        
        
        
        return $value;
        
        
    }
    
    
    
    
    
    static function convertFromDb($field_name, $value){
        
        
        
        return $value;
        
    }
    
}