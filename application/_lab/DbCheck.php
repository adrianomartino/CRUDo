<?php

/*
 * Crudo Framework Version 2.0
 * copyright © Adriano Martino 2011 (www.adrianomartino.com)
 *
 * Class CheckDb 2.0
 *
*  Check if the structure of the DB is compatible
*  with this framework
 * 
*/

class DbCheck{
    
    
    static function __construct(){
        
        self::checkForCompositePrimaryKeys();
        self::measureFieldsConcurrency();

    }
    
    static function measureFieldsConcurrency(){
        /*
         Returns a developer message if the DB presents
         2 or more fields with the same name, that are not
         strictly related through a Primary -> Foreign Key relationship
         Since MyIsam doesn't support foreign key we will presume
         that the others are foreign. So we will only send developer message
         only if we find 2 or more primary keys with the same fieldname
        */
        
        $Tables=EasyQuery::$DbStructure;
    
        foreach($Tables as $Table):
        
            $Fields=array_keys($Table);
            
            foreach($Fields as $field_name):
                
                if(in_array($field_name, $FieldNames))
                die($field_name.' is present in more than one table!');
                $FieldNames[]=$field_name;
            
            endforeach;
        
        endforeach;
    
    
    }
    
    
    static function checkPrimaryKeys(){
        /*
         Generates Developer level messages to warn about
         the presence of composite primary keys or the absence
         of primary keys in he selected DB which
         are not within the DB structure guidelines
        */
        
        $Tables=$this->EasyQuery->showTables();
        
        foreach($Tables as $table_name):
            
            $number_of_primary_keys=count($this->EasyQuery->getPrimaryKey($table_name));
            
            //if there's more than 1 primary key I display developer warning
            if( $number_of_primary_keys > 1):
            
                $this->NotificationManager->developerMonitor(
                       ' Warning: Table '.$table_name.' has a composite primary key
                       which is not within the DB guidelines of this system and may
                       affect it\'s stability and integrity
                    ');
            
            endif;
            
            //if there's no primary key I display developer warning
            if( $number_of_primary_keys = 0):
            
                $this->NotificationManager->developerMonitor(
                       ' Warning: Table '.$table_name.' doesn\'t have a primary key!
                    ');
            
            endif;
        
        endforeach;
        
        
        
    }

    
    
}
