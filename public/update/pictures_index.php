<?php

require_once('/Applications/XAMPP/xamppfiles/htdocs/MenuVeraBologna/application/bootstrap.php');


$Items=EasyQuery::query("SELECT * FROM _item_metadata");
print_r($Items);

foreach($Items as $ItemInfo){
    $file='/Applications/XAMPP/xamppfiles/htdocs/MenuVeraBologna/public/files/'.EasyFile::getBaseName($ItemInfo,'120').'.jpg';
    
    echo $file;
    
    (file_exists($file)) ? $sql_set = "foto='1'" : $sql_set = "foto='0'";
    
    $sql="UPDATE _item_metadata  SET ".$sql_set." WHERE universal_id=".$ItemInfo['universal_id']."";
    
    EasyQuery::query($sql);
    
   // echo $sql.'<br/>';
    
    
    $Items=EasyQuery::query('SELECT * FROM _item_metadata WHERE universal_id=19');
    
    print_r($Items);

}