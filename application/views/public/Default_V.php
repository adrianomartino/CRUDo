<!DOCTYPE html>
<html>
    <head>
	<meta charset='utf-8'>
	<!--SEO first: Page Title, description and keywords-->
	<title><?php echo $CurrentItem['name_or_title'].' | '.SITE_NAME ?></title>
	<meta name="description" content="<?php echo $CurrentItem['item_snippet'] ?>" />
        <meta name="keywords" content="<?php echo @$CurrentItem['keywords'] ?>" />
	
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
  <?php include('structure/main_nav.php'); ?>
                                 

          
        <!--here the page content-->
        <section id='page_content'>

		

        <article>
          
        <!--here the stuff-->
        <h1><?php echo $page_title ?></h1>
        
        <div class="evento_row">
            <div class="left">
                <div class='foto_grande'>
                    <?php
		    if(!$Sons):
			if(EasyImage::getFullPath($CurrentItem)):
			    echo Images_VH::display($CurrentItem,'350');
			    
			    if(trim($CurrentItem['descrizione_foto'])):
				echo '<span class="descrizione_foto" />';
				 echo $CurrentItem['descrizione_foto'];
				echo '</span>';
			    endif;
			
		       endif;
		    endif;
		   
		   ?>
		    
		    
                </div>
            </div>
            
            <div class="right">
                
            
                    <?php echo $long_desc ?>
        
            </div>
            
            

            <div class="clear"></div>
	</div>
            
<div id='facebook_comments'>
    
    
<div class="fb-like" data-href="<?php echo Url::_(CURRENT_UID)?>" data-send="false" data-layout="button_count" data-width="560" data-show-faces="true"></div>

<?php    //commenti Facebook
	    if(!$Sons && PAGE_TOPIC!='press')
	    echo '
	    <h6  style="margin-top:20px;">Lascia un commento</h6>
	    <div class="fb-comments" data-href="'.Url::_(CURRENT_UID).'" data-num-posts="2" data-width="560"></div>
	    
	    ';
	    ?>

	</div>
            

        </div><!-- Piatto -->
	
	
	
	<div class='row'>
	  <?php
	  
	  if(!empty($Sons)):
		 echo Lists_VH::relatedIcons($Sons);
	    elseif(!empty($Siblings)):
	    $parent_name=CrudoQuery::getItemParent(CURRENT_UID);
	    $parent_name=$parent_name['name_or_title'];
		echo '<h2>Altri '.$parent_name.'</h2>'.Lists_VH::relatedIcons($Siblings);
	    endif;
		 ?>
		<div class='clear'> 
	    </div>
	    

            </article>

            
            
	    
	    
           

        </section>
        
        
       
  

  <?php include('structure/col1.php'); ?>
  <!--<?php require_once('structure/col2.php'); ?>-->
  <?php include('structure/footer.php'); ?>