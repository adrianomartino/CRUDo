<?php

/*
 * Crudo Framework Version 2.0
 * copyright © Adriano Martino 2011 (www.adrianomartino.com)
 * 
 * Lists_VH 2.0.0
 *
 * Get the all the info for the current page.
 * Passes them to View to open document header
 * 
 */

class Lists_VH{
    
    
    static $public_snippets_format;
        
        
    public function __construct(){
        
        self::$public_snippets_format=
        
        '
        <div class="list_row">
                
            
                    <h3><a href="'.ROOT.'{item_type}/{item_url}">{name_or_title}</a></h3>
                    <p>
                        {item_snippet}
                    </p>
            
            
                
                <div class="foto left">
                    {foto}
                </div>
                
            
            
            <a class="vota_btn" href="#" title="clicca qui per votare {name_or_title}">vota</a>
            <span class="topright">categoria: {item_type}</span>
            
            
            </div>
        
        ';
        
        
    }
        
        


    static function publicSnippets($Data){
        
        if(!$Data)
            return false;
        
        $snippets='';
        
        $i=0;
        foreach($Data as $Row):
        
            $class=( $i%2 ) ? ' class="odd_row"' : "";
            $snippet=($Row['item_snippet']) ? $Row['item_snippet'] : 'nessun incipit definito';
            
            $snippets.=
                "
                <div$class>
                <p>
                <b class='name_or_title'><a href='".Url::_($Row)."'>$Row[name_or_title]<a></b>
                <span class='snippet'>$snippet</span>
                </p>
                <div class='clear'></div>
                </div>
                ";
            
            $i++;
            
        endforeach;
        
        return $snippets;
    }
    
    
    static function adminLinks($Data){
        
        $list=''; //scaffold
        
        
        if(!$Data)
            return false;
        
        $snippets=''; //scaffold


        foreach($Data as $Row)
            $list.="<li><a href='".Url::_($Row,true)."'>$Row[name_or_title]</a></li>\n";
            

        
        return $list;
    }
    
    
    
    
    static function adminSnippets($Data){
        
        if(!$Data)
            return false;
        
        $snippets=''; //scaffold
        
        $i=0;
        foreach($Data as $Row):
        
            $class=( $i%2 ) ? '' : ' class="odd_row"';
            $snippet=($Row['item_snippet']) ? $Row['item_snippet'] : 'nessun incipit definito';
            
            
            
            /*Change class if image is vertical*/
            $image_class=' horizontal'; //scaffold
            $image_url=EasyImage::getFullPath($Row);
            if(EasyImage::isVertical($image_url))
                    $image_class=' vertical';
                    
                    
            
            $snippets.=
                "
                <div$class>
                <p>
                <b class='name_or_title'><a href='".Url::_($Row,true)."'>$Row[name_or_title]<a></b>
                <!--<span class='snippet'>$snippet</span>-->
                
                <a href='".Url::_($Row,true)."'>
                <span class='squared_thumb".$image_class."'>
                        ".Images_VH::display($Row,'120','','96')."
                            </span>
                            </a>
                            
                <span class='commands'>
                    <a href='".Url::_($Row,true)."'>crea/mostra articoli figli</a>
                    <a href='".Url::_($Row,true)."/edit'>modifica</a>
                    <a onclick=\"return confirm('Sei sicuro(a) di voler cancellare? Tutti i file correlati andranno persi.')\" href='".Url::_($Row,true)."/delete'>cancella</a>
                </span>
                </p>
                <div class='clear'></div>
                </div>
                ";
            
            $i++;
            
        endforeach;
        
        return $snippets;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    static function adminCatSnippet($Data){
        
        if(!$Data)
            return false;
        
        $snippets=''; //scaffold
        
        $i=0;
        foreach($Data as $Row):
        
            $class=( $i%2 ) ? '' : ' class="odd_row"';
            $snippet=($Row['item_snippet']) ? $Row['item_snippet'] : 'nessun incipit definito';
            
            
            
            /*Change class if image is vertical*/
            $image_class=' horizontal'; //scaffold
            $image_url=EasyImage::getFullPath($Row);
            if(EasyImage::isVertical($image_url))
                    $image_class=' vertical';
                    
                    
            
            $snippets.=
                "
                <div$class>
                <p>
                <b class='name_or_title'><a href='".Url::_($Row,true)."'>$Row[name_or_title]<a></b>
                <!--<span class='snippet'>$snippet</span>-->
                
                <a href='".Url::_($Row,true)."'>
                <span class='squared_thumb".$image_class."'>
                        ".Images_VH::display($Row,'120','','96')."
                            </span>
                            </a>
                            
                <span class='commands'>
                    <a href='".Url::_($Row,true)."/new'>crea un articolo figlio</a><br>
                    <a href='".Url::_($Row,true)."/edit'>modifica descrizione/foto</a><br>
                    <!--<a onclick=\"return confirm('Sei sicuro(a) di voler cancellare? Tutti i file correlati andranno persi.')\" href=#>cancella</a>-->
                </span>
                </p>
                <div class='clear'></div>
                </div>
                ";
            
            $i++;
            
        endforeach;
        
        return $snippets;
    }
    
    
    
    
    
    
    
    
    static function iconsAndTitles($Data){
        
        if(!$Data)
            return false;
        
        $snippets=""; //scaffold
        
        $i=0;
        foreach($Data as $Row):
        
            $class=( $i%2 ) ? ' class="odd_row"' : "";
            $snippet=($Row['item_snippet']) ? $Row['item_snippet'] : 'nessun incipit definito';
            
            
            /*Change class if image is vertical*/
            $image_class=' horizontal'; //scaffold
            $image_url=EasyImage::getFullPath($Row);
            if(EasyImage::isVertical($image_url))
                    $image_class=' vertical';
            
            
            $snippets.=
                "
   
                <div class='icon_and_title'>
                    
                        <a href=".Url::_($Row).">
                            <span class='squared_thumb".$image_class."'>
                        ".Images_VH::display($Row,'120','','96')."
                            </span>
                            ".$Row['name_or_title']."
                        </a>

                </div><!--icon and title-->
                
                
                ";
            $i++;
            
        endforeach;
        
        return $snippets;
    }
    
    
    
    
    
    
    
    
    
    
    
    static function relatedIcons($Data){
        
        if(!$Data) return false;
        
        $snippets=""; //scaffold
        
        $i=0;
        foreach($Data as $Row):
        
            $snippet=($Row['item_snippet']) ? $Row['item_snippet'] : 'nessun incipit definito';
            
            
            /*Change class if image is vertical*/
            $image_class=' horizontal'; //scaffold
            $image_url=EasyImage::getFullPath($Row);
            
            $img=(!$image_url) ?
            '<img src="'.SHARED.'default_300.gif" alt="foto non disponibile"/>':
            Images_VH::display($Row,'350','','96');
            
            if(EasyImage::isVertical($image_url))
                    $image_class=' vertical';
            
            $snippet=$Row['item_snippet'];
            
            
            if(!trim($Row['item_snippet']))
                    $snippet=strip_tags(CrudoQuery::getItemLongDesc($Row['universal_id']));
       
            $snippet=Strings::trimText($snippet,96);
            
            
            
            $snippets.=
                "
                
            <div class='related_box'>
              <h3><a href=".Url::_($Row).">".$Row['name_or_title']."</a></h3>
              <div class='small_intro_img'><a href=".Url::_($Row).">".$img."</a></div>
              <p>
                 ".$snippet."
                <a href=".Url::_($Row).">".International::getDefinition('read_more')."</a>
              </p>
      </div>
     
      
                ";
            $i++;
            
        endforeach;
        
        return $snippets;
    }
    
    
   //".Strings::trimText($Row['item_snippet'],60)."
   

    
    
    
    
    
    
    
    

    
    
    static function listaRistoranti($Data){
        
        foreach($Data as $Ristorante):
        $email=($Ristorante['email'])? '<a href="mailto:'.$Ristorante['email'].'">email</a>':'';
        $chiuso_il=($Ristorante['chiuso_il']!='sempre aperto')? '<span>Chiuso '.$Ristorante['chiuso_il']:'</span>';
        
            $list.='
            <div class="ristorante_in_lista">
            <h4>'.$Ristorante['nome'].'</h4>
            <address>
                '.$Ristorante['indirizzo'].'<br/>
                '.$Ristorante['cap'].' - '.$Ristorante['localita'].'</br>
                '.$Ristorante['telefono'].'<br/>'.
                $email.'
            </address>
            '.$chiuso_il.'
            </div>
            ';
        
        endforeach;
        
        return $list;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    //-----other functions
    
    
    
    
    
    ////default list format definition
    //static function defaultRowFormat($Data){ ###activate it back
    //    
    //    $format=false;
    //    $SampleItem=$Data[0];
    //    
    //    foreach($SampleItem as $key=>$value):
    //    
    //        $format .= $key.\': %s\';
    //    
    //    endforeach;
    //    
    //        return $format;
    //    
    //}
    
    
    
     //default list format definition
    static function defaultRowFormat($Data){
        
        $format=false;
        $SampleItem=$Data[0];
        
        $format.='<div class="table_row">';
        
            foreach($SampleItem as $key=>$value):
            
                $format .= '<span>'.ucfirst(preg_replace('/_/',' ',$key)). ' %s</span>';
            
            endforeach;
        
        $format.='</div>';
        
            return $format;
        
    }
    
    
    
    
    
    
    
    

    
    static function listDisplay($Data, $row_format=false){
        
        //set the list handler
        $list=false;
        
        //if there's no formatting specified I apply the default format defined at the bottom of this file
        (!$row_format)  ?   $row_format=self::defaultRowFormat($Data) : null;
        
        foreach ($Data as $row) :

                    $list.=vsprintf($row_format, $row);
        
        endforeach;
        
        return $list;
    
    }
    
    
    

    
    
}