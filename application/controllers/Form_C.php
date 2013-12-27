<?php

class Form_C extends Form_M{
    
    public $main_table;
    public $Model;
    public $uid;
    
    
    public function __construct(){
  
  
	// define MAIN_TOPIC,$uid_or_new
	
	
	//load vars
        $this->main_table=CrudoQuery::getTableFromTopic(MAIN_TOPIC);
        $this->uid=(CURRENT_UID) ? CURRENT_UID : $_POST['universal_id'];
	//for new items post universal id it's determined by the controller after insert of new item in first table
	
	
  
	//Load Model
	$this->Model=new Form_M;
	
	

        
        //define table
        $this->_defineFormTables();
	
        $this->_defineFields();
	
        $this->_addPrimaryKeyIfNotInFields();
 
	$this->_defineContextValues();
	
	

        //------- POST -------//
        if(isset($_POST[$this->main_table])):
        
        
            
            //---IF FORM IS VALID AND THERE ARE FIELDS TO UPDATE
            if($this->_formIsValid()):

                if($this->_thereAreFieldsToUpdate()):
                    
                    if($this->_thereAreDataToInsert()):
			// print_r($this->DataToInsert);exit; //for debugging
       					
			//add context values to data to insert
                        $this->DataToInsert=array_merge($this->DataToInsert,$this->ContextValues);
                        
			
			
			//convert what it needs to be converted for DB
			foreach($this->DataToInsert as $field_name=>$value)
			    $this->DataToInsert[$field_name]=DbSwitch::convertForDb($field_name,$value);
			
			

			
			
                        //safety and quotes
                        //prepare to mysql
                        $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
			
			###FIX TAKE OFF FILES FROM DataToInsert and mysql_escape_strings
                         $this->DataToInsert=@array_map('mysql_real_escape_string', $this->DataToInsert);
                         $this->DataToInsert=array_map('Strings::addDoubleQuotes', $this->DataToInsert);
                        //close connection
                        mysql_close($link);
                        
                        
                        
                        //print_r($this->DataToInsert);exit; //for test
    
                        
                        if(EDIT_MODE=='new'):
			//--- IF IT'S A NEW ITEM I MAKE INSERT
    
                            $Insert=new Insert_C($this->main_table,$this->DataToInsert);
                            $this->success=$Insert->success;
                                
                            $this->uid=$Insert->item_id;//grab new uid
			    
			    //fore _Post to have the new UID to allow image naming in EasyImage.php
			    $_POST['universal_id']=$this->uid;
			    
			    
			    
                        
                        else:           
			//--- IF IT'S AN UPDATE I MAKE UPDATE
                            $Update=new Update_C($this->main_table,$this->DataToInsert,CURRENT_UID);
                            $this->success=$Update->success;
                            $this->uid=CURRENT_UID;
                            
                        endif;
                        
                        
                        //---- SEND MESSAGE
                        if ($this->success>0):
                            Notify::success('aggiornamento effettuato!');
			    
			    //redirect to correct page with correct address
			    
			    
			    //-------If insert/update has been made I work on uploaded files
			    
			    
			    //rename images if the item url has been renamed
			    if(PAGE_TOPIC && isset($_POST['item_url']) &&  PAGE_TOPIC != $_POST['item_url'])://post pre foto means that an old file used to exist
				
				if(isset($_FILES['foto']) && $_FILES['foto']):
				    //if there's no new image I rename all the versions of the image
				    //EasyImage::overWriteImage(PAGE_TOPIC,$_FILES['foto'],$_POST['item_url']);
				    
				    //if there is new image I overwrite with eventual new namw
				    
				    $oldbasename=EasyFile::getBaseName($_POST['PRE_item_url']); 
				    $newbasename=EasyFile::getBaseName($_POST['item_url']);
				    EasyImage::renameImage($oldbasename,$newbasename);
				    
				else:
				    
				
				endif;
				
			    
			    endif;
			
			    
			    
			    
			    //-----------------------------------------------
	

			    if(EDIT_MODE=='new'):
				header('Location:'.Url::_($_POST['item_url'],true).'/edit');
			    endif;
			    
                            
                        else:
                            Notify::userError('problemi con l\'aggiornamento');
                            
                        endif;
                        
                        
                    endif;
                    

                else:
                
                    Notify::userError('Non sono state effettuate modifiche');
                
                
                endif;
                
                
                 //load files and load their post value to add to the DB
		    //since they really don't have any post value. Fpr instance in this case or images we load
		    //their extention to save it in DB
		//    if(!empty($_FILES))
		//	foreach ($_FILES as $file)
		//	    if()
		
		
		    
		    if($_POST && $_FILES['foto']):
		    
		    ###to fix with multiple files support
	    //	 print_r($_FILES['foto']); exit;
			$Sizes=explode(' ',EasyImage::$allowed_sizes);
			$image_base_name=EasyFile::getBaseName($this->uid);
    
			EasyImage::uploadAndResize($_FILES['foto']['tmp_name'],$image_base_name);
			    
			$_POST['foto']=1;
		    
		    endif;
                
                     

                
            else:
            
                //---- IF THE FORM WAS NOT VALID I SEND MESSAGE
                Notify::userError('Si prega di ricontrollare i dati');
                
            endif;
            

                    
                    
            
        endif;
        //end of post
        



        //get form values from db
        if(PAGE_TOPIC) $this->_defineFormValuesFromDb();
        
        
        //get fields info for Form View Helper
        $FormInfoForVH=$this->_formInfoForVH();
        //print_r($FormInfoForVH);exit; //for test
        
        $Form_VH=new Form_VH($this->main_table,$FormInfoForVH);
     
     
        //load form into controller vars
        $this->Form=$Form_VH->Form;
        unset($Form_VH);



    }
    
}