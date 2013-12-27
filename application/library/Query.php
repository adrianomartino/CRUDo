<?php

class Query{

    public $affected_rows   =   0;
    public $Data            =   array();
    public $errors          =   NULL;
    public $insert_id       =   NULL;
    public $num_rows        =   0;
    public $warnings        =   0;

    
    
    //this function returns a numeric array
    //each key of the array contains and associative array ( table row )
    
    public function __construct($sql,$err_message="Impossibile eseguire la query"){
        
        //open DB connection
        $mysqli  =   $this->_DbConnect();
        
        //if there's no connection I return false
        if(!$mysqli) return false;
        
        
        //capture query result into an object through Mysqli
        $result =   $mysqli->query($sql);
        
        
        
        
        
        //if there's any warning I return false
        if($mysqli->warning_count):
            $warnings=mysqli_get_warnings($mysqli);
            Notify::developer($warnings->message);
        endif;
        
        
        
        
        
        //if there's an error pass error message to the view and return false
        if ($mysqli->error || $mysqli->affected_rows < 0):
            //pass the error message
            $this->errors=
            'ERROR:'.$mysqli->error.PHP_EOL.
            'ERROR# '.$mysqli->errno.PHP_EOL.
            'SQL:'.$sql;
            
            //pass message to developer
            Notify::developer($this->errors);
            
            //close connection
            mysqli_close($mysqli);
            
            //end
            return false;
        endif;
        
        
        //record affected rows
        if(isset($mysqli->affected_rows))
            $this->affected_rows=$mysqli->affected_rows;
            
            
            
            
        //if it's an insert I save insert id
        if(isset($mysqli->insert_id))
            $this->insert_id=$mysqli->insert_id;
        
        
         
        //close connection
        mysqli_close($mysqli);
        
        
        //if the object is empty I return false
        if (!$result || !$result->num_rows):
            $this->Data=NULL;
            return false;
        endif;
        
        
        //generate $data array so that every Sql operation end here.
        //To better separate the DAO.
        //Every result oustide of this class will be managed as an array.
        while ($Row=$result->fetch_assoc())
            $this->Data[] =   $Row;
        
         
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    private function _DbConnect(){
        
        //db connection in MySqli mode
        $mysqli =  @new mysqli  ( DB_HOST ,   DB_USER ,  DB_PASSWORD ,  DB   );

        //if connection goes wrong I return false
        if  ($mysqli->connect_error) :
             $this->errors='<br/>ERROR:'.$mysqli->connect_error.'<br/>ERROR# '.$mysqli->connect_errno;
            return false;
        endif;
        
        //return connection object
        return $mysqli;
    
    }
    
    
    
    
    
    
}








    