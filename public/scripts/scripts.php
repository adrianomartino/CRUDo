<?php

require('../../application/bootstrap.php');

$jsFiles=EasyFile::filesInDirectory(__DIR__,'.js');

$buffer = "";
foreach ($jsFiles as $jsFile) {
  $buffer .= file_get_contents($jsFile);
}

// Enable GZip encoding.
ob_start("ob_gzhandler");

// Enable caching
header('Cache-Control: public'); 

// Expire in one day
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT'); 

// Set the correct MIME type, because Apache won't set it for us
header('Content-type: text/javascript');

// Write everything out
echo $buffer; 