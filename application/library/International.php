<?php

class International{
    

    static function isLang($lang){
        
        if(array_key_exists($lang,self::$LangReference)) return true;
        
        return false;
    }
    

    static function getClientLanguage(){
        /*
         returns the language of the user's browser
        */
        $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $lang = substr($lang, 0, 2);
        return $lang;
    }
    
    static $Definitions; //array that will be populated by loadTranslations method
    
    
    static function getDefinition($base_name,$lang=PAGE_LANG){
        
        //load translations if not loaded
        if(!self::$Definitions)
            self::loadTranslations();
         
         //if there is translation I return it   
        if(isset(self::$Definitions[$lang][$base_name]))
           return self::$Definitions[$lang][$base_name];
        
        
        //notify developer if a language module or definition is missing
        if(!isset(self::$Definitions[$lang]))
            Notify::developer('No language module found for '.$lang);
        else
            Notify::developer('Missing definition of '.$base_name.' in '.$lang.' language');
        
        
        //if there is no translation I return base_name
        return $base_name;   
       
    }
    
    
    static
    $LangReference
    =
    array(
        'ar'=>'العربية',
        'bg'=>'Български',
        'ca'=>'Català',
        'cs'=>'Česky',
        'da'=>'Dansk',
        'de'=>'Deutsch',
        'en'=>'English',
        'es'=>'Español',
        'eo'=>'Esperanto',
        'fa'=>'فارسی',
        'fr'=>'Français',
        'ko'=>'한국어',
        'id'=>'Bahasa Indonesia',
        'it'=>'Italiano',
        'he'=>'עברית',
        'lt'=>'Lietuvių',
        'hu'=>'Magyar',
        'ms'=>'Bahasa Melayu',
        'nl'=>'Nederlands',
        'ja'=>'日本語',
        'no'=>'Norsk (bokmål)',
        'pl'=>'Polski',
        'pt'=>'Português',
        'ro'=>'Română',
        'ru'=>'Русский',
        'sk'=>'Slovenčina',
        'sl'=>'Slovenščina',
        'sr'=>'Српски / Srpski',
        'fi'=>'Suomi',
        'sv'=>'Svenska',
        'tr'=>'Türkçe',
        'uk'=>'Українська',
        'vi'=>'Tiếng Việt',
        'vo'=>'Volapük',
        'war'=>'Winaray',
        'zh'=>'中文'
 )
;

    
    
    static function loadTranslations(){
        self::$Definitions=parse_ini_file( "definitions.php", true );
    }
    
}