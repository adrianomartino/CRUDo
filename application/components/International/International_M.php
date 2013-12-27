<?php

class International_M{
    
    public $Translations;
    
    public function __construct(){
        //load international translations
        $this->Translations=parse_ini_file( "definitions.php", true );
        
    }