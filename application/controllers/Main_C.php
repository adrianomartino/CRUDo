<?php

class Main_C{
    
    public $Main_Page_C;
    static $uid;
    public $Data;

    
    function __construct(){
        
        #//load main page data into simple vars to make view simpler
        #//off course ignoring the sub arrays this is not going to affect other page data
        #if($Data && PAGE_TOPIC)
        #    foreach($Data as $key=>$value)
        #            ${$key}=$value;
        
        
        
        // Enable GZip encoding.
        ob_start("ob_gzhandler");
        header('Content-Type: text/html; charset=utf-8');
        
        //get view file

        include($this->_selectPageView());

    }
    
    
    
 
    
    protected function _selectPageView(){

        //----ADMIN
        if( AREA=='Admin' ):
        
            if( !User_C::$is_admin )
                return ADMIN_VIEWS_DIR.'Admin_V.php';
            else
                return ADMIN_VIEWS_DIR.'Login_V.php';
        
        endif;
        
        

        //----- PUBLIC
        
        //if main topic is home I return index
        if(MAIN_TOPIC=='Home')
            return PUBLIC_VIEWS_DIR.'Home_V.php';
        
        
        //look if there's a special view for this page
        if(PAGE_TOPIC)
            if(file_exists(PUBLIC_VIEWS_DIR.'special/'.PAGE_TOPIC.'_V.php'))
                return PUBLIC_VIEWS_DIR.'special/'.PAGE_TOPIC.'_V.php';

                
    
        //define view name
        $base=Strings::underScoreToUcFirst(MAIN_TOPIC);
        $V_Name=$base.'_'.PAGE_TYPE.'_V.php';
        
        
        
        if(file_exists(PUBLIC_VIEWS_DIR.$V_Name))
            return PUBLIC_VIEWS_DIR.$V_Name;
        elseif(file_exists(PUBLIC_VIEWS_DIR.'Default_'.PAGE_TYPE.'_V.php'))
            return PUBLIC_VIEWS_DIR.'Default_'.PAGE_TYPE.'_V.php';
        else
            die($V_Name.' or and it\'s '.PAGE_TYPE.' default don\'t exist');
    
    
            
    }

    
    
}