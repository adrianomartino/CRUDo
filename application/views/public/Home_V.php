<!DOCTYPE html>
<html>
    <head>
	<meta charset='utf-8'>
	<!--SEO first: Page Title, description and keywords-->
	<title><?php echo SITE_NAME ?></title>
	<meta name="description" content="<? echo SITE_PAYOFF ?>" />
        <meta name="keywords" content="Menu vera Bologna, Cucina Bolognese, Cucina tradizionale bolognese" />
	
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    
	<meta property="fb:app_id" content="<?php echo FACEBOOK_APP_ID ?>"/>
	
	
	<!--Prevent FOUC-->
	<script type="text/javascript"> </script>
	
	
	<!--reset style sheets-->
	<link href="http://yui.yahooapis.com/3.3.0/build/cssreset/reset-min.css" type="text/css" rel="stylesheet"/>
	
	<!--load google fonts-->
	<link href='http://fonts.googleapis.com/css?family=Arapey:400italic,400' rel='stylesheet' type='text/css'>
	    
	<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<? echo CSS_DIR; ?>_every_css.php" />
	
	<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<? echo CSS_DIR; ?>base/base.css" />
	
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<? echo CSS_DIR; ?>base/ie.css" />
	<![endif]-->
        

        <!--<link rel="alternate" type="application/rss+xml" title="<? echo SITE_NAME; ?>" href="<? echo RSS_DIR; ?>rss.php" />-->

<!--Google Analytics-->
	<script type="text/javascript">
	
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-2401038-18']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
<!--Google Analytics end-->
	
    </head>
    <body>
	
	<!--Facebook Javascript SDK-->
	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=126246044053439";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!--facebook javascript SDK -->

<!--<a href='http://www.accademiaitalianacucina.it'><img src='<?php echo ROOT ?>public/files/banners/sponsor_istituzionale_955x60.gif' class='big_banner' alt='banner'/></a>-->

<header>
    <a href='<?php echo ROOT ?>' id='logo'><h1>Menu Vera Bologna</h1></a>
    <p id='site_payoff'>
        <? echo SITE_PAYOFF ?>
    </p>
    
    
    <div id='login'>
    <a href='/menu'>area ristoratori</a> | 
   
<a href='<?php echo Url::_('press')?>'>ufficio stampa</a>
    </div>
</header>





  <?php require_once('structure/lang_nav.php'); ?>
  <?php require_once('structure/main_nav.php'); ?>
  
                                 

          
        <!--here the page content-->
        <section id='page_content'>

		

            <article class='home'>

		<div id='gallery'  class='fadein'>
			
			
			<?php Images_VH::displayImagesInDir(UPLOAD_FOLDER.'custom/gallery/') ?>
			
			
		</div>
		
		<div class='home_intro'>
		<h2>Scopri i piatti della cucina bolognese</h2>
				<h3>16 Piatti selezionati con cura dai membri
					della sezione bolognese dell’Accademia di Cucina Italiana</h3>
				<p>I piatti della migliore tradizione bolognese,
                                che solo a Bologna si gustano secondo la ricetta
                                depositata alla Camera di Commercio dall'Accademia
                                Italiana della Cucina, li puoi gustare nei ristoranti
                                che hanno aderito al Menu Vera Bologna. <a href='<?php echo ROOT ?>piatti' class='read_more'>Clicca qui per conoscerli</a>   
		
		</div>
		
	    
		
            <div class='row'>
		<?php echo Lists_VH::relatedIcons($Piatti) ?>
		<a class='clear' href='<?php echo ROOT ?>piatti' class='read_more'>Visualizza tutti i piatti scelti per te dall’Accademia &gt;</a> 
	    </div>

	   
	    <h3 style='font-size:18px'>Prodotti DOP/IGP</h3>
	    <div class='row'>
		<?php echo Lists_VH::relatedIcons($Prodotti) ?>
		<a class='clear' href='<?php echo ROOT ?>prodotti' class='read_more'>Visualizza tutti i migliori prodotti di Bologna e provincia &gt;</a> 
	    </div>
	    
	    <h3 style='font-size:18px'>Vini</h3>
	    <div class='row'>
		<?php echo Lists_VH::relatedIcons($Vini) ?>
		<a class='clear' href='<?php echo ROOT ?>vini' class='read_more'>Visualizza tutti i migliori vini di Bologna e provincia &gt;</a> 
	    </div>
	    
<h3 style='font-size:18px'>Eventi</h3>
	    <div class='row'>
		<?php echo Lists_VH::relatedIcons($Eventi) ?>
		<a class='clear' href='<?php echo ROOT ?>eventi' class='read_more'>Visualizza tutti gli eventi che si tengono a Bologna, selezionati per te</a> 
	    </div>
            
            <?php
            
            
            
            
            
            ?>
            
            
            
            
            

            </article>
           

        </section>
        
        
       
  

  <?php require_once('structure/col1.php'); ?>
  <!--<?php require_once('structure/col2.php'); ?>-->

  <?php require_once('structure/footer.php'); ?>
  
     
