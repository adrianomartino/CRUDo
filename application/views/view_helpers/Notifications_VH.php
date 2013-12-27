<?php

class Notifications_VH{
    
    public function __construct(){
        
        if(Notify::$All):
        
        
            //get translations
            $Translations=parse_ini_file('dbTranslations.php',true);
                if($Translations)
                if(isset($Translations[@MAIN_TOPIC]))
                    $Translations=$Translations[@MAIN_TOPIC];
                else
                    $Translations=array();
                        
                        
                        
        
            $n='<div id="notifications">';

            foreach(Notify::$All as $mess_type=>$Messages):
                //if($mess_type!='user_errors' && $mess_type!='developer'):
                    $n.='<span class="'.$mess_type.'">';
                    
                    foreach($Messages as $message)
                        $n.='<span>'.strtr($message,$Translations).'</span>';
                    
                    
                    $n.='</span>';
                //endif;
            endforeach;
            
            $n.='</div>';
            echo $n;
        
        endif;
    }

}