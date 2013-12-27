<?php
/*
This class connects to the DB in MySqli Mode. It's only possible to start the connection within the class.
Every connection will be triggered by the Query function ( public ) which opens connection, parse a query and frees the DB results.
*/

class DbConnect{
    
    public $ErrorMessages;
    

    static function _DbConnect(){
        
        //db connection in MySqli mode
        $mysqli =  @new mysqli  ( DB_HOST ,   DB_USER ,  DB_PASSWORD ,  DB   );

        //if connection goes wrong I return false
        if  ($mysqli->connect_error) :
             die('<br/>ERROR:'.$mysqli->connect_error.'<br/>ERROR# '.$mysqli->connect_errno);
            return false;
        endif;
        
        //return connection object
        return $mysqli;
    }
    
    
    
    

}

