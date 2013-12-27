<?php
	if($_GET['offset'] < 10):
		for($i = 1; $i < 6; $i++):
?>


		<?php
                if($Ristoranti)
                    foreach($Ristoranti as $Ristorante):
                    
                        
                        echo '
                            
                            <li class="ristorante slide">
                
                
                                <div class="foto">
                                    '.Images_VH::display($Ristorante['CuocoPatron'],'350').'
                                </div>
                                
                                <div class="right">
                                
                                        <h3>'.$Ristorante['CuocoPatron']['name_or_title'].'</h3>
                                    <h4>Bologna</h4>
                                    
                                    <p>
                                        '.$Ristorante['item_snippet'].'
                                    </p>
                                    
                                    
                                    
                                    
                                    <div class="piatto">
                                        <h4>Piatto in evidenza</h4>
                                        <a href="#">'.$Ristorante['Piatto']['name_or_title'].'</a>
                                        <div class="foto">
                                            '.Images_VH::display($Ristorante['Piatto'],'120','82').'
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    
                                    
                                    <div class="punti_di_forza">
                                        <h4>Da visitare specialmente per:</h4>
                                        '.Strings::autoUL($Ristorante['punti_di_forza_ristorante'],'punti_di_forza').'
                                    </div>
                                
                                
                                    
                                    
                                    
                                    <div class="link_scheda">
                                        <a href="#" class="vota_e_vinci">Vota e vinci</a>
                                        <a href="'.Url::_($Ristorante).'">Visita scheda</a>
                                    </div>
                                    
                                    <div class="clear"></div>
                                    
                                </div><!-- fine right -->
                            
                                <div class="clear"></div>
                            </li><!-- fine ristorante -->
                            
                        
                        
                        ';
                        
                        
                    
                    
                    
                    endforeach;
            
            
            
            ?>
		
		
		
		
		
		
		
		<?php sleep(1);?>
<?php
		endfor;
	endif;
?>