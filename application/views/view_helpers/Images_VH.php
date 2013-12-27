<?php

class Images_VH{
    
    
    static function display($Item='',$size='120',$width='',$height=''){
        
        
        //if there's no item information I assume I need the current page pic
        //so I get the info from the page info
        
        
        if($Item)
            $image=EasyImage::getFullPath($Item,$size);
        else //if there's no item I try with current page
            $image=EasyImage::getFullPath(CURRENT_UID,$size);
            
            
        //if the image is not there and this is a small icon I display default
        if(!$image and $size==120)
            return '<img src="'.SHARED.'default_120.gif" alt="foto '.@$Item['name_or_title'].' non disponibile" title="foto '.@$Item['name_or_title'].' non disponibile"/>';
        
        //get only image name
        $image=Strings::getLastPiece($image,'/');
        
        
        return '<img src="'.SHARED.$image.'" alt="foto '.@$Item['name_or_title'].'" title="foto '.@$Item['name_or_title'].'"/>';
    }
    
    
    
    static function displayImagesInDir($dir){
        ###need fixing we need function that transform a path to it's correspondent URL
        $ImagesPaths=EasyFile::filesInDirectory($dir,'jpg,jpeg,gif,png');
        $images='';//scaffold
        $i=0;
        
            foreach($ImagesPaths as $img_path):
                //add class show to first image for gallery
                $i++; $class=($i==1) ? ' class="show"' : '';
                $images.='<img src="'.SHARED.'custom/gallery/'.$img_path.'" alt="foto"'.$class.' />';
            endforeach;
                
                echo $images;
    }
    
    
   
    
    
    
    
}