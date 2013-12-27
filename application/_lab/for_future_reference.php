<?php

/*
  *
  * Here a collection of functions created during the process
  * but are not in use right now
  * They are here to be analyzed and implemented in a standalone "loose" way
  *
  *
*/

  function mysqlUpdateAny($before,$after,$table='*'){
        /*
        Updates with $after
        any field in $table (or in every table in the DB) that is = $before
        */
        $updates_made=0;
        if(!self::tableExists($table) && $table!='*')
            die(__FUNCTION__.'(): Table:"'.$table.'" doesn\'t exist');
            
        if($table=='*'):
        
            $Tables=self::getDbStructure(); //EasyQuery
            
            foreach($Tables as $table_name=>$Field):
            
                foreach($Field as $field_name=>$FieldInfo):
                        
                    $updates_made+=
                        self::update('
                            UPDATE '.$table_name.' SET '.$field_name.'="'.$after.'"
                            WHERE '.$field_name.'="'.$before.'"
                            ');
                
                endforeach;
            
            endforeach;
        
        else:
        
            $Fields=self::getFieldNames($table);
            
            foreach($Fields as $field):

                $updates_made+=
                    self::update('
                        UPDATE '.$table.' SET '.$field.'="'.$after.'"
                        WHERE '.$field.'="'.$before.'"
                        ');
            
            endforeach;
        
        endif;
        
        
        
        return $updates_made;
        
        
    }