<?php

/*
 *
 * Crudo 2012. Created by of Adriano Martino.
 *
 * You cannot use any part of this code without prior author's permission
 * Thanks for your cooperation  - www.adrianomartino.com
 *
 * Login Class change state based on the User state defined by the User controller USER_C
 *
 */

class Login_C{
    
    static private $context;
    
    private function __construct($context){
        
        //use static model
        
        if(!User_C::$is_logged_in):
            
            //call view based on context
            
        else:
            
            //call view based on context
        
        endif;
            
        
    }
    
}