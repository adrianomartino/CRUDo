<?php
/*
 * Crudo Framework Version 2.0
 * copyright © Adriano Martino 2011 (www.adrianomartino.com)
 * Class Upload 2.0.
 * Features:
 * 1. validation
 * 2. uploading
 * 
 *
 *  Big bug to solve:
 *  it looses the associative field name into the $Files list
 *
 *
 *  Need to add 'naming' format based on format established in external transo array
 *  and given here with sprintf based on the form field name.
 *
 * 
*/


class Upload extends EasyFile{
// var $destination=UPLOAD_FOLDER;
    var $AuthorizedFileTypes=array(); //the construct populates it with the authorized files in config.php
    var $AuthorizedImages=array(); //the construct populates it with the authorized files in config.php
    var $destination=UPLOAD_FOLDER;
    var $ImageSizes=array(); //the construct populates it with the authorized files in config.php
    var $ImagesToProcess=array();
    var $FilesToUpload=array(); //contains all the information of every authorized file that the user is trying to upload
    var $n_of_files_to_upload=0; //scaffold
    var $n_of_uploaded_files=0; //scaffold
    var $n_of_images_to_upload=0; //scaffold
    var $n_of_uploaded_images=0; //scaffold
    var $memory_limit='100M';


public function __construct(){
    
    
    
    //if there's no files I finish it here
    if(!isset($_FILES) or empty($_FILES)) return false;
    
    
    //check if destination folder is writable
    if(!is_writable($this->destination)):
    
        Notify::developer('You cannot upload the file, '.$this->destination.' does not exist or does not have writing permissions');
        return false;
    
    endif;
        
    
    //load list of authorized files
    $this->AuthorizedFileTypes=explode(' ',ALLOWED_FILE_TYPES);
    
    //load list of authorized images that have to be resized after upload
    $this->AuthorizedImages=explode(' ',ALLOWED_IMAGE_TYPES);
    
    
    //load list of authorized images that have to be resized after upload
    $this->ImageSizes=explode(' ',IMAGES_MAX_DIMENSIONS);
    
    
    
    //set the memory limit
    ini_set('memory_limit', $this->memory_limit);
       
    foreach($_FILES as $FileGroup):
        /*I treat the files always as if it was from multiple files form
        so if the array it's actually only of a file I still create the $Files array
        with just one file so that I can process the same way in both occasions*/
        
        
        //in caso di files multipli riarrangio tutto in Array numerico contenente i file separati in subarray
        if (is_array($FileGroup['tmp_name'])) //file multipli
            $Files=Arrays::reGroupSubArrays($FileGroup);
        //altrimenti se il file è uno riorganizzo solo quello in un subarray per renderlo uniforme per operazione successiva
        else
            $Files[0]=$FileGroup;
        
            if($Files[0]['error']!=4): //this is the only prove that at least one file is being uploaded so I can proceed

                $this->n_of_files_to_upload+=count($Files);
                
                    $FilesToUpload[]=$Files;
            
            
                foreach($Files as $File):
                    $ext=EasyFile::mimeToExtension($File['type']);
                        if(self::fileIsAllowed($ext)):
                            if(move_uploaded_file($File['tmp_name'],$this->destination.$File['name'])):
                                $this->n_of_uploaded_files++;
                            endif;
                            
                        else:
                            Notify::userError('Attenzione! Il file '.$File['name'].' non è stato caricato in quanto l\'estensione '.$ext.' non è autorizzata');
                        endif;
                endforeach;
                
                unset($Files);
                
            endif;
            
            
    endforeach;
    
    
    print_r($FilesToUpload);
    
    print_r(Arrays::ditchFirstNumericLevel($FilesToUpload));
    
    echo $mess=$this->n_of_uploaded_files.' files of '.$this->n_of_files_to_upload.' have been successfully uploaded';
    
    //Notify::success($mess);
        
       
}


public function fileIsAllowed($ext){
    return(in_array($ext,$this->AuthorizedFileTypes));
}


public function loadFiles(){
    
    foreach($_FILES as $FileGroup):
        /*I treat the files always as if it was from multiple files form
        so if the array it's actually only of a file I still create the $Files array
        with just one file so that I can process the same way in both occasions*/
        
        
        //in caso di files multipli riarrangio tutto in Array numerico contenente i file separati in subarray
        if (is_array($FileGroup['tmp_name'])) //file multipli
            $Files=Arrays::reGroupSubArrays($FileGroup);
        //altrimenti se il file è uno riorganizzo solo quello in un subarray per renderlo uniforme per operazione successiva
        else
            $Files[0]=$FileGroup;
        
            if($Files[0]['error']!=4) //if at least one file has been uploaded
                foreach($Files as $File):
                    if($this->isAuthorizedFile($File['type']))
                        $FilesToUpload[]=$File;
                        
                    if($this->isImageToProcess($File['type']))
                        $this->ImagesToProcess[]=$File;
                        
                unset($File);
                endforeach;
                        
            unset($Files);
            
            
    endforeach;
    
    //load all the info of the files that need to be uploaded
    $this->n_of_files_to_upload=count($this->FilesToUpload);
    $this->n_of_images_to_upload=count($this->ImagesToUpload);
    
}



public function resizeImages(){
    foreach($this->ImagesToProcess as $Img)
        foreach($this->ImageSizes as $size)
           echo '###'; //to finish
}



public function uploadFiles(){
    
    //upload  files
    foreach($this->FilesToUpload as $File)
                if(move_uploaded_file($File['tmp_name'],$destination.$File['name']))
                    $this->n_of_uploaded_files++;
    
    //upload resized images
    foreach($this->ImagesToUpload as $Image)
                if(move_uploaded_file($Image['tmp_name'],$destination.$Image['name']))
                    $this->n_of_uploaded_images++;

}


































function isAuthorizedFile($file_type_or_extension){
    
    ($file_type_or_extension>5) ?
    $ext=EasyFile::mimeToExtension($file_type_or_extension) :
    $ext=$file_type_or_extension;
    
    
    return (Arrays::inArray_i($ext,$this->AuthorizedFileTypes));

}



function isImageToProcess($file_type_or_extension){
    
    ($file_type_or_extension>5) ?
    $ext=EasyFile::mimeToExtension($file_type_or_extension) :
    $ext=$file_type_or_extension;
    
    
    return (Arrays::inArray_i($ext,$this->AuthorizedImages));

}









}//fine classe
