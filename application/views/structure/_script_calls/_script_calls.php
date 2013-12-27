<!--CDN load JQuery, JQuery UI and all the scripts in the Scripts dir-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
<script src="<? echo SCRIPTS_DIR; ?>scripts.php" type="text/javascript"></script>







<?php
//determine script calls and call file if exists
    $script_calls=SCRIPT_CALLS.MAIN_TOPIC.'_'.PAGE_TYPE.'_scripts.php' ;



if(file_exists($script_calls))
    require_once($script_calls)
    


?>



<!--common scripts-->

        <!-- tipsy -->
        <link href="<? echo SCRIPTS_DIR; ?>tipsy/stylesheets/tipsy.css" rel="stylesheet" type="text/css"  />
        <script src="<? echo SCRIPTS_DIR; ?>tipsy/javascripts/jquery.tipsy.js" type="text/javascript" charset="utf-8"></script>
        
        
        <script src="<? echo SCRIPTS_DIR; ?>tooltipsy.min.js" type="text/javascript" charset="utf-8"></script>
        
        
        
        
        
        
        
<script>
    
$(document).ready(function(){
		
        // Tipsy
        //$('a[title]').tipsy({gravity: 's'});
        //$('img[alt]').tipsy({gravity: 's'});
        
        
        $('a[title]').tooltipsy({
                className: 'bubbletooltip_tip',
                offset: [0, -10],
                show: function (e, $el) {
                    $el.show();
                },
                hide: function (e, $el) {
                    $el.hide();
                }
        });


});


</script>
        
<!--common scripts end-->