<?php

class User_C{
    /*
     * 'developer','admin','supervisor','editor','registered','public'
     *
     */
    static
    $full_name=false,
    $user_email,
    $id,
    $instanciated=false,
    $is_admin=false,
    $is_logged_in=false,
    $lang=DEFAULT_LANGUAGE,
    $user_level='developer',
    $user_password='pwd',
    $short_ip=false,
    $can_read='ALL',
    $can_create='ALL',
    $can_edit='ALL',
    $can_publish='ALL',
    $can_destroy='ALL',
    $groups,
    $public_can_create='COMMENTI,UTENTI'
;
  
  

    
    
    public function __construct($short_ip){
        
        //logout if any
        if(isset($_GET['logout'])) self::logout();
            
        //make sure we instanciate it once
        if(!self::$instanciated):
        
            self::$short_ip=$short_ip;
            self::$user_email=Data::tryToGet('user_email');
            self::$user_password=Data::tryToGet('user_password');

            //if there are login data I try to login
            if(self::$user_email && self::$user_password) self::login();
            
            //get permissions
            self::getPermissions();
            
            self::$instanciated=true;//keep at the end of the construct
        endif;

    }
    
    
    
    static function login(){
        
        //look for user in DB
        $UserInfo=User_M::getBasicInfo(self::$user_email,self::$user_password);
        
        if($UserInfo):
        
            foreach($UserInfo as $data_name=>$data_value):
                
                //memorize in class
                self::${$data_name}=$data_value;
                
                //memorize in cookie and session
                Data::makeCookie($data_name,$data_value);
            
            endforeach;
            echo 'Logged in as '.self::$user_email.' ['.$UserInfo['user_level'].']';
            
            self::$is_logged_in=true;
            Notify::success('Logged in as '.self::$user_email.' ['.$UserInfo['user_level'].']');
        else:
        
            self::$is_logged_in=false;
            self::logout();
        
        endif;
        
    }
    
    
    
    static function getPermissions(){
        
        //load permissions configuration
        $Permissions=parse_ini_file('permissions.php',true);
        
        //get just the current user permissions
        $UserCanDo=$Permissions[self::$user_level];
        unset($Permissions);
        
        //assign
        foreach($UserCanDo as $perm_type => $perm_value)
            self::${$perm_type}=$perm_value;

        //put function to select the groups
        if( self::$user_level=='editor' || self::$user_level=='supervisor' )
            self::$groups=User_M::getUserGroups();
        
    }
    
    
    
    
    static function logout(){
        
        $UserData=get_class_vars(__CLASS__);
        
        foreach($UserData as $data_to_destroy=>$value):
            
            //destroy within class        
            self::${$data_to_destroy}=false;
            
            //destroy in sessions and cookies
            Data::destroy($data_to_destroy);
        
        endforeach;
        
        
    }
    
    

}