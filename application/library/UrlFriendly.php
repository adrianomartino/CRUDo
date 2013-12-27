<?php

class UrlFriendly{




static function getStringAsUrl($string){
	
	//----###this function needs to be fixed
	if(PAGE_LANG!='zh'||PAGE_LANG!='ru'):
	
		$string=self::_badchars($string);
		$string=trim($string);
		$string=self::_unaccent($string);
		
			// Define the maximum number of characters allowed as part of the URL        
		$currentMaximumURLLength = 100;
		
		$string = strtolower($string);
		
		// Any non valid characters will be treated as _, also remove duplicate _
		
		$string = preg_replace('/[^a-z0-9_]/i', '_', $string);
		
		// Cut at a specified length
		
		if (strlen($string) > $currentMaximumURLLength)
		{
		    $string = substr($string, 0, $currentMaximumURLLength);
		}
		
		// Remove beggining and ending signs
		
		$string = preg_replace('/_+$/i', '', $string);
		$string = preg_replace('/^_/i', '', $string);
				
			$string = preg_replace('/-+$/i', '', $string);
		
			$string = preg_replace('/-+/i', '-', $string);
			
		return trim($string);
		
	else:
	
		return rawurlencode($string);
	
	endif;
    }
    
    
    


static function _badchars($testo){
$transo=array(
"|"=>"","!"=>"","\""=>"","£"=>"","$"=>"","%"=>"","&"=>"e","("=>"",")"=>"",
"="=>"","?"=>"","*"=>"","-"=>"_",","=>"",";"=>"",":"=>"","."=>"","@"=>"",
"+"=>"","§"=>"","^"=>"","<"=>"",">"=>"","°"=>"","#"=>"","["=>"","]"=>"","ç"=>"c",
);
strtr($testo, $transo);
return $testo;
}



static function _unaccent($outPut) {
  static $search, $replace;
  if (!$search) {
    $search = $replace = array();
    // Get the HTML entities table into an array
    $trans = get_html_translation_table(HTML_ENTITIES);
    // Go through the entity mappings one-by-one
    foreach ($trans as $literal => $entity) {
      // Make sure we don't process any other characters
      // such as fractions, quotes etc:
      if (ord($literal) >= 192) {
        // Get the accented form of the letter
        $search[] = $literal;
        // Get e.g. 'E' from the string '&Eacute'
        $replace[] = $entity[1];
      }
    }
  }
  return str_replace($search, $replace, $outPut);
}


















}

?>