<!DOCTYPE html>
<html>
<head>
<title>Jquery HTML5 Form Test</title>
<meta name=description content="" />
<meta http-equiv=Content-Type content="text/html; charset=UTF-8" />

<!--HTML TAGS support for old browsers-->
<script src=//html5shiv.googlecode.com/svn/trunk/html5.js></script>

<!--Hide safari when site opened from home screen-->
<meta name=apple-mobile-web-app-capable content=yes />

<!--Block people from zooming the website so it looks like an app-->
<meta name="viewport" 
        content="width=device-width, initial-scale=0.8, maximum-scale=0.8, user-scalable=no" />

<meta name="apple-touch-fullscreen" content="yes" />


<style type=text/css>
    .textarea{
        border:1px solid;
        min-height:400px;
        width:100%;
    }
    
    input[type=button]{
        height:60px;
        width:100%;
    }
</style>


</head>

<body onunload="" onload="window.top.scrollTo(0, 1)"><!-- This does the trick for Jquery back button DONT Touch! -->


<form name=form action=form_test.php method=post >
    
    <div contenteditable=true class=textarea></div>
    <input type=button id=submit value=send />
</form>

<!--CDN load JQuery-->
<script src=https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js type=text/javascript></script>




<script type="text/javascript">
$(document).ready(function() {
    $('form[name=form]').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            cache: false,
            url: './ajax/header_ajax.php',
            data: 'id=header_contact_send&'+$(this).serialize(), 
            success: function(msg) {
                $("div").html(msg);
            }
        });
    });     
});         
</script>




</body>
</html>