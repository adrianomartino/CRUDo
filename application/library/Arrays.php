<?php

class Arrays{
    
    
    
    
    static function arrayShiftLevel($Array){
        /*
         Eliminate useless level from a multidimensional array
         when every value of the array  it's represented by an array
         with a single key and a numeric index or non significant associative index
         for instance the array returned by the MySql query SHOW_TABLES
         which has the structure $Array[0][tables_in_dbname]='table_name'
         transforming it in $Array[0]='table_name'
        */
        
        foreach($Array as $SubArray):
        
            foreach($SubArray as $value):
            
                $ShiftedArray[]=$value;
            
            endforeach;
        
        endforeach;
        
        return $ShiftedArray;
        
    }
    
    static function arrayToDbTable($Array,$destination_table){
        /*this function takes a numeric array  containing associative Arrays and transfers
        all the key=>values to $destination_table where field_name corresponds to
        key and its value corresponds to value.
        
        Dependency: Crudo system for table structure check
        */
        $count=0;//scaffold
        
        //check if it's array
        if(!is_array($Array)):
            Notify::developer(__FUNCTION__.': needs an array');
            return false;
        endif;
        
      //  check if main array is numeric
        //if(self::isAssoc($Array)):
        //    Notify::developer(__FUNCTION__.': the array provided is not a numeric array');
        //    //print_r($Array);
        //    return false;
        //endif;
        
        
        //check if the sub array structure is associative
        if(!self::isAssoc($Array[0])):
            Notify::developer(__FUNCTION__.': the sub arrays are not associative');
            return false;
        endif;
        
        
        //check if destination table has same key names
        $ArrayFields=array_keys($Array[0]);
        $TableFields=SuperQueryTools::getFieldNames($destination_table);
        $FieldsThatAreNotInTables=self::getNonMatchingValues($ArrayFields,$TableFields);
        
        if(!empty($FieldsThatAreNotInTables)):
            Notify::developer(__FUNCTION__.': the array is not compatible to the destination table because it has some field names that are not present in the table');
            return false;
        endif;
        
        
        //make query to put array in table
        foreach($Array as $Row):
            //print_r($Row);
            foreach($Row as $field_name=>$field_value):
                
                if($field_name!='parent')
                    $Set[]=$field_name.'="'.addslashes($field_value).'"';
                
            endforeach;
        
            
            $sets=implode(',',$Set);
            unset($Set);
            
            
        //    echo $sets;
            $sql='REPLACE INTO '.$destination_table.' SET '.$sets;
                    
                    //echo $sql;
                    
                    
                    if(
                       EasyQuery::query($sql)
                      )
                     $count++;
                     
                     
            //update parents in _item_generator
            if(isset($Row['parent'])):
                EasyQuery::query('UPDATE _item_generator SET parent='.$Row['parent'].' WHERE universal_id='.$Row['universal_id']);
              //   print_r($Row);
            endif;
            
            
        endforeach;
        
        return $count;

    }
    
    
    
    
    static function arrayTrim($Array){
        /*
         Trims all elements in an array
        */
        return array_map('trim',$Array);
        
    }
    
    
    
    static function arrayValueMatch($values_to_match,$Array){
        
        $ValuesToMatch=explode('|',$values_to_match);
        
        foreach($ValuesToMatch as $value)
            if(self::inArray_i($value,$Array))
                return $value; //it returns the value itself
            
        return false;
    }
    
    
    static function ditchFirstNumericLevel($Array){
        /*Eliminate the redundant numeric array that includes other arrays
        tipically created by array push.
        It's meant to be for numeric arrays*/
        
        foreach($Array as $useless_key=>$Values)
            foreach($Values as $key=>$SubValues)
                $NewArray[]=$SubValues;

        return $NewArray;
    }
    
    
    static function getNonMatchingValues($Array1,$Array2,$strict=true){
        /*returns only the values that are in Array1 and are not present in Array2*/
        $Diff=array();//scaffold
        
        foreach($Array1 as $value)
            if(!in_array($value,$Array2,$strict))
                $Diff[]=$value;
        
        return $Diff;
    }
    
    static function inArray_i($needle,$Array){
        /*finds a correspondent string in array in a case insensitive manner */
        return (in_array(strtolower($needle),array_map('strtolower',$Array)));
    }
    
    
    static function isAssoc($Array){
        /*checks if an array is associative*/
        $Keys=array_keys($Array);
        $Truth=array_map('is_numeric',$Array);
        
        return (in_array(false,$Truth));
    }
    
    static function listToArray($list,$delimitator=','){
        /*
         it does explode + trims everyfield
        */
        $Array=explode($delimitator,$list);
        $Array=array_map('trim',$Array);
    }
    
    
    
    static function lowerCase($Array){
        return array_map('strtolower',$Array);
    }
    
    
    
    static function multiToMono($Array){
        
        /*
        Transforms a 2 level associative array to a 1 level arrat
        putting all the sub keys and avlues at the first level and renaming
        them with a prefix plus underscore. The prefix is the name of the var holding the
        subarray.
        */
        
        foreach($Array as $key_name=>$Values)
            if(is_array($Values)):
            
                foreach($Values as $value_name=>$value)
                    $Array[$key_name.'_'.$value_name]=$value;
                
                unset($Array[$key_name]);
                
            endif;

        return $Array;
        
        
    }
    
    
    
    
    static function numArrayDitchLast($Array){
        /*
         ditch the last value of an array
        */
        unset($Array[sizeof($Array)-1]);
        
        return $Array;
        
    }
    
    
    static function getFirstValue($Array){
        /*
         returns a string with the last value of the array
         */
        
        return $Array[0];
        
    }
    
    static function getLastValue($Array){
        /*
         returns a string with the last value of the array
         */
        
        return $Array[count($Array)-1];
        
    }
    
    
    static function numeric2assoc($Array,$name_var1,$name_var2){
        /*
         Generate an associative array from a numeric array whose sub arrays are
         composed by only two values, making the first value the key and the second the value
         
         transforms this:
         
          Array
                (
                    [0] => Array
                        (
                            [$name_var1] => 0000001
                            [$name_var2] => name_of_thing
                        )
                        
        in this:
        
        Array(
            '0000001'=>'name_of_thing'
        )
                 
        */

        foreach($Array as $array_n=>$SubArray)
            $newArray[$SubArray[$name_var1]]=$SubArray[$name_var2];
            
        return $newArray;
        
    }
    
    
    
    static function reGroupSubArrays($Array){
        /*
         The need is born from multiple files upload arrays
         
         The function transforms arrays like this
         
        $Array[name][0] => 'temp.sql'
        $Array[name][1] => 'temp2.sql'
        
        $Array[type][0] => 'application/octet-stream'
        $Array[type][1] => 'text/plain'
        



into arrays like this:

        $Array[0][name] => 'temp.sql'
        $Array[0][type] => 'application/octet-stream'
        
        
        $Array[1][name] => 'temp2.sql'
        $Array[1][type] => 'text/plain'


        */

        

            foreach($Array as $property_name=>$PropertiesValues)
                foreach ($PropertiesValues as $n=>$value)
                    $NewArray[$n][$property_name]=$value;
                
            return $NewArray;

        
        
    }
    
    
    static function removeAssocEmptyValues($array){
        /*
         removes all the empty values of a numeric array
        and returns a new array with the keys rearranged without leaving holes
        */
        
        $newArray=array();
        $i=0;
        
        
        foreach($array as $key=>$value):
        
            if(trim($value)):
                $newArray[$key]=$value;
                $i++;
            endif;
            
        endforeach;
        
        return $newArray;
        
    }
    
    
    
    
    static function removeEmptyValues($array){
        /*
         removes all the empty values of a numeric array
        and returns a new array with the keys rearranged without leaving holes
        */
        
        $newArray=array();
        $i=0;
        
        
        foreach($array as $key=>$value):
        
            if(trim($value)):
                $newArray[]=$value;
                $i++;
            endif;
            
        endforeach;
        
        return $newArray;
        
    }
    
    
    
    static function removeValues($Array,$list,$trim=true){
        /*
         removes all the keys and values where value=string
        */
        $ToRemove=explode(',',$list);
        
        if($trim)
        $ToRemove=array_map('trim',$ToRemove);
        
        
        foreach($Array as $key=>$value)
            if(in_array($value,$ToRemove))
                unset($Array[$key]);
                
        return $Array;
    }
    
    
    
    static function upperCase($Array){
        return array_map('strtoupper',$Array);
    }
    

    
    
}