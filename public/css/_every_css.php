<?php
   
    
require('../../application/bootstrap.php');

$Files=EasyFile::filesInDirectory(__DIR__,'css');


/**
 * On-the-fly CSS Compression Script
 * Copyright (c) 2009 and onwards, Manas Tungare.
 * Creative Commons Attribution, Share-Alike.
 *
 * Modified by Adriano Martino 2011
 *
 * In order to minimize the number and size of HTTP requests for CSS content,
 * this script combines multiple CSS files into a single file and compresses
 * it on-the-fly.
 * 
 * To use this in your HTML, link to it in the usual way:
 * <link rel="stylesheet" type="text/css" media="screen, print, projection" href="/css/compressed.css.php" />
 */


//get start time                                   
    $start_time = getmicrotime();
$page = "";
foreach ($Files as $file) {
  $page .= file_get_contents($file);
}


// Remove comments
$page = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $page);

// Remove space after colons
$page = str_replace(': ', ':', $page);

// Remove whitespace
$page = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $page);


// Enable GZip encoding.
ob_start("ob_gzhandler");

// Enable caching
header('Cache-Control: public'); 

// Expire in one day
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT'); 

//Set Mime
header('Content-type: text/css');


        


        //the following lines MUST always be at the end of the script;
        //loading times
        //echo "/*CSS packed in ".$Performance->getLoadingTime($start_time, getmicrotime())." seconds*/";
        
        

// display page
echo $page;




//get microtime function
        function getmicrotime(){
            list($usec, $sec) = explode(" ",microtime()); return ((float)$usec + (float)$sec);
        }