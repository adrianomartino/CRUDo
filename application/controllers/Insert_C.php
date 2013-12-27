<?php

class Insert_C{
    /*
     for the moment we don't have a model and the controller does it all
     to create UPDATE extension too
    */
    
    public $success;
    public $item_id;
    public $TablesToBeProcessed; //numeric array
    public $InvolvedTables; //array with info
    
    public function __construct($item_main_table,$FieldsAndValues){
        /*
         Generate a new item for DBs Normalized with the CRUDO system
         
         $FieldsAndValues must be an associative array with the field names
         and values.
         
         NOTE! IF YOU TRY TO SPECIFY AN ID FOR THE RESOURCE THIS ONE WILL NOT BE
         TAKEN AND THE QUERY WILL NOT BE SUBMITTED!
         
        */
        
        

        //get fields
        $Fields=array_keys($FieldsAndValues);

        //important to keep it for the order!
        $this->TablesToBeProcessed
            =array('_item_generator','_item_metadata',$item_main_table);
        

        
        //find fields parents
        foreach($Fields as $field):
            
            //Get Query Table
            $query_table=self::_getInsertParentTable($field);

            /* * * * * * * * * * * * * * * * *
             *                                           *
             *       POPULATE FIELDS      *
             *      WITH VALUES AGAIN  *
             *                                             *
             * * * * * * * * * * * * * * * * */

            $FieldsByTable[$query_table][$field]=$FieldsAndValues[$field];
        
        
        endforeach;
        

        /* * * * * * * * * * * * * * *
         *                           *
         *    ESTABLISH EVENTUAL     *
         *      DEFAULT VALUES       *
         *                           *
         * * * * * * * * * * * * * * */
        
        //creation date field
        if(!isset($FieldsByTable['_item_generator']['creation_date'])):
        
            $FieldsByTable['_item_generator']['creation_date']='NOW()';
        
        endif;
        
        
        
        //add other eventual defaults here
        //( Off Course defaults that cannot be defined in MySql)
        

        /* * * * * * * * * * * * * * *
         *                           *
         *       CREATE              *
         *       QUERY PIECES        *
         *                           *
         * * * * * * * * * * * * * * */
        //create each string of format fieldname=value
        foreach($FieldsByTable as $table_name=>$FieldAndValue):
        
            foreach($FieldAndValue as $field=>$value):
                $QueryPiecesByTable[$table_name][]
                =
                $field.'='.$value;
            endforeach;
        
        endforeach;

        /* * * * * * * * * * * * * * * * *
         *                               *
         *         COMPOSE AND           *
         *     EXECUTE REAL QUERIES      *
         *                               *
         * * * * * * * * * * * * * * * * */
        $id_set=false;//scaffold
        
        foreach($this->TablesToBeProcessed as $table_name):

            //if the previous loop ( the first ) defined an Item Id item I insert it in the next query
            if(isset($this->item_id) && $this->item_id>0):
            
                $QueryPiecesByTable[$table_name][]=EasyQuery::getPrimaryKey($table_name).'="'.$this->item_id.'"';
            
            endif;
            


            $sql='
                INSERT INTO '.$table_name.'
                SET '.implode(',',$QueryPiecesByTable[$table_name]);
            
            //echo $sql;
            
            
            $insert=EasyQuery::insert($sql);
            
            
            if($insert>0 && $insert!==true) //if the query returned the last insert id ( See DbQuery::Insert for documentation )
                if(!isset($this->item_id))
                    $this->item_id=$insert;

            
            if(!$insert): //if no success I delete all previous
            
                echo 'HEEEYY WE GOT A PROB!'.$sql;
                if(isset($this->item_id)):
                    //add SuperDelete Function to delete every thing already created
                    //EasyQuery::superDelete($this->item_id);
                endif;
            
            endif;
        
        endforeach;
        
        
        $this->success=true;
        
        
    }
    
    
    
    
    
    private function _getInsertParentTable($field_name){
    
    	$Tables=EasyQuery::getDbStructure();
        
        foreach($this->TablesToBeProcessed as $table_name)
            $FormTablesInfo[$table_name]=$Tables[$table_name];
    	
    	foreach($FormTablesInfo as $table_name=>$Fields)
            if(in_array($field_name,array_keys($Fields)))
                return $table_name;
    
    
    }
    

    
    
}