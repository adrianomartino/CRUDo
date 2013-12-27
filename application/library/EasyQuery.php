<?php


/*
 * Crudo Framework Version 2.0
 * copyright © Adriano Martino 2011 (www.adrianomartino.com)
 * Class EasyQuery 2.0
 * Description:
 * The class manage all the connections to the DB.
 * Every query on the website will pass by the
 * query function of the parent class Connect.
 * The present class contains shortcuts for the most used general queries.
 * 
*/



class EasyQuery extends DbQuery{
    
    static $DbStructure;
    

    
    function __construct(){
        
        if(!self::$DbStructure):
            require_once('_DbStructure.php');
            self::$DbStructure=$DbStructure;
        endif;
        
    }

    
 

    
    

    
    
    
    
    
    
    

    

    



    
    
    

    

    

       
    
    
    
    
   
    
    
    
    
    
    static function fieldExists($field_name){
        
        $Tables=self::getDbStructure();
        
        foreach($Tables as $table)
            if(array_key_exists($field_name,$table))
                return true;
        
    }
    
    static function fieldIsInTable($field_name, $table_name){
        
        /*
         returns true if $field_name is in $table_name
        */
   
       $DbTables=self::getDbStructure();
       $Table=$DbTables[$table_name];
       
       return (array_key_exists($field_name,$Table));
   
        
    }
    
    static function getDbTables(){
        /*
         returns a numeric array with the current DB table names
        */
        
        //get numeric array with associative arrays in rows
        $Data=self::query('SHOW TABLES');
        
        //if there's no array I end up here
        if(!$Data) return false;
        
        //convert the sub associative arrays ( only 1 key )
        //in parent array string values
        $Tables=array();
        foreach($Data as $SubArray)
            foreach($SubArray as $value)
                $Tables[]=$value;
        
        return $Tables;
        
    }
    
    
    
    static function getDbStructure(){
        /*
        this function returns a multidimensional array
        with the selected-db structure
        */
        if(self::$DbStructure) return self::$DbStructure;
        
        //create scaffold arrays
        $DbStructure=array();
        $TableFields=array();
        
        //get table names
        $Tables=self::getDbTables();   
        
        
        //populate multidimensional array with DB structure
        foreach($Tables as $table_name)
            $DbStructure[$table_name]=self::getTableFields($table_name);
        
        return $DbStructure;
        
    }
    
    static function getFieldsInfo($list_of_fields){
    /*
     Takes a list of fields names as a string
     [field1 field2 field3]
     or a numeric array with string values representing
     field names.
     and returns an associative array with all the db fields
     information
    */
    
    if(!trim($list_of_fields))
        return false;

    
    //if $list_of_fields is not an Array I make one
    (!is_array($list_of_fields)) ? $Fields=explode(',',$list_of_fields) :
    
    //otherwise I keep the array
    $Fields=$list_of_fields;
    
    if(!is_array($Fields)): die(__FUNCTION__.' list of fields is not correct!');
    endif;
    
    //create scaffold array
    $FieldsInfo=array();
    
    //for each field I retrieve the info from the DB Structure super array
    foreach ($Fields as $field_name ):
        
        //retrieve the parent table name
        $Table=self::getParentTable($field_name);
        
        $DbStructure=self::getDbStructure();
        
        //if the field exists
        if(isset($DbStructure[$Table][$field_name]))
                $FieldsInfo[$field_name]=$DbStructure[$Table][$field_name] ;
        else
            die("function <b>".__FUNCTION__."()</b> the field $field_name doesn't exist! check if your list is correct".PHP_EOL);
        
    endforeach;
    
    
    return $FieldsInfo;
    
}

    static function getFieldNames($table_name){
        
        //get numeric array with table field info through mysql embedded function
        //return self::query('SHOW FULL FIELDS FROM '.$table_name); //live alternative from db (slower)
        
        $Tables=self::getDbStructure();
        
        $TableInfo=$Tables[$table_name];
        
        return array_keys($TableInfo);
        
    }
    


    static function getParentTable($field_name){
        /*
         returns the name of the first parent table found for
         $field_name
        */
        $field_name=trim($field_name);
        $DbTables=self::getDbStructure();
   
       foreach($DbTables as $table_name=>$TableData)
            if(array_key_exists($field_name,$TableData))
                $PotentialRealParents[] = $table_name;
        
        
        //if I found nothing I return false
        if(!isset($PotentialRealParents))
            return false;
        
        //if it's just one I return the table
        if(count($PotentialRealParents)<2)
            return $PotentialRealParents[0];
            
        //if it's more than one I do a DNA test for the real father :-P    
        if(count($PotentialRealParents)>1)
            foreach($PotentialRealParents as $PotentialParent)
                if (self::getPrimaryKey($PotentialParent)==$field_name)
                    return $PotentialParent;
                
        die('Unable to get the parent table for '.$field_name.'!');

    }   
   
 
    static function getPrimaryKey($table_name){
        
        if(!trim($table_name)) die(__FUNCTION__.'(): Hey, you have specified no table!');
        
        $PrimaryKeyInfo=self::query('SHOW INDEX FROM '.$table_name.' WHERE Key_name=\'PRIMARY\'');
            if(!isset($PrimaryKeyInfo[0]['Column_name']))
                die(__FUNCTION__.':() unable to find primary key name for table'.$table_name);
                
        return $PrimaryKeyInfo[0]['Column_name'];
        
    }
    
    



    static function getTableFields($table_name){
        /*
         returns a multidimensional associative array with
        the names of fields and attributes for a selected table
        */
        
        //create master scaffold array
        $TableFields=array();
        
        //get numeric array with table field info through mysql embedded function
        $Data=self::query('SHOW FULL FIELDS FROM '.$table_name);
        
        //rearrange info in new associative array
        foreach ($Data as $FieldInfo):
        
            //establish the field name for associative array
            $FieldName=$FieldInfo['Field'];
            
            //create new scaffold array
            $TableFields[$FieldName]=array();
            
            //assign to the new associative key
            //named with the table name
            //value containing array with field properties
            foreach ($FieldInfo as $key=>$value):
            
                if($key!='Field'):
                    $TableFields[$FieldName][$key]=$value;
                endif;
        
            endforeach;
        
        endforeach;
        
        return $TableFields;
    }
    
    
    
    
    
    
    static function isTablePrimaryKey($field_name,$table_name){
        
        return (self::getPrimaryKey($table_name)==$field_name);
        
    }
    
    static function selectOneRow($sql){
        /*returns one row of results*/
        $Data=EasyQuery::query($sql);
        
        return $Data[0];

    }
    static function selectOneValue($sql){
        /*returns a string with the value*/
        $Data=EasyQuery($sql);
        
        $Value=$Data[0];
        
        foreach($Value as $key => $value)
            return $value;
    }
    
    static function showTables(){
        /*
         returns a numeric array with the table names
        */
        
        //Get normal db result
        $Tables=self::query('SHOW TABLES');
        
        //eliminate useless keys [Tables_in_dbname]
        //Only to be used if the selected DB is ONE!
        return Tools::arrayShiftLevel($Tables);
        
    }
    
    
    static function tableExists($table_name){
        /*
         determines whether a table exists in the DB
        */
        
        //make sure that the table name doesn't have unwanted spaces
        $table_name=trim($table_name);

        //if the table name corresponds to a key of the super array $DbStructure is a table
        return (in_array($table_name,self::getDbTables()));

    
    }
    
    
    static function valueExists($value,$tables_list,$field){
        
        $TablesToAnalize=Arrays::listToArray($tables_list);
        
        foreach($TablesToAnalize as $table)
            if(
               self::query('
                SELECT '.$field.' FROM '.$table.' WHERE '.$field.'="'.$value.'"
                ')
            );
            
            return true;
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //------- Not in use but useful-----//
    
    
    
    
    static function updateAnyItemField($before,$after,$item_main_table){
        /*
        Updates with $after
        any field in the item tables that is = $before
        */
        
        $updates_made=0;
        $ItemTables=array('_item_generator','_item_metadata',$item_main_table);
        
        
        foreach($ItemTables as $table):
        
            $updates_made+=self::mysqlUpdateAny($before,$after,$table);
        
        endforeach;
        
        return $updates_made;
        
    }
    
    
    

    
    static function isForeignItemKey($field_name, $table_name){
    /*
    returns true if $field_name has a unique parent table in the DB
    */

        //meat
        $parent_table=self::getParentTable($field_name);
        
        //If is not a SiteItem Key I return false
        if (!self::isItemKey($field_name))
            return false;
        
        //if its the primary key of to the current table I return false
        if($parent_table==$table_name)
            return false;
        
        //if it's not present in this table I return false
        return (self::fieldIsInTable($field_name, $table_name));

    }
    

    
    
    static function isItemKey($field_name){
        
        return (in_array($field_name,self::getItemsKeys()));
        
    }
    






    
  
    
}