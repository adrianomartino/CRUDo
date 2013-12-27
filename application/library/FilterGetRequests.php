<?php


class FilterGetRequests{
    /*
     This class is amazing it returns only the get requests
     expected from the website. All the others will simply be
     Ignored!
     
     Whatever is not listed into the class variables,
     will be ignored. You can also specify a validation
     function simply with the initial variable value.
     
     for example: $user_phone_number = phone_number
     will validate the Get var $user_phone_number with the
     phone_number function.
     
     if valudation function is not specified, the program will
     try to understand what validation is needed
     
     Note: needs 'Validate' Class
    */
    


    public function __construct($AcceptedRequests){

        //if is not an array is probably a serialization of it
        if(!is_array($AcceptedRequests)) 
            $AcceptedRequests=unserialize($AcceptedRequests);
            
        $FilteredRequests=NULL;
        
        foreach (  $AcceptedRequests as $request_name=>$validation_identifier   ) :
         
            if  (   isset($_GET[$request_name] ) ) :

                
                (trim($validation_identifier)) ? $validation_identifier=$validation_identifier : $validation_identifier = $request_name;
                
                $validation_function=Validate::defineValidationFunction($validation_identifier);
               
                if (  $validation_function   )   :
                        
                        //if is valid I save in class
                        if (Validate::$validation_function($_GET[$request_name])):
                        
                            $FilteredRequests[$request_name]=$_GET[$request_name];
                        
                        else:
                            //if is not valid I generate developer message
                            Notify::developer($_GET[$request_name].' is not a valid '.$request_name.' parameter');
                        
                        endif;
                
                else:
                
                    //save the others that don't have validation
                    $FilteredRequests[$request_name]=$_GET[$request_name];
                
                
                endif;
                
            endif;
        
        endforeach;
        

        $_GET=$FilteredRequests;
        
    }
    
    
}