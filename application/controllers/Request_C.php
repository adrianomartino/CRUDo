<?php

class Request_C{
    
    /*
     defines important constants with URL information
     URL_ACTION ( new - edit - delete - delete_image )
     PAGE_LANG
     AREA
     MAIN_TOPIC
     PAGE_TYPE ( Index | Page )
     PAGE_TOPIC    ( the url of the )
     MAIN_TOPIC FILTERS //not yet supported
     CUID //current universal id based on URL
     
     
     ADD SUPPORT FOR 404!!!
    */
    
    private $_UrlTopics;
    private $_UrlLevels; //array
    private $_urlLevels; //string
    
    
    /*
     *
     *
     * if the last piece of url is edit / delete / new and memorize action
     * ( only if in admin area, redirect to home in if is not admin area
     * so off course take it off of the url topics
     *
     * for the rest if the last part is actually an item, control if it's
     * just one item on the db, otherwise if no topic has been specified
     * ask clarification.
     *
     * If instead is just one item of that name in the system check if the
     * address is fine, if not redirect to correct address.
     *
     * The address configuration can be made in the config.php ini file
     *
     * Need also to add function to go from public to admin when user digits edit
     * at the end of an article.
     *
     * #### NOW this version is simpler it only allows 1 topic and the item name
     *
     */
    
    
    public function __construct(){
        
        //--------- URL LEVELS --------//
        $this->_defineUrlLevels();
        
        
        //--------- PAGE LANG --------//
        define('PAGE_LANG',$this->_getUrlLanguage());
        
        
        //--------- DEFINE URL ACTION ----------//
        define(
               'URL_ACTION',
               Strings::getLastMatch($this->_urlLevels,'new,edit,delete,delete_image')
              )
        ;
        
        //--------- DEFINE EDIT MODE ----------//
        if(URL_ACTION and URL_ACTION=='new')
            define('EDIT_MODE','new');
       
        if(URL_ACTION and URL_ACTION!='new')
            define('EDIT_MODE','edit');
            
        if(!URL_ACTION)
            define('EDIT_MODE','none');
        
        
        //--------- ADMIN OR PUBLIC --------//
        if( $this->_isAdminUrl() )
            define('AREA','Admin');
        else
            define('AREA','Public');
        
        
        //--------- DEFINE PAGE TOPICS --------//
        $this->_UrlTopics    =   $this->_getTopics();
        
        
        ////temporary to disable bigger url until adding support for filter
        //$n_of_topics=sizeof($this->_UrlTopics);
        //if($n_of_topics > 2 ) die ('Too many topics!');
        
        
        
        if(!$this->_UrlTopics and !URL_ACTION):
            
            define('MAIN_TOPIC','Home');
            define('PAGE_TOPIC',NULL);
            define('PAGE_TYPE','Index');
            return true;
        
        else:
            
             //define main topic, basically the first level of the url that we need also to decide the structure
            define('MAIN_TOPIC',Arrays::getFirstValue($this->_UrlTopics));
            
   
            //define page topic basically the current item url name
            define('PAGE_TOPIC',Arrays::getLastValue($this->_UrlTopics));
            
            
            //define current UID if present
            define('CURRENT_UID', CrudoQuery::getUID(PAGE_TOPIC));
            
            //id I cannot find UID i return 404
            if(!CURRENT_UID):
                if(!file_exists(APPLICATION.'/controllers/'.ucfirst(PAGE_TOPIC).'_C.php') and !file_exists(APPLICATION.'/views/public/'.ucfirst(PAGE_TOPIC).'_V.php')):
                    header("HTTP/1.0 404 Not Found");
                    echo 'Men&ugrave; vera bologna: la pagina specificata &egrave; inesistente, in costruzione o in aggiornamento, la preghiamo di tornare alla <a href="'.ROOT.'">home</a>';
                    exit;
                endif;
           endif;
            
            //Specify page type
            $page_type=(!URL_ACTION) ? 'List' : 'Page';
            define('PAGE_TYPE',$page_type);
            unset($page_type);

                ###in future version needs to be renamed Index & Item.
                //to do that we need to check a lot of file AND functions naming
        endif;
        
        
        ###not used at the moment
        define('CURRENT_CONTEXT',AREA.'_'.PAGE_TYPE);
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        ####CHECK PAGE TYPE, MAYBE WE DON'T NEED IT
        
        
        
        //--------- MAIN_TOPIC FILTERS AND OTHERS TO DOOOO --------//
        
       // if(sizeof($this->_UrlTopics) > 1 ):  //if there's more than 1 topic

                                        
        ###ALL THIS OPTIONS TO VERIFY LATER!!!
        
        //if it's an article I verify the address
         
        //if the address is not right I redirect to right address.
         
        //if it's not an address I verify if it's a topic filter
         
        //if it's not a topic filter either I give 404


    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //-------------- PRIVATE FUNCTIONS -----------------//
    
    ### Need cleanup on unused functions and class vars
    
    private function _firstLevel(){
        /*
         Note: requires 'Strings'
         retrieves the 1st virtual /something
         used especially to check if a language
         has been requested for instance
        */
        
        return Strings::getFirstPiece($this->_urlLevels());
    
    }
    
    private function _firstTopic(){
        
        $_UrlTopics=$this->_UrlTopics;
        if($_UrlTopics) return $_UrlTopics[0];
    
    }
    

    
    
    private function _getCurrentUrlPath(){
        /*
        returns the current url path
        without query string
        */
        if(isset($_SERVER['REDIRECT_URL'])) return $_SERVER['REDIRECT_URL'];
        
        
       $Url = explode("?", $_SERVER['REQUEST_URI']); return $Url[0];

    }
    
    private function _getMainTopic(){
        
        $_UrlTopics=$this->getTopics();
        
        return $_UrlTopics[0];
    }
    
    private function _getTopics(){
         
         $UrlLevels=$this->_UrlLevels;
         
         if(!$UrlLevels) return false;
         
        //eliminate eventual /admin/
        if($UrlLevels[0]=='admin'):
        
            unset($UrlLevels[0]);
            $UrlLevels=Arrays::removeEmptyValues($UrlLevels);
        
        endif;
        
        //eliminate eventual lang
        if(isset($UrlLevels[0]) && International::isLang($UrlLevels[0])):
            
            unset($UrlLevels[0]);
            $UrlLevels=Arrays::removeEmptyValues($UrlLevels);
            
        endif;
        
        
        //eliminate eventual requests of actions
        $UrlLevels=Arrays::removeValues($UrlLevels,'new,edit,delete,delete_image');
        
        
        return $UrlLevels;
        
    }
    

    
    private function _getUrlLanguage(){
        /*
         requires 'International' Class
         returns the language of the URL
         or false if no lang has been specified
         
         OF course I calculate first
         and second level since if we are in
         admin the lang would be the second virtual dir
        */
        
        $UrlLevels=$this->_UrlLevels;
        
        if(isset($UrlLevels[0]))
            if(International::isLang($UrlLevels[0]))
                return $UrlLevels[0];
        
        if(isset($UrlLevels[1]))
            if(International::isLang($UrlLevels[1]))
                return $UrlLevels[1];
    
        return DEFAULT_LANGUAGE;
        
    }
    
    
    private function _defineUrlLevels(){
        /*
         NOTE: Needs 'ServerInfo' class
         
         returns only the virtual path,
         stripping any subpath made to
         get to the current script itself
         
         Eg.: if your script is in
         /path1/path2/scriptname.php
         
         and the address digited is:
         /path1/path2/virualpath/anotherpath/?any=query#anchor
         
         it will understant that virtual path is:
         /virtualpath/anotherpath/
         
         and it will return
         
         array(
            0=>virtualpath
            1=>anotherpath
         )
        */
        
        
        $full_path=$this->_getCurrentUrlPath();
        $phisical_path=ServerInfo::getCurrentScriptDir();
        $_urlLevels=substr($full_path,strlen($phisical_path),strlen($full_path));

        
        $_UrlLevels=explode("/", $_urlLevels);
        $_UrlLevels=array_map('trim',$_UrlLevels);
        $_UrlLevels=Arrays::removeEmptyValues($_UrlLevels); //to ignore multiple slashes etc.
        
        $this->_UrlLevels=$_UrlLevels;
        $this->_urlLevels=implode('/',$_UrlLevels);
    }
    
    private function _isAdminUrl(){
        
        //returns true if the url start by /admin/
        $UrlLevels=$this->_UrlLevels;
        
        return (isset($UrlLevels[0]) && $UrlLevels[0]=='admin');
        
    }
    
    

    

    
}