<?php

class Admin_C extends Main_C{

    
    public function __construct(){
        
        
        
        
        //get actions
	
	//---- Image deletion				//this in case an item is deleted
        if((URL_ACTION=='delete_image' or URL_ACTION=='delete') and CURRENT_UID and !$_POST):
		EasyImage::deleteImage(CURRENT_UID);
                header('Location:'.Url::_(CURRENT_UID,true).'/edit');
        endif;
        
        
        
        //----- Eventual Item deletion 
        if(URL_ACTION=='delete' and CURRENT_UID):
        
	    $main_table=CrudoQuery::getTableFromTopic(MAIN_TOPIC);
            $pk=EasyQuery::getPrimaryKey($main_table);
        
            DbQuery::delete('DELETE FROM '.$main_table.' WHERE '.$pk.'="'.CURRENT_UID.'"' );
            DbQuery::delete('DELETE FROM _item_metadata WHERE universal_id="'.CURRENT_UID.'"' );
            DbQuery::delete('DELETE FROM _item_generator WHERE universal_id="'.CURRENT_UID.'"' );
            $loc=ROOT.'admin/'.MAIN_TOPIC.'/';
       		header("Location:$loc");
        
        endif;
        
        
        
        
        
        
        
        $AdminMenuItems=Admin_M::getAdminMenu();
        
        //listing
        if(PAGE_TYPE=='List'):
        
            $Form=NULL;
        
            $CurrentSnippet=new Item_C(
                            CURRENT_UID,
                            'Public_Snippets',
                            array(
                            'custom_fields'=>'',
                            'where'=>'',
                            'limit'=>'0,1',
                            'order_by'=>'name_or_title ASC'
                            )
                            );
            
            $CurrentSnippet=$CurrentSnippet->ItemData;
            
        
            $List=new Item_C(
                            CURRENT_UID,
                            'Public_Snippets',
                            array(
                            'custom_fields'=>'',
                            'where'=>'',
                            'limit'=>'',
                            'list_sons'=>true,
                            'order_by'=>'name_or_title ASC'
                            )
                            );
                            
                            
            $List=$List->ItemData;
            

        
        else:
            
            //editing item
            if( MAIN_TOPIC!='Home'):
                $List=NULL;
            
                $uid_or_new=(EDIT_MODE=='new') ? 'new' : PAGE_TOPIC;
                
                $Form=new Form_C();
                $Form=$Form->Form;
            else:
            
                $List=NULL;
                $Form=NULL;
            
            endif;
        
        endif;
        
        
        

        
        include($this->_selectPageView());
            
        
    }
    
    
}