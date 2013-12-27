<?php


class Classes{
    

    
    static function isAbstract($class_name){
        
        $class = new ReflectionClass($class_name);
        if($class->isAbstract()) return true; return false;

    }
    
    
    
    static function getUserInstanciableClasses(){
        /*
         Returns the list of the instanciable classess that have
         been defined by the user
        */
        
        //get all the classes
        $AllClasses=get_declared_classes();
        
        foreach($AllClasses as $Class):
        
            $class = new ReflectionClass($Class);
            
            if($class->isInstantiable() && $class->isUserDefined()):
            
                $InstanciableClasses[]=$Class;
            
            endif;
                
        
        endforeach;
        
        return $InstanciableClasses;
        
        
    }

    
}