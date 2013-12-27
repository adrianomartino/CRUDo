<?php


class Strings{
    
    static function addDoubleQuotes($string){

            return '"'.$string.'"';

    }
    
    
    static function addBraces($string){

            return '{'.$string.'}';

    }
    
    
    ###to check, chnge and uniform to CRUDO
    static function trimText($input, $length, $ellipses = true) {

        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length)
            return $input;

      
        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);
      
        //add ellipses (...)
        if ($ellipses and strlen($trimmed_text) < strlen($input))
            $trimmed_text .= '...';
      
        return $trimmed_text;
    }



    
    
    static function getFirstPiece($string,$delimitator='/'){
     /*
     retrieves the first word of a string that is divided by $delimitator
    */
     
        $string=explode($delimitator, $string);
        
        return $string[0];

        
    }
    
    static function getLastMatch($string,$matches,$delimitator='/'){
        
        $Matches=explode(',',$matches);
        $Matches=array_map('trim',$Matches);
        
        $last_piece=self::getLastPiece($string,$delimitator);
        
        if(in_array($last_piece,$Matches))
            return $last_piece;
        else
            return false;
        
    }

    static function getLastPiece($string,$delimitator='_',$goback=1){
     /*
     retrieves the last word of a string that is divided by $delimitator
    */
     
        $string=explode($delimitator, $string);
        
        return $string[count($string)-$goback];

        
    }
    
    static function ditchFirstPiece($string,$delimitator='_'){
     /*
     ditches the last piece of a string that is divided by $delimitator
    */
     
        $String=explode($delimitator, $string);
        
        $string_length=strlen($string);
        $characters_to_ditch=strlen($String[0])+1;
        
        return substr($string, $characters_to_ditch, $string_length);

        
    }
    

    static function ditchLastMatch($string,$matches,$delimitator='/'){
        
        $Matches=explode(',',$matches);
        $Matches=array_map('trim',$Matches);        
        
        if(in_array(self::getLastPiece($string,$delimitator),$Matches))
            return self::ditchLastPiece($string,$delimitator);
        else
            return $string;
        
    }
    
    
    
    
    
    static function ditchLastPiece($string,$delimitator='/',$list=''){
     /*
     ditches the last piece of a string that is divided by $delimitator
    */
     
        $String=explode($delimitator, $string);
        
        $string_length=strlen($string);
        $characters_to_ditch=strlen($String[count($String)-1]);
        
        return substr($string, 0, $string_length - $characters_to_ditch);

        
    }
    
    
    static function autoUL($string,$ul_id='',$ul_class=''){
        /*
        Takes a string and transforms any new line in an html element of an ordered list
        */
        
        
        $Punti=explode("\n",$string);
        
        $ul_id=($ul_id) ? ' id="'.$ul_id.'"' : '';
        $ul_class=($ul_class) ? ' class="'.$ul_class.'"' : '';
                
        return   '
        <ul'.$ul_id.$ul_class.'>
            <li>
            '.implode('</li><li>',$Punti).'
            </li>
        </ul>
        ';
                          
                          
        
    }
    
    
    
    static function isInTheList($potential_match,$list,$delimitator=',',$case_insensitive=true){
        /*This function allows to match a string in a list, avoiding using the slow preg_replace
        and using the power of array operations, in a case insensitive manner*/
        
        //lower string for case insensitive math
        if($case_insensitive)
            $list=strtolower($list);
        
        $List=explode($delimitator,$list);
        
        return in_array($potential_match,$List);        
        
    }
    
    
    static function sprintfAssoc($format, array $Values){
        /*
        This function is intended to combine a format and variables
        to present a text. Like the sprintf function but with the
        associative power
        
        $format must be a string with the {var_names} represented into braces
        
        Eg.:
            $format='
                        <div>
                            <h1>{Title}</h1>
                            <h2>{SubTitle}</h2>
                            <p>{Text}</p>
                        </div>
                        ';
        
        $Values must be an associative array and braces are not supposed to be in array keys as they will be automatically added by this function.
        
        */
        
        //add braces to values
        foreach($Values as $key=>$value)
            $NewValues['{'.$key.'}']=$value;
        $Values=$NewValues;
        unset($NewValues);
        
        return strtr($format,$Values);
    
    }
    
    
    
    static function underScoreToUcFirst($string,$keep_undercores=false, $first_capital=true){
        /*
         converts s string from this_format to ThisFormat
         if $first_capital is set to false it will convert to thisFormat
         if $keep_underscores is set to true it returns This_Format
        */
        
        $separator='';
        
        $PiecesOfString=explode('_',$string);
        $PiecesOfString=Arrays::removeEmptyValues($PiecesOfString);
        
        $PiecesOfString=array_map('ucfirst',$PiecesOfString);
        
        if(!$first_capital)
            $PiecesOfString[0]=strtolower($PiecesOfString[0]);
            
        if($keep_undercores)
            $separator='_';
            
        return implode($separator,$PiecesOfString);
        
        
        
    }
    
    
    
    
}

