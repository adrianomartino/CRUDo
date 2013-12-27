<?php

/*
 * Crudo Framework Version 2.0
 * copyright © Adriano Martino 2011 (www.adrianomartino.com)
 * 
 * Loader 3.0
 * 
 */

//set if this is production environment or not
###make function to set automatically
define(	'PRODUCTION_ENVIRONMENT',true);
$display_errors=(PRODUCTION_ENVIRONMENT) ? 'On' : 'Off';

//set error reporting to display all errors 
ini_set ( 'display_errors' , $display_errors );
error_reporting(-1);


//unset globals for security reasons
if(isset($GLOBALS)) unset($GLOBALS);

//start object to enable header location even after header sent
ob_start();

//define servers constant to use in config.ini
define(	'SERVER_HTTP_HOST',$_SERVER['HTTP_HOST']);
define(	'SERVER_REQUEST_URI',$_SERVER['REQUEST_URI']);

//site doc root
$current_subfolder=dirname($_SERVER['PHP_SELF']);

$current_subfolder=(strlen($current_subfolder)==1) ? '' : $current_subfolder;

define('DOC_ROOT',$_SERVER['DOCUMENT_ROOT'].$current_subfolder.'/');
//echo DOC_ROOT; exit;



//define http root
define(	'ROOT','http://'.SERVER_HTTP_HOST.$current_subfolder.'/');


//define application Dir
define('APPLICATION',__DIR__.'/');

//server temporary folder
#define('TEMP',$_ENV['TMPDIR']);

//get site configuration
$Config = parse_ini_file( "config/config.php", true );
   
//define constants with site configuration
define_constants($Config);

//set include paths from config.php
$include_paths=implode( PATH_SEPARATOR ,$Config['include_paths']);
set_include_path($include_paths);

//Set Session Cache Expire        
session_cache_expire(SESSION_CACHE_EXPIRE);

//Start Session and 
@session_start();


//----functions----//

//define array to load all the configs into constants
function define_constants( $Config ){
    foreach( $Config as $config_group => $Values )
        if( !in_array($config_group,array_keys($Config['not_to_save_as_constants'])) )
            foreach($Values as $keyname=>$value)
                define(strtoupper($keyname), $value );
        else //if I need to save the whole array I serialize it in a costant
            define(strtoupper($config_group),serialize($Values));
}


//set the memory limit for files upload ###should be in file upload class
    //ini_set('memory_limit', '200M');


//setup autoload function
function __autoload($class){
        
    require("$class.php");


        
} 