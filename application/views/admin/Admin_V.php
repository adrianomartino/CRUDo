<!DOCTYPE html>
<html>
    <head>
	<meta charset='utf-8'>
	<!--SEO first: Page Title, description and keywords-->
	<title><? echo @$Page['title']; ?> | <?php echo SITE_NAME ?>Area Amministrativa</title>
	<meta name="description" content="<? echo @$Page['description']; ?>" />
        <meta name="keywords" content="<? echo @$Page['keywords']; ?>" />
	
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<!--reset style sheets-->
	<link href="http://yui.yahooapis.com/3.3.0/build/cssreset/reset-min.css" type="text/css" rel="stylesheet"/>

	
	<link rel="stylesheet" type="text/css" media="screen, print, projection" href="<? echo CSS_DIR; ?>admin/structure.css" />
        <link rel="stylesheet" type="text/css" media="screen, print, projection" href="<? echo CSS_DIR; ?>admin/color.css" />
        <link rel="stylesheet" type="text/css" media="screen, print, projection" href="<? echo CSS_DIR; ?>admin/font.css" />
        
        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
        
        
    </head>
    <body class='admin'>
        
        
        
        
    <!-- CONTAINER -->
    <div id="admin_container">
    
    
    
    
        <!-- LEFT MENU -->
        <div id="menu" class="admin_menu">
    
            <div id='first_column'>
                <h1><a href="<?php echo ADMIN_ROOT ?>" id="logo"><img src='<? echo CSS_DIR ?>base/img/MVB_Header.png' alt='<?php echo SITE_NAME; ?>' title='Vai alla homepage'/></a></h1>
                <ul id='items_menu'>

                <?php echo Lists_VH::adminLinks($AdminMenuItems); ?>
                
                </ul>
            </div>
        
        </div>
        <!-- LEFT MENU END -->
        
        
        
        
        
        
        
        
        
        
        
        <!-- CONTENT -->
        <div id="content">
            
            
            
            
            
            <!-- ADMIN HEADER -->
            <div id="admin_header">
                
                
                
                
                
                
                <p id="admin_welcome">

                    <?php
                
                if(PAGE_TOPIC) :
		$ciao=0;
                echo "<a onclick=\"return confirm('Sei sicuro(a) di voler cancellare? Tutti i file correlati andranno persi.')\" href='".Url::_(CURRENT_UID,true)."/delete'>cancella articolo</a> | <a target=_blank href=".Url::_(CURRENT_UID).">Visualizza l'anteprima</a>";
                endif;
                ?>
	
		</p>
                     
                    
                    

            
            
            </div>
            <!-- ADMIN HEADER END-->
        
            
            
            <!--Error Messages and notifications-->
            <?php new Notifications_VH(); ?>
                

            <!-- CURRENT PAGE CONTENT HERE-->
	    
	    
	    
	    <?php
	    if(isset($CurrentSnippet)):
	    
		echo '<div class="top_cat">';
		echo ($CurrentSnippet) ? Lists_VH::adminCatSnippet($CurrentSnippet) : $Form;
		echo '</div>';
		;
	    
	    endif;
	    
	    ?>
	    
	    
            <?php echo ($List) ? Lists_VH::adminSnippets($List) : $Form; ?>
            <!-- END OF CURRENT PAGE CONTENT HERE-->
        
           
           
        </div><!--close content-->
    </div><!--close admin container-->
    
    
    
    
  




<?php require_once('structure/_script_calls/Admin_Scripts.php') ?>


    

</body> 
</html>