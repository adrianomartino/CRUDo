<section id='small_intros'>
      
      
   <?php
      $sponsor_n=rand(1,3);
      
      switch ($sponsor_n):
            
            case 1: //accademia
                  $sponsor_link='http://www.accademiaitalianacucina.it?referral=MenuVeraBologna';
            break;
      
      
            case 2: //confommercio
                  $sponsor_link='http://www.bo.camcom.gov.it?referral=MenuVeraBologna';
            break;
      
      
            case 3: //mvb
                  $sponsor_link=Url::_('good_morning_bologna');
            break;
      
      endswitch;
?>
      
      <a class='squared_banner' href='<?php echo $sponsor_link ?>'>
            <img src='<?php echo SHARED.'banners/squared_banner_'.$sponsor_n.'.gif';?>' alt='spazio pubblicitario' />
      </a>
      
      <!--<a class='squared_banner' href='<?php echo Url::_('ristoranti') ?>'>-->
      
      <a class='squared_banner' href='<?php echo ROOT ?>ristoranti'>
            <img src='<?php echo SHARED.'banners/banner_ristoranti.gif';?>' alt='I ristoranti Menu Vera Bologna' />
      </a>
      
      
      
      <?php
	  
	  if(isset($Related))
		echo Lists_VH::relatedIcons($Related);
		 
		 ?>
		 
		<!-- <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'faves',
  rpp: 10,
  interval: 30000,
  title: 'ff0000',
  subject: '255',
  width: 255,
  height: 255,
  theme: {
    shell: {
      background: '#850d21',
      color: '#e0d736'
    },
    tweets: {
      background: '#ffffff',
      color: '#828081',
      links: '#154282'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: true,
    behavior: 'all'
  }
}).render().setUser('@MenuVeraBologna').start();
</script>
-->

<div style="margin-top:20px;" class="fb-like-box" data-href="https://www.facebook.com/pages/Menu-Vera-Bologna/335038236547912" data-width="340" data-height="340" data-show-faces="false" data-border-color="#999" data-stream="true" data-header="false"></div>
<br/><br/><br/>
<div class="fb-like-box" data-href="https://www.facebook.com/pages/Menu-Vera-Bologna/335038236547912" data-width="340" data-height="220" data-show-faces="true" data-border-color="#999" data-stream="false" data-header="false"></div>


<!--twitter-->
<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 12,
  interval: 30000,
  width: 320,
  height: 180,
  theme: {
    shell: {
      background: '#800e21',
      color: '#ffffff'
    },
    tweets: {
      background: '#ffffff',
      color: '#ffffff',
      links: '#0c2857'
    }
  },
  features: {
    scrollbar: false,
    loop: true,
    live: true,
    behavior: 'all'
  }
}).render().setUser('@MenuVeraBologna').start();
</script>

<!--end of twitter box -->

     

      

		
<!--
              
      <div class='iniziativa'>
              <h3>L'iniziativa</h3>
              <div class='small_intro_img'><img src='<?php echo CSS_DIR ?>base/img/photo_sprite.jpg'/></div>
              <p>
                      Scopri le prelibatezze della cucina
                      tradizionale bolognese nei ristoranti
                      che la interpretano secondo le regole
                      dell'Accademia Italiana di Cucina.
                      <a href='<?php echo ROOT ?>approfondimenti/l_accademia_italiana_della_cucina'>Leggi di più</a>
              </p>
      </div>
      
      
      <div class='come_raggiungere'>
              <h3>Come Raggiungere Bologna</h3>
              <div class='small_intro_img'><img src='<?php echo CSS_DIR ?>base/img/photo_sprite.jpg'/></div>
              <p>
                      In treno, in aereo, dall'estero
                      <a href='#'>Leggi di più</a>
              </p>
      </div>
      
      
      <div class='dove_dormire'>
              <h3>Dove Dormire</h3>
              <div class='small_intro_img'><img src='<?php echo CSS_DIR ?>base/img/photo_sprite.jpg'/></div>
              <p>
                      Oltre 50 alberghi convenzionati con l'iniziativa
                      <a href='#'>Leggi di più</a>
              </p>
      </div>-->
        
</section>