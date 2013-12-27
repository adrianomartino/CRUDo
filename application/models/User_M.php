<?php

class User_M{

    

    static function getBasicInfo($user_email,$user_pwd){
                
        return
            EasyQuery::selectOneRow('
                      
                SELECT
                user_email,user_password,user_level
                FROM UTENTI
                WHERE
                user_email="'.$user_email.'"
                AND
                user_password="'.$user_pwd.'"
                ');

    }
    
    
    static function getUserGroups(){
        
        //get current user id
        $uid=Router::$User->id;
        
        return EasyQuery::selectOneValue(
                    'SELECT groups FROM UTENTI WHERE user_id=$uid LIMIT 0,1'
                    );
        
    }

    

    
    
}