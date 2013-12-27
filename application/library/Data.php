<?php

class Data{
    
    private $to_save_in_cookies='user_email,site_lang,user_lang'; //list

    static function addToSession($data_name,$data_value){

        $_SESSION[$data_name]=$data_value;
        
    }
    
    
    static function destroy($data){
        
        if(isset($_COOKIE[$data])) setcookie($data);

        unset($_POST[$data],$_GET[$data],$_SESSION[$data],$_COOKIE[$data],$_REQUEST[$data]);
        
    }
    
    
    
    static function makeCookie($data_name,$data_value){
        
        //memorize in session
        $_SESSION[$data_name]=$data_value;
        
        //memorize in cookie
        setcookie($data_name, $data_value, time()+60*60*24*30); //expires in 30 days
        
    }
    
    
    static function tryToGet($data){
        /*
        Establish if a variable has been
        defined through the various possibilities
        */

        if(isset($_POST[$data])) return $_POST[$data];
        
        if(isset($_GET[$data])) return $_GET[$data];
        
        if(isset($_SESSION[$data])) return $_SESSION[$data];

        if(isset($_COOKIE[$data])) return $_COOKIE[$data];

        return false;
        
    }
    
    
    
}