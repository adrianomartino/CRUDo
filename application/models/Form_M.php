<?php

class Form_M{
    
    
    /*
     ### Bugs that need fixing: currently the creation date is always updated with the modified date.
    */
    
    //don't put universal ID as a context value since it cannot be validated at the moment since class validate will consider it wrong to insert since it's a primay/unique key and it already exists.
    public $context_values='item_lang,creator_id,creation_date,last_modify,item_url,parent,pwd_salt';
    public $ContextValues=array();
    public $custom_form_fields; //blank if you want all the fields in the DB
    public $custom_mandatory_fields; //list
    public $DataToInsert; //populated if there is post and if there are changes or it's a new item
    public $Form; //contains the actual form populated with view at the end
    public $FormValuesFromDB; //if the item exists or after insert/update
    public $Fields=array(); //numeric array with field names
    public $FieldsInfo=array(); //multidimensional array with fields name and infos
    public $FieldsToUpdate; //populated automatically
    public $FormTables;
    public $get_fields='translated_from';
    public $legend;
    public $main_table; //table name
    public $mandatory_father=false; //to implement!
    public $RequiredFathers; //populated automatically
    public $primary_key;
    public $submit_value;
    public $success; //true if posted form is valid and has been updated
    public $uid;
    
    
    
    
    
       //---- protected functions ----//
    
    protected function _addPrimaryKeyIfNotInFields(){
        
        //get primary key and add to fields if it's not present
        $this->primary_key=EasyQuery::getPrimaryKey($this->main_table);
        if(!in_array($this->primary_key,array_keys($this->FieldsInfo)))
            $this->FieldsInfo[$this->primary_key]=$this->uid;
        
    }
    
    protected function _formInfoForVH(){
        foreach($this->FieldsInfo as $field_name=>$FieldInfo)
         if($field_name!='universal_id' && $field_name!=$this->primary_key): //ditch universal_ids!
                //capture first so that I can ditch if function returned false
                $FormFieldInfo=$this->_defineFormFieldFromDb($field_name);
                $FormInfo[$field_name]=$FormFieldInfo;
                
                ###when there is custom table with different primary key than Universal_id
                ###make sure that that does not create a conflict.
            
            endif;
        return $FormInfo;
    }
    
    
    
    
    
    protected function _defineContextValues(){
        
        //define context values for fields that are not part of the form
        //item_lang, creator_id, creation_date, item_url
        
        $ValuesToDefine=explode(',',$this->context_values);
        
        foreach($ValuesToDefine as $field_name):
            $context_value=$this->_getContextValue($field_name);
            
            //add to context values array
            if($context_value!==false)
                $this->ContextValues[$field_name]=$context_value;
            
            
            //add to POST important! this is the only way to have the value on new items
            ###NEED FIXING BECAUSE IT CREATES ARRAY POST EVEN WHEN FORM IS NOT POSTED!
             $_POST[$field_name]=$context_value;
        endforeach;  
        
    }
    
    protected function _defineFormFieldFromDb($field_name){
        
        
          
    /*
     Define the properties of a form field
     it's properties in the DB.
     
     It is called by the form controller and the result
     it's passed to the Form View Helper
     
     NOTE: not all field types are currently supported
    */

        
        //create scaffold array
        $Field=array(
        'after_text'         => NULL,
        'mandatory'         => NULL,
        'maxlength'         => NULL,
        'name'              => $field_name,
        'type'              => NULL,
        'PRE_value'         => NULL,
        'SelectOptions'     => array(),
        'use_select_values' => false,
        'value'             => NULL
        );
        
        


        $parent_table=$this->_getFormParentTable($field_name);
        
        
        $FieldInfo=$this->FormTables[$parent_table][$field_name];

        

        //define if field is mandatory
        $Field['mandatory']=$this->_isMandatory($field_name);
        
        
        //add pre value from db
        if (isset($this->FormValuesFromDB[$field_name]) && URL_ACTION!='new')
            $Field['PRE_value']=$this->FormValuesFromDB[$field_name];
            
        //add html entities for rich text area values
        if ($Field['type']=='text')
        	$Field['PRE_value']=htmlentities($Field['PRE_value']);
                
                
        //add post or db value to value
        if(isset($_POST[$field_name]))
            $Field['value']=$_POST[$field_name];
        else
            $Field['value']=$Field['PRE_value'];



        //------------------------------------------------
        //---------Define based on field types------------
        //------------------------------------------------


        //------SPECIAL FUNCTIONS FIRST-----//
		
        //-----context values in edit mode
        if(in_array($field_name,array_keys($this->ContextValues))):
            $Field['type']='hidden';
            //$Field['value']=$this->ContextValues[$field_name];
            
            return $Field;
        
    endif;
                
        
        //take keywords off for the moment
        if($field_name=='item_keywords'):
        return false;
        endif;
        
        ////checkbox with tinyint
        //if($FieldInfo['Type']=='tinyint(1)'):
        //    $Field['type']='checkbox';
        //    return $Field;
        //endif; ###rehabilitate
        
        
        //timestamp
        if($FieldInfo['Type']=='timestamp'):
            $Field['type']='timestamp';
            return $Field;
        endif;
        
        
        //primary key
        if($field_name==$this->primary_key):
            $Field['type']='hidden';
            $Field['value']=$this->uid;
            return $Field;
        endif;
        
        //creator id
        if($field_name=='creator_id'):
            
            //if it's an update I don't give creator id field
            if(PAGE_TOPIC)
                return false;
            
            //else
            $Field['type']='hidden';
            $Field['value']=User_C::$id;
            return $Field;
        endif;
        
        
        
        //item lang
        if($field_name=='item_lang'):
            //if it's specific url don't need this field
            if(PAGE_TOPIC) return false;
            
            $Field['type']='hidden';
            $Field['value']=PAGE_LANG;
            return $Field;
        endif;
        
        
        
        
        //item lang
        if($field_name=='youtube_video'):
            //if it's specific url don't need this field
            
            $Field['type']='input';
            return $Field;
        endif;
        

        
        
        //input or textarea
        if(preg_match("/int|char|varchar|text/",$FieldInfo['Type'],$type)):
            $type=$type[0];
            //echo 'hey'.$field_name.PHP_EOL;
            if( preg_match( '!\(([^\)]+)\)!', $FieldInfo['Type'], $match ) )
                $ml=$Field['maxlength']=$match[1];

                $Field['type']=((isset($ml) && $ml>100)||($type=='text'))?'textarea':'input';
       
                
                
                //add automatic password fields considering encripted password
                //that always takes 40 chars
                if($Field['maxlength']==40 && $type=='char'):
                    $Field['type']='password';
                    $Field['repeat_password']=true;
                endif;
        
        
            //check if instead it should have been a filefield
            $prefix=Strings::getFirstPiece($field_name,'_');
            if( $prefix=='foto' || $prefix=='file' )
                $Field['type']='file';
            
            //create function to pass current thumb url to VH!!!!
            return $Field;
            
        endif;
            
        
            
            
            
           
            
        
        //set and enum
        if(preg_match("/(set|enum)/",$FieldInfo['Type'])):
            //get set values
            if(preg_match( '!\(([^\)]+)\)!', $FieldInfo['Type'], $options ))
                $options=$options[1];
           
                
            //take off first and last quote
            $options=substr($options,1,-1);
            //put values for select into array
            $Field['SelectOptions']=explode("','",$options);
                
            //select if option or multiple select
            $Field['type']= (preg_match("/enum/",$FieldInfo['Type']))?'select':'multipleselect';
            
            
            
            //------SPECIAL FUNCTION FOR PUBLISHING-----//
            
            $remove_pub=false;//scaffold
            
            if($field_name=='item_status'):
            return false; //disabled for the moment
                $Field['SelectOptions']=Arrays::removeValues($Field['SelectOptions'],'edit');
            
                if($this->main_table==USERS_TABLE)
                $Field['SelectOptions']=Arrays::removeValues($Field['SelectOptions'],'draft,public,protected,unlisted,recycle bin');
                else
                $Field['SelectOptions']=Arrays::removeValues($Field['SelectOptions'],'confirmed,not confirmed');
             
                if( User_C::$can_publish == 'HIS_GROUPS' ){
                    //finding out if he can see the current group
                    $current_group=MAIN_TOPIC;
                    $user_groups=User_C::$groups;
                    
                    //if the item is part of the groups the user is allowed to see
                    if(!in_array($current_group,explode(',',$user_groups)))
                        $remove_pub=true;
                }elseif( User_C::$can_publish == 'NONE' ){
                    
                        $remove_pub=true;
                }
                
                if($remove_pub)
                $Field['SelectOptions']=Arrays::removeValues($Field['SelectOptions'],'public');
            
            
                //eventually I add the value if by mistake that field actually had another value
                //since we need to display it anyway
                if(!in_array($Field['PRE_value'],$Field['SelectOptions']))
                    $Field['SelectOptions'][]=$Field['PRE_value'];
            
            endif;
            
            //-------END OF FUNCTION TO LIMITATE PUBLICATION SELECT BASED ON USER!
            
            if(!$Field)
                die('there\'s no function to define '.$field_name.' '.var_dump($FieldInfo));
            
        endif;
        
        
        
        
        
        
        
        
        
            
        //get the locations database and establish ids relationships
        //or put cities in enum fields
        
        
        //when you finish go back to the view helper!
        
    
        return $Field;
        
    }
        
    
    
    
    protected function _defineFields(){
        
        $Fields=array();//scaffold

        //if the form fields have been specified I grab them
        if($this->custom_form_fields)
            $Fields=explode(',',$this->custom_form_fields);
        
        //grab the info for the specified fields or for all the fields
        foreach($this->FormTables as $Table)
            foreach($Table as $field_name=>$FieldInfo)
                if(!$Fields || in_array($field_name,$Fields))
                    $FieldsInfo[$field_name]=$FieldInfo;
            
        $this->Fields=array_keys($FieldsInfo);
        $this->FieldsInfo=$FieldsInfo;

    }
    
    
    
    
    
    
    
    
    
    
    
    protected function _defineFieldsToUpdate(){
        $FieldsToUpdate=array();//scaffold
        
        //text fields
        foreach($this->Fields as $field_name)
            if($this->_fieldUpdateIsRequested($field_name))
                $FieldsToUpdate[]=$field_name;

        //add to count files fields
        $UploadedFiles=$this->_defineUploadedFilesFieldNames();
        
        if(!empty($UploadedFiles))
            foreach($UploadedFiles as $field_name)
                if($this->_fieldUpdateIsRequested($field_name))
                    $FieldsToUpdate[]=$field_name;
        
        
        $this->FieldsToUpdate=$FieldsToUpdate;
       // print_r($this->FieldsToUpdate);
        if($this->FieldsToUpdate) return true; return false;//important

    }
    
    
    
    protected function _defineFormTables(){
        
        $this->FormTables=array('_item_metadata',$this->main_table,'_item_generator');
        new EasyQuery;
        $Tables=EasyQuery::$DbStructure;
        
        foreach($this->FormTables as $table_name):
            $FormTablesInfo[$table_name]=$Tables[$table_name];
        endforeach;

        $this->FormTables=$FormTablesInfo;
        
        unset($FormTablesInfo);
        
    }
    
    protected function _defineFormValuesFromDb(){
    
            //read updated item info to display form

            $FormData_C=new Item_C(
                            CURRENT_UID,
                            'Admin_Page',
                            array(
                            'custom_fields'=>implode(',',$this->Fields),
                            'where'=>'',
                            'limit'=>'0,1',
                            'order_by'=>''
                            )
                            );
            
            
            
            $FormValues=$FormData_C->ItemData;
            unset($FormData_C);
            
            //since the form values are 1 row of result I take the useless first level out
            $this->FormValuesFromDB=$FormValues[0];

    }
    
    
    protected function _defineUploadedFilesFieldNames(){
        /*returns a numeric array with the names of any field
        corresponding to a currently uploaded file as values*/
        if(isset($_FILES) && !empty($_FILES))
            return array_keys($_FILES);
        
    }
    
    protected function _getContextValue($field_name){
         //item_lang, creator_id, creation_date, item_url
         
         //password salt is generated by the db so this function will return false
        
        if($field_name=='item_lang')
            return PAGE_LANG;
        
        if($field_name=='creator_id')
            return User_C::$id;
        
        
        if($field_name=='item_url' and EDIT_MODE=='new' and isset($_POST['name_or_title']))
            return UrlFriendly::getStringAsUrl($_POST['name_or_title']);

            
        if($field_name=='item_url' && EDIT_MODE=='edit'):
            $ItemInfo=CrudoQuery::getItemInfo(CURRENT_UID);
            return $ItemInfo['item_url'];
        endif;
           
        if($field_name=='parent' && EDIT_MODE=='new')
            return CURRENT_UID;

         if($field_name=='parent' && EDIT_MODE=='edit'):
           
           //if there's post I return the parent that it was already
           //since if there was a rename the page topic would not work
            if(isset($_POST['parent']))
                return $_POST['parent'];
            
            //otherwise I grab it by  the current UID
            $ParentInfo=CrudoQuery::getItemParent(CURRENT_UID);
            return $ParentInfo['universal_id'];
            
            return false;
        endif;
        
        
        if(
           ($field_name=='creation_date' or $field_name=='last_modify' )
           and EDIT_MODE=='new'
           or ($field_name=='last_modify' and EDIT_MODE=='edit')
           )
                return date('Y-m-d H:i:s');
                
        if($field_name=='creation_date' and EDIT_MODE=='edit')
                return CrudoQuery::getItemCreationDate(CURRENT_UID);
        
        

        
        //creation date is automatically inserted by Insert_C
        return false;
    }
    
    
    protected function _fieldUpdateIsRequested($field_name){
        if(!trim($field_name)) return false;
        
        //new item
        if(
           isset($_POST[$field_name]) and
           !isset($_POST['PRE_'.$field_name]) and
           $field_name!=$this->main_table
           )
         return true;
        
        //update
        if(
           isset($_POST[$field_name]) and
           isset($_POST['PRE_'.$field_name]) and
           $_POST[$field_name] != $_POST['PRE_'.$field_name] or
           !empty($_FILES[$field_name])             //if a new file has been uploaded
        )
            return true;
    
        return false;
        
    }
    

    protected function _formRequiresFather(){
    /*
     returns false or the field name of the required father
    */
    
    //if there's no option for the foreign item key
        //it means that we cannot print the form since
        //that one is an obligated father

        
        foreach($this->Fields as $field_name):
            $form_table=$this->_getFormParentTable($field_name);
            if(EasyQuery::isForeignItemKey($field_name,$form_table)):
            
                $this->RequiredFathers[]=EasyQuery::getParentTable($field_name);
            
            endif;
        
        endforeach;
        
        if ( $this->RequiredFathers )
            return true;
        
        return false;

        
    }
    
    protected function _formIsValid(){
        return $this->_validateForm();
    }
    
    
    
    
    

    
    
    protected function _getSafeDataToInsert(){
        //defines data to insert and returns bool
        //if($this->FieldsToUpdate) return false;
        
        $DataToInsert=array();//scaffold
        foreach($this->FieldsToUpdate as $field_name)
            if(isset($_POST[$field_name])) // basically if it's not a file ###probably need fixing
                $DataToInsert[$field_name]=$_POST[$field_name];
            elseif(isset($_FILES[$field_name]))
                $DataToInsert[$field_name]=$_FILES[$field_name];
            
        if(!$DataToInsert) return false;
        
        $this->DataToInsert=$DataToInsert;
        
        return $DataToInsert;
    }
    
    
    
    
    
    protected function _getMaxLength($field_name){
        

        $FieldInfo=$this->FormTables[self::_getFormParentTable($field_name)][$field_name];
        
        if( preg_match( '!\(([^\)]+)\)!', $FieldInfo['Type'], $match ) )
            return $match[1];
            
            
        
    }
    
    

    protected function _getFormParentTable($field_name){
        
        foreach($this->FormTables as $table_name=>$Fields)
            if(in_array($field_name,array_keys($Fields)))
                return $table_name;
        
    }
    
    
    
    
    
    
    protected function _isMandatory($field_name){
        
        if(in_array($field_name,explode(',',$this->custom_mandatory_fields)))
           return true;
        
        $FieldInfo=$this->FormTables[self::_getFormParentTable($field_name)][$field_name];

        ###
        if($FieldInfo['Null']=='NO' && !$FieldInfo['Default'] )
            return true;
        
    }
    
    
    
    
   
    protected function _isValid($field_name){
        //if the field is not in the form or as not been changed
        //I skip the validation
        //if(!$this->_fieldUpdateIsRequested($field_name))
          //  return true;
        
        
        //get post value
        $posted=$_POST[$field_name];
        
        
        //check if it's mandatory
        if($this->_isMandatory($field_name) && trim($posted)==''):
            if(isset($_POST['PRE_'.$field_name]) && $_POST['PRE_'.$field_name]):
            
                $_POST[$field_name]=$_POST['PRE_'.$field_name];
                Notify::warning('Attenzione non puoi cancellare '.$field_name,$field_name);
                
            else:
        
                Notify::userError($field_name.' e obbligatorio',$field_name);
     
            endif;
            
            return false;
        endif;
        
        
        
        //if it's not mandatory and it's empty  Ireturn true
        if(!trim($posted))
            return true;
        
        
        
        //check if maxlength is within range
        $maxlength=$this->_getMaxLength($field_name);
        if ( $maxlength>0 && strlen($posted) > $maxlength && $field_name!='youtube_video'):
            Notify::userError($field_name.' e troppo lungo!',$field_name);
            return false;
        endif;
        
        
        
        
        //add validation function
        
        $vf=Validate::defineValidationFunction($field_name);
        if($vf):
            if(!Validate::$vf($posted)):
           
                Notify::userError('Validate::'.$vf.'() '.$posted.' non è un valido '.$vf,$field_name); return false;
            endif;
        else:
            Notify::developer(
                'Non è stata definita una funzione di validazione per '.$field_name
                );
        endif;
        
        
        //check for primary / unique keys
        if
        (
         self::_mustBeUnique($field_name) and
         EasyQuery::valueExists($posted,$this->FormTables,$field_name)
         ):
        
        Notify::userError(
            'un '.$field_name.' con il valore '.$_POST[$field_name].' esiste già',$field_name
            ); return false;

        endif;
   
        
        return true;
    
    }
    
    protected function _mustBeUnique($field_name){
        /*
         returns true if a field has to be unique
        */
        
        $Table=self::_getFormParentTable($field_name);
        $FieldInfo=$this->FormTables[$Table][$field_name];
        
        return ($FieldInfo['Key']=='PRI' || $FieldInfo['Key']=='UNI' );

    }
    
    
    protected function _thereAreDataToInsert(){
        
        return $this->_getSafeDataToInsert();
        
    }
    
    
    protected function _thereAreFieldsToUpdate(){
        
        return $this->_defineFieldsToUpdate();
        
    }
    
    protected function _validateForm(){
        $valid=true;
        
        //if there is no fields to validate I skip the validation
        $this->_defineFieldsToUpdate();
        //print_r($this->FieldsToUpdate);//for test
        if(!$this->FieldsToUpdate):
            //echo 'non ci sono modifiche da apportare';
            return true;
        endif;
        
        foreach($this->FieldsToUpdate as $field_name)
            if(isset($_POST[$field_name]))
            if(!$this->_isValid($field_name))
                $valid=false;
        
        return $valid;
    }
    
    
    
    
    
    
    
    
    
}