<?php

/*
 
 
This Class Manages the different kind of messages that we might need to display
Admin = (only for website administrators - PHP errors, MySql Errors etc. )
Error=General Errors for static
Warning=Warning messages
Success=Success - Positive messages
Info=Info messages
*/

class Notify{
    
    static $All; //array
    
    

    
    static function developer($message){
        
        self::addToMessages('developer', $message );
        
    }
    
    
    static function adminError($message){
        
        self::addToMessages('admin_errors', $message );
        
    }
    
    
    static function userError($message,$where=NULL){
        
        self::addToMessages('user_errors', $message, $where );
        
    }
    
    
    static function warning($message){
        
        self::addToMessages('warning_messages', $message );
        
    }
    
    
    static function success($message){
        
        self::addToMessages('success_message', $message );
        
    }
    
    
    static function info($message){
        
        self::addToMessages('info_messages', $message );
        
    }
    
    
    
    //this function loads the messages in the current session
    static function addToMessages($message_type, $message, $where=NULL){
        
        self::$All[$message_type][]  =   $message;
        
    }
    
    
    
    
}