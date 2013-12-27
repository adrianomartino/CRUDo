<!DOCTYPE html>
<html>
    <head>
	<meta charset='utf-8'>
	<!--SEO first: Page Title, description and keywords-->
	<title><?php echo MAIN_TOPIC ?></title>
	<meta name="description" content="<? echo @$Page['description']; ?>" />
        <meta name="keywords" content="<? echo @$Page['keywords']; ?>" />
	
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