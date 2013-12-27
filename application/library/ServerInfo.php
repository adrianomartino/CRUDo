<?php


class ServerInfo{
    
    
    static function getCurrentScriptDir(){
        /*
         Note: requires 'Strings' from this library
         returns a string containing the relative
         path to the current fisical folder
         
         Eg.: if current script is fisically in
         www.yourhost.com/application/index.php
         it will return /application/
        */
    
        return Strings::ditchLastPiece($_SERVER['SCRIPT_NAME']);
        
    }
    
    
    
}