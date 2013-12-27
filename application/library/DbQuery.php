<?php



class DbQuery extends DbConnect{
     
      //this function returns a numeric array
    //each key of the array contains and associative array ( table row )
    
    static function query($sql,$err_message="Impossibile eseguire la query"){
        
      //open DB connection
      $mysqli  =   self::_DbConnect();
      
      //if there's no connection I return false
      if(!$mysqli): return false; endif;
      
      
      //capture query result into an object through Mysqli
      $result =   $mysqli->query($sql);
      
      
      //if there's an error pass error message to the view and return false
      if ($mysqli->error):
          die(
                  'ERROR:'.$mysqli->error.PHP_EOL.'ERROR# '.$mysqli->errno.PHP_EOL.'SQL:'.$sql
                  );
          return false;
      endif;
       
      //close connection
      mysqli_close($mysqli);
      
      if(isset($result) && is_object($result)){
      
      //if the object is empty I return false
      if (!$result || !$result->num_rows) return false;
      
      
      //generate $data array so that every Sql operation end here.
      //To better separate the DAO.
      //Every result oustide of this class will be managed as an array.
      while ($row=$result->fetch_assoc()):
      
          $Data[] =   $row;
      
      endwhile;
      
      }
      
      if(isset($Data))
        return $Data;
         
         
         
    }
    
    
    
    
    static function delete($sql, $err_message='Impossibile cancellare'){
      
      //open DB connection
      $mysqli  =   self::_DbConnect();
      
      //if there's no connection I return false
      if(!$mysqli): return false; endif;
      
      //execute query
      $result = $mysqli->query($sql);
      
      //grab number of deleted rows
      $deleted_rows=$mysqli->affected_rows;
      
      //close connection
      mysqli_close($mysqli);
      
      return $deleted_rows;
      
    }
    
    static function insert($sql,$err_message="Impossibile inserire dati"){
      /*
       the function returns TRUE or the LAST_INSERT_ID
      */
      
      
      //open DB connection
      $mysqli  =   self::_DbConnect();
      
      //if there's no connection I return false
      if(!$mysqli): return false; endif;
      
      //execute query
      $result = $mysqli->query($sql);


      //if there's any warning I return false
      if($mysqli->warning_count):
      $warnings=mysqli_get_warnings($mysqli);
         Notify::developer($warnings->message);
         
         //close connection
         mysqli_close($mysqli);
         return false;
      endif;
      
      if($mysqli->insert_id):
      
         $insert_id=$mysqli->insert_id;
         
         //close connection
         mysqli_close($mysqli);
         
         return $insert_id;
      
      endif;
      
     // echo 'affected rows '.$mysqli->affected_rows.$mysqli->error.$sql;;
      return true;
      
    }
    
    static function update($sql, $err_message='Impossibile aggiornare'){
      
      //open DB connection
      $mysqli  =   self::_DbConnect();
      
      //if there's no connection I return false
      if(!$mysqli): return false; endif;
      
      //execute query
      $result = $mysqli->query($sql);
      
      $affected_rows=$mysqli->affected_rows;
      //echo ($mysqli->error||$affected_rows<1)?$mysqli->error.PHP_EOL.'<br>'.$sql:'';
      //close connection
      mysqli_close($mysqli);
      
      return $affected_rows;
      
    }
}