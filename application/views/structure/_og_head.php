<?php echo'<?xml version="1.0" encoding="UTF-8"?>'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"
  xml:lang="'.PAGE_LANG.'" lang="'.PAGE_LANG.'">
    <head>
        <title><? echo @$Page['title']; ?><title>
        <meta name="description" content="<? echo @$Page['description']; ?>" />
        <meta name="keywords" content="<? echo @$Page['keywords']; ?>" />
        
        <!--Open Graph Info-->
        <meta property="og:title" content="<? echo @$Page['title']; ?>"/>
        <meta property="og:type" content="<? echo @$Page['og_type']; ?>"/>
        <meta property="og:url" content="<? echo @$Page['url']; ?>"/>
        <meta property="og:image" content="<? echo @$Page['thumb']; ?>"/>
        <meta property="og:site_name" content="<? echo SITE_NAME; ?>"/>
        <meta property="fb:admins" content="USER_ID"/>
        <meta property="og:description" content="<? echo @$Page['description']; ?>"/>
        <!--Open Graph Info End-->
        
        <link rel="stylesheet" type="text/css" media="screen, print, projection" href="'.CSS_PATH.'css.php" />
        <link rel="alternate" type="application/rss+xml" title="'.SITE_NAME.'" href="'.ROOT.'rss.php" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>