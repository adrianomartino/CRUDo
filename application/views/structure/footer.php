<footer>
	
	<h6>E' una iniziativa a cura di: </h6> 
	
	<ul id='loghi_sponsor' class='left'>
				<li><a href='http://www.ascom.bo.it?referral=MenuVeraBologna' title='Visita il sito della ConfCommercio' id='confcommercio'>Confcommercio</a></li>
				<li><a href='http://www.bo.camcom.gov.it?referral=MenuVeraBologna' title='Visita il sito della Camera di commercio' id='camera_commercio'>Camera di commercio industria e artigianato del comune di Bologna</a></li>
				
				<li><a href='http://www.alkalina.it?referral=MenuVeraBologna' title='Alkalina, actual power for your marketing' id='alkalina'>Alkalina Comunicazione</a></li>
			
			<!--<li><a href='http://www.italian-label.com?referral=MenuVeraBologna' title='Italian label, il tuo anello di congiunzione con gli Stati Uniti' id='italian_label'>Italian Label Advertising</a></li>
			-->
				
				<li><a href='http://www.accademiaitalianacucina.it?referral=MenuVeraBologna' title='Visita il sito della Accademia italiana della cucina' id='accademia_cucina'>Accademia italiana della cucina <br/> Bologna Delegazione San Luca</a></li>
				
				<li><a href='http://www.lionsdistretto108tb.it/nuovo/bologna/123-lions-club-bologna-re-enzo.html?referral=MenuVeraBologna' title='Visita il sito della Lions Club International' id='lions_club'>Lions Club International <br/> Bologna Re Enzo</a></li>
				
				<li><a href='http://www.ilrestodelcarlino.it?referral=MenuVeraBologna' title='Visita il sito del resto del carlino' id='carlino'>Il resto del Carlino</a></li>
				
				
		
		</ul>
		
		<h6 id='contributo'>Con la collaborazione di: </h6> 
	<ul id='loghi_sponsor_2' class='right'>		
			<li><a href='http://www.comune.bologna.it?referral=MenuVeraBologna' title='Visita il sito del Comune di Bologna' id='comune_bologna'>Comune di Bologna</a></li>
			
			<li><a href='http://www.provincia.bologna.it?referral=MenuVeraBologna' title='Visita il sito della Provincia di Bologna' id='provincia_bologna'>Provincia di Bologna</a></li>
			
			<li><a href='http://www.provincia.bologna.it?referral=MenuVeraBologna' title='Visita il sito della Provincia di Bologna' id='regione_romagna'>Regione Emilia Romagna</a></li>
			
			<li><a href='http://www.aptservizi.com/it/?referral=MenuVeraBologna' title="Visita il sito della APT Servizi per l\'Emilia Romagna" id='apt_romagna'>APT Servizi<br/> Emilia Romagna</a></li>
			
			
			<li><a href='http://www.popolarevicenza.it?referral=MenuVeraBologna' title='Visita il sito della Banca Popolare di Vicenza' id='bp_vicenza'>Banca Popolare di Vicenza</a></li>
			
			
		
		
	</ul>
	
	
	<span class='clear'>
	<?php
		$Links=new Item_C('approfondimenti','Public_Links',
				  array('list_sons'=>true)
				  );
		$Links=$Links->ItemData;
		
		if($Links)
			foreach($Links as $Link)
				$FooterLinks[]='<a href="'.Url::_($Link).'">'.$Link['name_or_title'].'</a>';
				
			
			echo SITE_NAME.' tutti i diritti riservati <br/>';
				if(isset($FooterLinks)) echo implode(' | ',$FooterLinks);
				

	?>
</span>




</footer>



<?php require_once('structure/_script_calls/_script_calls.php') ?>



    

<?php

//calculate loading times
  $loading_times=getmicrotime() - START_TIME;  //echo $loading_times;
  
  
  //Notify::developer('Page has loaded in '.$loading_times);
 
   
   
   //new Notifications_VH();
   

?>

</body>
</html>