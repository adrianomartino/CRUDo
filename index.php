<?php

/*
 * Crudo Framework Version 1.0
 * copyright © Adriano Martino 2011 (www.adrianomartino.com)
 * 
 * index page 2.0
 * 
*/

    //get start time (finish time is in footer.php                                   
    define('START_TIME' , getmicrotime());
    
    error_reporting(-1);


    //load configuration and classes
    require_once 'application/bootstrap.php';
    new Router();
    
        
    print_r(User_M::getBasicInfo('aadfadf','adfadsdf'));
    

   
    //get microtime function
   function getmicrotime(){
       list($usec, $sec) = explode(" ",microtime()); return ((float)$usec + (float)$sec);
   }