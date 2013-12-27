<?php

class Item_C{

    public $ItemData; //this will be filled by the construct
    

    public function __construct($uid_or_url,$context,$Options=array()){
            
        /*
         Initiate one item of a list of items selected from the DB based on the Options given and the User's permissions
         
         Supported options are:

         custom_fields=
         where=
         limit=
         order_by=
         list_sons=false
         
         
         
         
         
         
         ATTENTION! if it's single item selection like PUBLIC page it needs to select where UID= otherwise it needs to select where parent=
         
         
         
         ### FIX enable item controller even when UNIVERSAL ID is not specified
         
         

        */
        
        

        
        //populate default options if not specified
        if(!isset($Options['limit']) or !$Options['limit']) $Options['limit']='0,100';
        if(!isset($Options['order_by']) or !$Options['order_by']) $Options['order_by']='foto DESC,last_modify';
        if(!isset($Options['list_sons']) or !$Options['list_sons']) $Options['list_sons']=false; 
        
        
        //save the options in plain vars to use in this function
        foreach($Options as $option=>$value)
                   ${$option}=$value;
            
            
        //calculate UID if  url is given
        $uid=(is_numeric($uid_or_url)) ? $uid_or_url : CrudoQuery::getUID($uid_or_url);
        
        //message and if resource cannot be identified (that means that we are listing the parent items)
        if(!$uid) echo 'UID per '.$uid_or_url.' not found'; 
        
        
        
        
        
        
        //get the right Model Name based osn the item type/table
        
        
        ### need create function to support custom models selecting the right model name by item_utl or item parents url
        //$model_name=ucfirst(strtolower($item_main_topic)).'_M';
        //if(!file_exists($model_name)) $model_name='Item_M';
        
        //missing function for
        $model_name='Item_M';
        
        //instanciate the model
        $Item_M=new $model_name($uid);
        //pass the query vars to the model
        
        
        
    

        //retrieve item parent
        $Item_M->item_parent=CrudoQuery::getItemParentUid($Item_M->uid);

        if(isset($where)) $Item_M->where=$where;
        if(isset($limit)) $Item_M->limit=$limit;
        if(isset($list_sons)) $Item_M->list_sons=$list_sons;
        if(isset($order_by)) $Item_M->order_by=$order_by;
        
        
        
                 // ----------- SETTING PERMISSIONS -----------//
        //set the default to show only public items
        $Item_M->show='PUBLIC_ONLY';
        
        
        
        /*
         Sets the user reading permissions
         for the user relatively to the current
         kind of item and pass some values to the model
        */

        //se what the current user can read
        $user_can_read=User_C::$can_read;
        
        if( $user_can_read == 'ALL' ) 
            $Item_M->show='ALL';
            
        if( $user_can_read == 'HIS_ITEMS' ){
            $Item_M->show='HIS_ITEMS';
            $Item_M->creator_id=User_C::$id;
        }
            
        if( $user_can_read == 'HIS_GROUPS' ){
            //finding out if he can see the current group
            $current_group=$item_parent;
            $user_groups=User_C::$groups;
            
            //if the item is part of the groups the user is allowed to see
            if(in_array($current_group,explode(',',$user_groups)))
                $Item_M->show='ALL';
            else
                $Item_M->show='PUBLIC_ONLY';
        }

        if( $user_can_read == 'PUBLIC_ITEMS' )
            $Item_M->show='PUBLIC_ONLY';
            
            
            
            
            
            
        
        
        //set context
        $Item_M->context=Strings::getFirstPiece($context, '_');
        
        
        //load data
       // ----------- LOAD DATA  -----------//
         switch($context):
        
        
            // ---- ADMIN DATA  
        
            case 'Admin_Page':
                //if the limit is still the default I change it to one
                $Item_M->limit=($Item_M->limit=='0,100') ? '0,1':$Item_M->limit; 
                $this->ItemData=$Item_M->selectAdminPage();
            break;
        
            case 'Admin_Snippets':
                $this->ItemData=$Item_M->selectAdminSnippets();
            break;
        
            case 'Admin_links':
                $this->ItemData=$Item_M->selectAdminLinks();
            break;
        
        
        
            // ----PUBLIC DATA  
            
            case 'Public_Page':
                //if the limit is still the default I change it to one
                $Item_M->limit=($Item_M->limit=='0,100') ? '0,1':$Item_M->limit; 
                $this->ItemData=$Item_M->selectPublicPage();
            break;

            case 'Public_Snippets':
                $this->ItemData=$Item_M->selectPublicSnippets();
            break;

            case 'Public_Links':
                $this->ItemData=$Item_M->selectPublicLinks();
            break;
        
        
            // ----- OTHER DATA 
            
            case 'Form_Select':
             //   $Item_M->show='PUBLIC_ONLY';
                $Item_M->limit='';
                $this->ItemData=$Item_M->selectFormSelect();
            break;
        
            case 'Custom_Select':
                $this->ItemData=$Item_M->customSelect($custom_fields);
            break;
        
        
            case 'Admin_Form':
            case 'Public_Form':
                
                //start form controller

            break;

        
        endswitch;
            
            
            

        
        
        
        

        //select view
        
        //add to Page view
        
    }
    
    
    
    
    
    
    
    
    
    
    
    // ----------- PRIVATE FUNCTIONS -----------//
    
    
    

 

}