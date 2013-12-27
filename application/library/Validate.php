<?php


/*
 * Crudo Framework Version 2.0
 * copyright © Adriano Martino 2011 (www.adrianomartino.com)
 * Class Validate 2.0
 * Description:
 * The class manage all the connections to the DB.
 * Every query on the website will pass by the
 * query function of the parent class Connect.
 * The present class contains shortcuts for the most used queries relative
 * to the default DB structure and to the current website
 * 
*/



class Validate{
    

    static function defineValidationFunction($variable_name){
	/*
	determine which validation function
	should be used based on the variable name to validate.
	the variable names should be formatted like this:
	${specific_name}_typeOfData. Eg.: user_email will call
	the validation function email();
	*/
	
	//if a function named as the variable, exists I return it
	if(method_exists(__CLASS__, $variable_name))	return $variable_name;

	//if a function named as the last part of the variable I return it
	$last_piece=Strings::getLastPiece($variable_name);
	
	if($last_piece && $variable_name!='item_url')
	if(method_exists(__CLASS__, $last_piece))
	return $last_piece;
    
	$first_piece=Strings::getFirstPiece($variable_name,'_');
	if($first_piece)
	if(method_exists(__CLASS__, $first_piece))
	return $first_piece;
	

	//if I cannot find a function I return false
	return false;
    }

    static function lang($string){
	/*
	 this function determine if a date string corresponds to one of the site's languages
	defined in the constant LANGUAGES in config/settings.php
	VERY IMPORTANT not to validate languages that are not included
	*/
    
	if( strlen($string) == 2 && preg_match("/$string/", LANGUAGES)) return true; return false; 
	
    }

    
    
    static function ip($ip=false){
       /*
        determine if the current or a given address is a valid IP address
       */
       
        //assign default ip
        if ( !$ip  )   :   $ip =   $_SERVER['REMOTE_ADDR']; endif;
        
        //check if ip is valid
        if (   !filter_var($ip, FILTER_VALIDATE_IP  )   )   :   die('Your IP address is not valid!');   endif;	return true;

    }
    
    
    


    
    static function email($email){
	//validate email address
	
        // elimino spazi, "a capo" e altro alle estremità della stringa  
        $email = trim($email);  
      
        //if empty is false  
        if(!$email) return false;  
      
        //check that there's only 1 '@'
        $num_at = count(explode( '@', $email )) - 1;  if($num_at != 1) return false;
      
        // controllo la presenza di ulteriori caratteri "pericolosi":  
        if(strpos($email,';') || strpos($email,',') || strpos($email,' '))	 return false; 
      
        // la stringa rispetta il formato classico di una mail?  
        if(!preg_match( '/^[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}$/', $email)) return false;  
      
	//if passed all the tests
        return true;  
    } 
    
    
    
    
    
    
    static function cap($zip){

	if (!preg_match("/^[0-9]{5}$/",$zip))	return false;	return true;
   
    }
    
    

    
    static function italianPhoneNumber($number){

	if (preg_match("/(0|3)[0-9]{1,5}[\/\-][0-9]{5,11}+/",$number))	return true;	return false;
   
    }
    
  
  
   
    static function url($url){
	    /*
	     check if a url is valid and working
	    */
	    
           if(!preg_match("/^[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+$/i",$url))  return false;   return true;
	$headers = get_headers($url);
	if (strpos($headers[0], '200'))
	    return true;
	
	return false;
   }
   
   
   
   
    static function name_or_title($name_or_title,$lang=PAGE_LANG,$topic=MAIN_TOPIC){
    
        
        if(isset($POST['PRE_name_or_title']) and $POST['PRE_name_or_title'] == $name_or_title)
            return true; //update
    
        $url=UrlFriendly::getStringAsUrl($name_or_title);
        
        
        
        $sql='
            SELECT universal_id, item_url FROM _item_metadata
	    NATURAL JOIN _item_generator
            WHERE item_url="'.$url.'"
            AND item_lang="'.$lang.'"
            AND parent="'.CrudoQuery::getUID($topic).'"
            LIMIT 0,1
        ';
            
        
            
           // echo $sql;
        $Data=DbQuery::query($sql);

    
        if($Data && URL_ACTION!='edit')
            return false;
        
        return true;
   }
   
      
    static function partita_iva($pi){
	/*
	 Italian VAT number Validation 
	*/
	 if( $pi == '' )  return false;
	 if( strlen($pi) != 11 )	return false;
	 if( ! ereg("^[0-9]+$", $pi) ) return false;
	 $s = 0;
	 for( $i = 0; $i <= 9; $i += 2 )
	     $s += ord($pi[$i]) - ord('0');
	 for( $i = 1; $i <= 9; $i += 2 ):
	     $c = 2*( ord($pi[$i]) - ord('0') );
	     if( $c > 9 )  $c = $c - 9;
	     $s += $c;
	 endfor;
	 if( ( 10 - $s%10 )%10 != ord($pi[10]) - ord('0') )
	     return false;
	 return true;
    }
    
    
    static function youtube($video_id){
	
	//if it's empty I return true
	if(!trim($video_id)) return true;
	
	//if it's a url I convert in uid
	if(strlen($video_id)>11)
	    $video_id=YouTube::UrlToVideoId($video_id);
	
	$headers = get_headers('http://gdata.youtube.com/feeds/api/videos/'.$video_id);
	if (strpos($headers[0],'200'))
	    return true;
	
	return false;
    }
    
    static function UID($id){
	
	if (preg_match("/^[0-9]{1,7}$/",$id))	return true;
	
    }


    
    
}