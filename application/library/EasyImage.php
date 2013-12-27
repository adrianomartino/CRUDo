
<?php

class EasyImage{
    
    //configuration
    static $allowed_types=ALLOWED_IMAGE_TYPES;
    static $allowed_sizes=IMAGES_MAX_DIMENSIONS;
    static $img_folder=UPLOAD_FOLDER;
    
    
    
    
    static function isVertical($img_path_or_resource){
        /* returns true if an image is vertical
        input can be either image path or img resource*/
        
        if(is_string($img_path_or_resource) && !empty($img_path_or_resource)):
            
            if(!self::_isProcessable($img_path_or_resource))
                return false;
            
            $img=self::_imageCreateFromAny($img_path_or_resource);
            
            return (imagesy($img)>imagesx($img));
            
        endif;
        
        
    }

    
    //--------------- for images updates ----------------------
    

    
    static function deleteImage($uid,$n=''){
        
        ###use $n to add support to multiple images (image name ending with _1 , _2 , _3 etc.)
        
        
        //check input                  ###fix with actual uid validation
        if(!is_numeric($uid)) 
             Notify::developer(__FUNCTION__.'() Wrong parameter inserted. Need item Universal id');
        
        //load vars
        $deleted_images=0; //scaffold
        $AllowedSizes=explode(' ',self::$allowed_sizes);
        $image_base_name=EasyFile::getBaseName($uid);
        $ext=self::_getExtentionFromFileSystem($image_base_name);

        
        foreach($AllowedSizes as $size)
            if(file_exists(self::$img_folder.$image_base_name.'_'.$size.'.'.$ext))
                if(unlink(self::$img_folder.$image_base_name.'_'.$size.'.'.$ext))
                    $deleted_images++;

                    
                    
        return (count($AllowedSizes) == $deleted_images);
                    
    }
    

    
    //rename images if the item url has been renamed
    static function renameImage($old_base_name, $new_base_name, $ext=''){
        /*renames the images in any size size that we have in the crudo system*/
        echo $old_base_name;
        if(!$ext) $ext=self::_getExtentionFromFileSystem($old_base_name);
       // $ext='jpg';
        $AllowedSizes=explode(' ',self::$allowed_sizes);
        foreach($AllowedSizes as $size)
            rename(
                   self::$img_folder.$old_base_name.'_'.$size.'.'.$ext,
                   self::$img_folder.$new_base_name.'_'.$size.'.'.$ext
                   );
        
    }
    
    
    static function overWriteImage($old_base_name,$NewFileResource,$new_base_name){
        
        //unlink the old image, since we don't know the extension we just try them all until success
        self::deleteImage($old_base_name);
        
        //upload the new image no matter what the names are
        self::uploadAndResize($NewFileResource,$new_base_name);

    }
    
    
    static function uploadAndResize($FileResource,$image_base_name){
        
             $AllowedSizes=explode(' ',self::$allowed_sizes);
            
             foreach($AllowedSizes as $size)
			$Image=new Image($FileResource,self::$img_folder.$image_base_name,$size);
                        
    }


    
    static function getFullPath($ItemInfo_uid_or_url,$size='120'){
        
        $ItemInfo=(is_array($ItemInfo_uid_or_url)) ? $ItemInfo_uid_or_url : CrudoQuery::getItemInfo($ItemInfo_uid_or_url);
        
        $basename=EasyFile::getBaseName($ItemInfo,$size);
        
        //echo 'ciao'.$basename;
        ###ADD FILE INDEXING IN SISTEM TO AVOID SLOW filexists or restore file ext in DB
        //determine extension
            $AllowedImageTypes=explode(" ",ALLOWED_IMAGE_TYPES);
            foreach($AllowedImageTypes as $ext)
                if(file_exists(self::$img_folder.$basename.'.'.$ext))
                    return self::$img_folder.$basename.'.'.$ext;
        

        return false;
        

    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    


















//------- Private functions ------- //



    private static function _getExtentionFromFileSystem($image_base_name){
        
        //load vars
        $size=Strings::getFirstPiece(self::$allowed_sizes,' ');
        $AllowedTypes=explode(' ', self::$allowed_types);
        
        
        foreach($AllowedTypes as $ext)
            if(file_exists(self::$img_folder.$image_base_name.'_'.$size.'.'.$ext))
                return $ext;
            
        Notify::developer(__FUNCTION__.' There is no allowed image with this item\'s name');
    }

    private static function _imageCreateFromAny($img_url_or_path){
        
        if(self::_isProcessable($img_url_or_path)):
            $ext=EasyFile::getExtension($img_url_or_path);
            if($ext=='jpg'): $ext='jpeg'; endif;
        else:
            Notify::developer(__FUNCTION__.': Unable to get Image Resource from '.$img_url_or_path.'
                              the image it\'s not listed between the processable image types.
                              If you think that the image can be processed please change the
                              value of allowed_image_types in config.php');
            return false;
        endif;
        
        $img_function='imagecreatefrom'.$ext;
        
        return $img_function($img_url_or_path);
        
           
    }
    

    private static function _isProcessable($img_url_or_path){
        /*determines if an image appears to have one of the extensions allowed in config.php
        and if it's actually processable at the moment*/
        
        
        $ext=EasyFile::getExtension($img_url_or_path);
        if(Strings::isInTheList($ext,ALLOWED_IMAGE_TYPES,' '))
            return (EasyFile::fileExists($img_url_or_path));

    }





}


