<?php



class Item_M{
    
    //those vars are passed by the Item Controller
    public $item_parent;
    public $item_primary_key; //the only one calculated here
    public $item_main_table;
    public $context;
    public $distinct;
    public $uid;
    public $where;
    public $limit;
    public $order_by;
    public $allow;
    public $creator_id;
    public $list_sons; //List or Item
    

    public function __construct($uid){
        
             /*
             Check if item main table exists otherwise i set it with the default _item_long_desc
            */
             
             $this->uid=$uid;
             
             
             //MAKE FUNCTIONS FOR HIERARCHIES AND ITEM MAIN TOPIC
            
            $ItemMainTopic=CrudoQuery::getItemMainTopic($this->uid);
            $assumed_table_name=$ItemMainTopic['item_url'];
            
            $this->item_main_table=(CrudoQuery::getTableFromTopic($assumed_table_name));
            
           
           
            ### TO FIX
            //if item URL or item ID is specified get Item parent
            
            //PUT item url in variables instead that in where
        
        
        $this->item_primary_key=EasyQuery::getPrimaryKey($this->item_main_table);
        
    }
    
    
    
    
    
    
    
    
    
    
    
    //only in specific items
    public function selectPublicPage(){
        
        $sql=$this->composeSelect('all_fields');
        //echo $sql.PHP_EOL.PHP_EOL;
        return EasyQuery::query($sql);
        
    }
    
    
    public function selectAdminPage(){
        
        $sql=$this->composeSelect('all_fields');
        //echo $sql.PHP_EOL.PHP_EOL;
        return EasyQuery::query($sql);
        
    }

    public function selectPublicSnippets(){
    
        $sql=$this->composeSelect('universal_id,item_url,foto,name_or_title,item_snippet,item_lang,parent');
        //echo $sql.PHP_EOL.PHP_EOL;
        return EasyQuery::query($sql);
    
    }




    public function selectAdminSnippets(){
        
        $sql=
        $this->composeSelect('universal_id,item_url,name_or_title,item_lang,item_snippet,item_lang,parent');
        //echo $sql;
        return EasyQuery::query($sql);
    }






    public function selectPublicLinks(){
        
        $sql=$this->composeSelect('universal_id,item_url,name_or_title,item_lang,parent');
        //echo $sql.PHP_EOL.PHP_EOL;
        return EasyQuery::query($sql);
        
    }



    public function selectAdminLinks(){
        
        $sql=
        $this->composeSelect(
            'universal_id,item_url,name_or_title,item_lang,parent'
            );
        //echo $sql.PHP_EOL.PHP_EOL;
        return EasyQuery::query($sql);
        

    }


    public function customSelect($fields){
        
        $sql=$this->composeSelect($fields);
        //echo $sql.PHP_EOL.PHP_EOL;
        return EasyQuery::query($sql);
        
    }
    
    public function selectFormSelect(){
        
        $sql=
        $this->composeSelect(
            'universal_id,name_or_title'
            );
        //echo $sql;
        return EasyQuery::query($sql);
        
    }
    
    
    
    public function allFields(){
        
        /*
         returns the list of all the fields of an item
         so that SQL queries can be faster without  using the symbol "*"
        */
        
        $Tables=EasyQuery::$DbStructure;
        $ItemTables=array('_item_metadata','_item_generator',$this->item_main_table);
        
        foreach($ItemTables as $table):
        
            $FieldNames=EasyQuery::getFieldNames($table);
            
            foreach($FieldNames as $field_name)
                $AllFields[]=$field_name;
        
        endforeach;
        
        return implode(',',$AllFields);
        
    }
    
    

    
    public function composeSelect($list){
        //print_r(get_class_vars(__CLASS__));
        //if($this->show) echo 'yeah'; exit;
        //filtering the selection based on the permissions
        switch($this->show):
        
            case 'ALL':
                if($this->context=='Public')
                $item_filter='item_status!="draft" AND item_status!="recycle bin"';
            break;
        
            case 'HIS_ITEMS':
                ($this->context=='Public') ?
                $item_filter='item_status="public" OR creator_id="'.$this->creator_id.'"':
                $item_filter='creator_id="'.$this->creator_id.'"';        
            break;
        
            case 'PUBLIC_ONLY':
                if ($this->context=='Admin') return false; 
                $item_filter='item_status="public"';
            break;

        endswitch;
        

        //set limit
        $limit = ($this->limit) ? 'LIMIT '.$this->limit : '';
        
        //set order by
        $order_by = ($this->order_by) ? 'ORDER BY '.$this->order_by : '';
        
        
        
        ### CHECK EVERYWHERE WHERE OLD ITEM MAIN TOPIC IS INPUTTED
        
        
        
        
        
        if($this->where):
            $where='WHERE '.$this->where;
            $wh_liason=' AND';
        else:
            $wh_liason='WHERE';
            $where='';
        endif;
        
        $wh_liason=($where)?' AND':'WHERE';
        
        //set where
        if(isset($item_filter)): $where.=$wh_liason.' ('.$item_filter.')'; endif;
        
        
        
        //LIST THE SONS OF THIS ITEM OR THE ITEM ITSELF BASED ON THE OPTION GIVEN BY ITEM_C
        $wh_liason=($where)?' AND':'WHERE';
        
        if ($this->list_sons)
            $where.=$wh_liason.' _item_generator.parent="'.$this->uid.'"';   
        else
            $where.=$wh_liason.' _item_generator.universal_id="'.$this->uid.'"';

               
        //populate list of columns to select
        $list=($list=='all_fields') ? self::allFields() : $list;
        
        /*
         define cross join or natural join accordingly if item
         has special table or not
        */
        $join=($this->item_main_table=='_item_long_desc') ? 'NATURAL JOIN _item_long_desc' : 'CROSS JOIN '.$this->item_main_table.' ON '.$this->item_main_table.'.'.$this->item_primary_key.'= _item_generator.universal_id';
        
        
        $sql='
            SELECT '.$list.'
            FROM _item_metadata
            NATURAL JOIN _item_generator
            '.$join.'
            '.$where.'
            '.$order_by.'
            '.$limit
            ;
            
      //     echo $sql;
        return $sql;
            
        
    }
    
}
