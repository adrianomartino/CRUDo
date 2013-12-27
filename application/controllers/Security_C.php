<?php

class Security_C{
    
    /*
     Checks if the transaction is safe
     and memorize the user short ip
     in a super constant
    */
    
    
    public function __construct(){
        
        //ban eventual hacker without ip
        if(!$this->_itsSafe()) die('watch out what you\'re doing dude!');
        
        //register user ip in var
        define('SHORT_IP',self::_getShortIp());

        //remove magic quotes
        if (get_magic_quotes_gpc()) :
            $_GET    = $this->_remove_magic_quotes($_GET);
            $_POST   = $this->_remove_magic_quotes($_POST);
            $_COOKIE = $this->_remove_magic_quotes($_COOKIE);
        endif;
        
        //filter get requests
        new FilterGetRequests(ALLOWED_GET_VARS);

    }
    

    
    private function _accessingFromLocal(){
        
        return ($_SERVER['HTTP_HOST']=='localhost');
        
    }

    
    
    private function _getRealIpAddress(){
        /*
         idea from: http://roshanbh.com.np
        */

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
         return$_SERVER['HTTP_X_FORWARDED_FOR'];
         
         return $ip=$_SERVER['REMOTE_ADDR'];

        return false;
    
    }
    
    
    private function _getShortIp(){
        
        return self::_ipToNumeric(self::_getRealIpAddress());    
        
    }
    
    
    
    
    private function _ipIsValid(){
        
        if(self::_getShortIp()) return true; return false;
        
    }
    


    
    private function _ipToNumeric($dotted_ip_address){
        /*
         prepares an ip address for storages
         Mysql field must be int(11) unsigned 4 bytes
         To select dotted IP from Mysql use:
         INET_NTOA(ip)
        */
    
        return sprintf("%u", ip2long($dotted_ip_address));
    
    
    }
    
    
    
    private function _itsSafe(){
        
        return ($this->_ipIsValid() || $this->_accessingFromLocal());
        
    }
    
    
    private function _remove_magic_quotes($array) {
        
        foreach ($array as $k => $v)
            if (is_array($v))
                $array[$k] = remove_magic_quotes($v);
            else
                $array[$k] = stripslashes($v);
    
        return $array;

    }
    
    
}
