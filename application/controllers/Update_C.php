<?php

class Update_C{
    /*
     for the moment we don't have a model and the controller does it all
     to create UPDATE extension too
    */
    
    public $success=false;
    public $PotentialTables; //numeric array
    public $uid;
    
    public function __construct($item_main_table,$FieldsAndValues,$uid){
        /*
         Updates an item for DBs Normalized with the CRUDO system
         
         $FieldsAndValues must be an associative array with the field names
         and values.
         
        */

        //get fields
        $Fields=array_keys($FieldsAndValues);
        
        //get UID
        $this->uid=$uid;

        //important to keep it for the order!
        $this->PotentialTables
            =array('_item_generator','_item_metadata',$item_main_table);
        
        
        //find fields parents
        foreach($Fields as $field):
            
            //Get Query Table
            $query_table=self::_getInsertParentTable($field);
            
            if(!in_array($query_table,$this->PotentialTables))
                die(__CLASS__.__FUNCTION__.'(): Field:'.$field.' is not part of '.$item_main_table.'!');

            /* * * * * * * * * * * * * * * * *
             *                               *
             *       POPULATE FIELDS         *
             *      WITH VALUES AGAIN        *
             *                               *
             * * * * * * * * * * * * * * * * */

            $FieldsByTable[$query_table][$field]=$FieldsAndValues[$field];
        
        
        endforeach;
        
        /* * * * * * * * * * * * * * *
         *                           *
         *       CREATE              *
         *       QUERY PIECES        *
         *                           *
         * * * * * * * * * * * * * * */
        //create each string of format fieldname=value
        foreach($FieldsByTable as $table_name=>$FieldAndValue)
        
            foreach($FieldAndValue as $field=>$value)
                $QueryPiecesByTable[$table_name][]
                =
                $field.'='.$value;

        /* * * * * * * * * * * * * * * * *
         *                               *
         *         COMPOSE AND           *
         *     EXECUTE REAL QUERIES      *
         *                               *
         * * * * * * * * * * * * * * * * */

        //check if there's UID
        if($this->uid):
        
            foreach($QueryPiecesByTable as $table_name=>$QueryPieces):
    
                $sql='
                    UPDATE '.$table_name.'
                    SET '.implode(',',$QueryPieces).'
                    WHERE '.EasyQuery::getPrimaryKey($table_name).'="'.$this->uid.'"';
                
                $update=EasyQuery::update($sql);
                $this->success=$update;
                
                if($update<0): //if no success I delete all previous
                
                    echo 'HEEEYY WE GOT A PROB! 3';
                
                    return false;
                endif;
            
            endforeach;
        
        else:
            
            Notify::developer('Class '.__CLASS__.'() there\'s no UID specified!');
            $this->success=false;
            
        
        endif;
        
        //if($this->success<1)
        //    Notify::developer($sql);
        
        
    }
    
    
    
    
    
    
    
        private function _getInsertParentTable($field_name){
    
    	$Tables=EasyQuery::getDbStructure();
        
        foreach($this->PotentialTables as $table_name)
            $FormTablesInfo[$table_name]=$Tables[$table_name];
    	
    	foreach($FormTablesInfo as $table_name=>$Fields)
            if(in_array($field_name,array_keys($Fields)))
                return $table_name;
    
    
    }
    
    
}