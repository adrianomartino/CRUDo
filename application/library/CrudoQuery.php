<?php

class CrudoQuery extends EasyQuery{
    
      //------Crudo queries
    
    static function isMainTopic($uid){
        /*returns true if the item with universal_id uid is a main topic*/
        $Data=EasyQuery::query('SELECT parent FROM _item_generator WHERE universal_id="'.$uid.'" AND parent="0"');
        return (isset($Data[0]));
    }
    
    
    
    
    
    
    //---------------- UIDs AND THEIR FAMILY ------------------//
    
    
    
    static function getItemMainTopic($item_url_or_uid){
        
        //check validity
        if(!trim($item_url_or_uid)):
            Notify::developer(__FUNCTION__.' no valid resource specified '.$item_url_or_uid);
            return false;
        endif;
        
        
        $Parents=self::getItemParentsInfo($item_url_or_uid);
        
        //if I found it I return it
       return $Parents[0];
        
        //otherwise I return the item itself if it has no father
        
        
    }
    
    static function getItemParentsInfo($item_url_or_uid){
        
        //check validity
        if(!$item_url_or_uid):
            echo __FUNCTION__.' no valid resource specified '.$item_url_or_uid;
            return false;
        endif;
        
        
        $ParentsUIDs=self::itemGetParentsUIDs($item_url_or_uid);
        $ParentsInfo=array(); //scaffold
        
        foreach($ParentsUIDs as $uid):
        
            $ItemInfo=self::query('SELECT universal_id,item_url, name_or_title FROM _item_metadata WHERE universal_id="'.$uid.'" LIMIT 0,1');
            $ParentsInfo[]=$ItemInfo[0];
            
        endforeach;
        
        
        return $ParentsInfo;
    }
    
    
    static function getItemGeneration($Item_url_or_uid){
        /*
         returns a multidimensional  nested numeric array with
         all the sons, grandsons, greatgrandsons and more of an item.
        */
        
        ###Fix item generation function
        
        //if I got the Url or UID I retrieve the item info
        if(!is_array($Item_url_or_uid)) $Item_url_or_uid=CrudoQuery::getItemInfo($Item_url_or_uid);
        
        //check input
         if(!is_array($Item_url_or_uid)):
            Notify::developer(__CLASS__.' '.__FUNCTION__.'() source provided is not valid');
            return false;
        endif;
        
        $Item=$Item_url_or_uid; //shorten
        
        $ItemGeneration=array(); //scaffold
        
        $Sons=self::getItemSons($Item);
        print_r($Sons);
        if(!$Sons) return false;
        
        foreach($Sons as $Son):
                $GrandSons=self::getItemGeneration($Son);
                    if($GrandSons):
                        $Sons=array_push($Sons,$GrandSons);
                        foreach($GrandSons as $GrandSon)
                            $Sons=array_push($Sons,self::getItemGeneration($GrandSon));
                    else:
                        
                        return $Sons;
                    
                    endif;
                    
        endforeach;
            
        
        return $Sons;
        
        
        
    }
    
    
    
    
    
    static function getItemParentUid($item_url_or_uid){
        
         //determine UID
        $uid=(is_numeric($item_url_or_uid)) ? $item_url_or_uid : CrudoQuery::getUID($item_url_or_uid);
        
        
        /*returns the $uid of the parent item*/
        if(!$uid)  die(__FUNCTION__.' no valid source provided!');
        
        $sql='SELECT parent from _item_generator WHERE universal_id="'.$uid.'" LIMIT 0,1';
        //echo $sql;

        $Data=EasyQuery::query($sql);
        return $Data[0]['parent'];
    }
    static function getItemSons($Item_url_or_uid){
        
        
         //if I got the Url or UID I retrieve the item info
        if(!is_array($Item_url_or_uid)) $Item_url_or_uid=CrudoQuery::getItemInfo($Item_url_or_uid);
        
        //check input
         if(!is_array($Item_url_or_uid)):
            Notify::developer(__CLASS__.' '.__FUNCTION__.'() source provided is not valid');
            return false;
        endif;
        
        
        
        $Sons=new Item_C(
                            $Item_url_or_uid['universal_id'],
                            'Public_Snippets',
                            array(
                            'custom_fields'=>'',
                            'where'=>'',
                            'list_sons'=>true,
                            'limit'=>'1,300',
                            'order_by'=>''
                            )
                            );
        
        $Sons=$Sons->ItemData;
        
        if($Sons) return $Sons;
        
        return false;
        
        
    }
    
    
    
    
    
    static function itemGetParentsUIDs($item_url_or_uid){
        
        //check validity
        if(!$item_url_or_uid):
            echo __FUNCTION__.' no valid resource specified '.$item_url_or_uid;
            return false;
        endif;
        
        
        $Parents=array();
        $parent='_'; //scaffold
        $included_itself=false; //this variable measure if the item has been included in the list since we include itself too
        
        for($i=0;$i<100;$i++):
            
            //set the first uid to search
            if(!isset($to_search)) $to_search=$item_url_or_uid;
            
            //get his father's UID
            $parent=self::getItemParentUid($to_search);
            
            //if he has a father I add to the family
            if($parent>0):
                $Parents[]=$to_search=$parent;
            else:
                $Parents=array_reverse($Parents);
                $Parents[]=self::getUID($item_url_or_uid);
                return $Parents;
            endif;
            
            
        endfor;
        
  return $Parents;
  
    }
    
    
    static function getItemCreationDate($item_url_or_uid){
        
                 //Get UID if not provided
        $uid = (is_numeric($item_url_or_uid)) ?  $item_url_or_uid : self::getUID($item_url_or_uid);
            

         $ItemInfo=self::query('SELECT creation_date FROM _item_generator WHERE universal_id="'.$uid.'" LIMIT 0,1');
        
        
        return $ItemInfo[0]['creation_date'];
         
         
        return false;
    
        
    }
    
    static function getItemInfo($item_url_or_uid){
         
         //Get UID if not provided
        $uid = (is_numeric($item_url_or_uid)) ?  $item_url_or_uid : self::getUID($item_url_or_uid);
            

         $ItemInfo=self::query('SELECT universal_id,item_url, name_or_title,item_lang FROM _item_metadata WHERE universal_id="'.$uid.'" LIMIT 0,1');
        
        
        return $ItemInfo[0];
         
         
        return false;
    
    
        
    }
    
    
    
    static function getItemLongDesc($item_url_or_uid){
         
         //Get UID if not provided
        $uid = (is_numeric($item_url_or_uid)) ?  $item_url_or_uid : self::getUID($item_url_or_uid);
            

         $ItemInfo=self::query('SELECT long_desc FROM _item_long_desc WHERE universal_id="'.$uid.'" LIMIT 0,1');
        
        
        return $ItemInfo[0]['long_desc'];
         
         
        return false;
    
    
        
    }
    
    
    static function getItemParent($item_url_or_uid){
         
         
         $parent_uid=self::getItemParentUid($item_url_or_uid);
         
         $ItemInfo=self::query('SELECT universal_id,item_url, name_or_title FROM _item_metadata WHERE universal_id="'.$parent_uid.'" LIMIT 0,1');
        
        
        return $ItemInfo[0];
         
         
        return false;
    
    
        
    }
    
    
    
    static function getItemTitle($item_url_or_uid){
         
         //Get UID if not provided
        $uid = (is_numeric($item_url_or_uid)) ?  $item_url_or_uid : self::getUID($item_url_or_uid);
            

         $ItemInfo=self::query('SELECT name_or_title FROM _item_metadata WHERE universal_id="'.$uid.'" LIMIT 0,1');
        
        
        return $ItemInfo[0]['name_or_title'];
         
         
        return false;
    
    
        
    }
    
    

    
    static function getUID($item_url){
        
        if(!trim($item_url))  die(__FUNCTION__.' no valid item_url provided!');
        
        //if it's already a UID I return it
        if(is_numeric($item_url)) return $item_url;
        
        
        
        $sql='
            SELECT universal_id FROM _item_metadata
            NATURAL JOIN _item_generator
            WHERE item_url="'.$item_url.'"
            ';

        $Data=self::query($sql);
        
        if(isset($Data[0]['universal_id'])) return $Data[0]['universal_id'];
        
        return false;
        
    }
    
    
    static function getTableFromTopic($item_topic){
        
        ###need to add support for search from topic son to topic fathers
        
        //it returns _item_long_desc if no topic table is available
        
        if(!trim($item_topic)) die(__FUNCTION__.'(): Hey, you have specified no topic!');
        
        $table_name=(EasyQuery::tableExists($item_topic)) ? $item_topic : '_item_long_desc';
        
        return $table_name;
        
    }
    
    
    
}