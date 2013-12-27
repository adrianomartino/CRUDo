  <!--SCRIPTS-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" 
            type="text/javascript"></script>
    <script src="<? echo SCRIPTS_DIR; ?>jquery.exptextarea.js" 
            type="text/javascript"></script>
            
            <!--<script src="<? echo SCRIPTS_DIR; ?>jquery-ui-1.8.9.custom.min.js" 
            type="text/javascript"></script>-->
            
            <script src="<? echo SCRIPTS_DIR; ?>jquery-ui-timepicker-addon.js" 
            type="text/javascript"></script>
            
    
    
    
     <!--script to check if user has made changes to the form and ask confirmation to leave the page-->
   <!-- <script type="text/javascript">
		var isDirty = false;
		var submitted = false;
		//var editorIsDirty = (.rich_text_editor.isDirty());
		//if (tinyMCE.activeEditor.isDirty()) alert("You must save your contents.");
		
		
	    var msg = 'You haven\'t saved your changes.';
	    
	    $(document).ready(function(){
		$(':input').change(function(){
		    if(!isDirty){
			isDirty = true;
		    }
		});
		
		
		//$(window).unload(function() {
		window.onbeforeunload = function(){
				
		//add on to check if rich text editor is dirty		
		$(tinyMCE.editors).each(function () {
		    if (this.isDirty()) { isDirty = true };
		});

		
		$('form').submit(function() {
		    submitted = true;
		});
		
		    if(isDirty && !submitted){
			return msg;
		    }
		};
		
	    });

</script>-->
    
    <!--inclusions for tag and autocomplete-->
    <!-- But will need those -->
	
    <link href="<? echo SCRIPTS_DIR; ?>tags/jquery.ui.autocomplete.custom.css" rel="stylesheet" type="text/css"  />
	<!-- Source code is customized, don't forget about then if updating -->
	<script src="<? echo SCRIPTS_DIR; ?>tags/tag-it.js" type="text/javascript" charset="utf-8"></script>
           
            
    
    
    <!--texteditor loading and options-->
    
    <script type="text/javascript" src="<? echo SCRIPTS_DIR; ?>texteditor/tiny_mce/jquery.tinymce.js"></script>
	<script type="text/javascript">
			$(function() {
					// Apply editor to every textarea with rich_editor class
					$('textarea.rich_editor').tinymce({
						// Location of TinyMCE script
						// Use either tiny_mce_gzip.php, which is a compressor to reduce loading time
						// Or directly tiny_mce.js
						script_url : '<? echo SCRIPTS_DIR; ?>texteditor/tiny_mce/tiny_mce.js',

						// General options
						theme : "advanced",
						plugins : "style, paste",

						// Theme options
						theme_advanced_buttons1 : "bold,italic,|,justifyleft,justifyright,styleselect, bullist,numlist,|, link, unlink, code",
						theme_advanced_buttons2 : "",
						theme_advanced_buttons3 : "",
						theme_advanced_buttons4 : "",
						
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "bottom",
						theme_advanced_resizing : true,
						theme_advanced_path : false,
						
						// Styles that are used in the editor area
						content_css : "<? echo SCRIPTS_DIR; ?>texteditor/editor.css",
						
						style_formats : [
							{title : 'paragrafo', inline : 'p'},
							{title : 'Titolo', block : 'h3'},
							{title : 'Titoletto', block : 'h2'},
						],
						
				});
			});
			
	</script>
    

    
    <!--end of texteditor loading and options-->
 

    <!-- tipsy -->
    <link href="<? echo SCRIPTS_DIR; ?>tipsy/stylesheets/tipsy.css" rel="stylesheet" type="text/css"  />
	<script src="<? echo SCRIPTS_DIR; ?>tipsy/javascripts/jquery.tipsy.js" type="text/javascript" charset="utf-8"></script>
     


 <script type='text/javascript'>
        jQuery.fn.limitMaxlength = function(options){

  var settings = jQuery.extend({
    attribute: "maxlength",
    onLimit: function(){},
    onEdit: function(){}
  }, options);
  
  // Event handler to limit the textarea
  var onEdit = function(){
    var textarea = jQuery(this);
    var maxlength = parseInt(textarea.attr(settings.attribute));

    if(textarea.val().length > maxlength){
      textarea.val(textarea.val().substr(0, maxlength));
      
      // Call the onlimit handler within the scope of the textarea
      jQuery.proxy(settings.onLimit, this)();
    }
    
    // Call the onEdit handler within the scope of the textarea
    jQuery.proxy(settings.onEdit, this)(maxlength - textarea.val().length);
  }

  this.each(onEdit);

  return this.keyup(onEdit)
        .keydown(onEdit)
        .focus(onEdit);
};


        
        </script>
        
        
            <script>
    
    $(document).ready(function(){
    
		$('textarea').expandingTextArea();
		
        // Tipsy
        $('textarea').tipsy({trigger: 'focus', gravity: 'w', offset: 10});
        $('a[title]').tipsy({gravity: 's'});
		
		
		 
		 // And here's your new length delimiter code.
	$('textarea[maxlength]').limitMaxlength({
    onEdit: function(remaining){
		if($(this).siblings('.charsRemaining').length>0)
			$(this).siblings('.charsRemaining').text(remaining);
		else if($(this).siblings().find('.charsRemaining').length>0)
			$(this).siblings().find('.charsRemaining').text(remaining);
	}
  });

		 
		 
		 
		 
         
         $( ".timestamp" ).datetimepicker({
                timeFormat: 'hh:mm:ss',
                dateFormat: 'yy-mm-dd'
            });
         
         //2011-02-13 21:11:24
         
         
         
         		// Apply one kind of tags to element with #mytags
		$("#item_keywords").tagit({
			availableTags: '<? echo SCRIPTS_DIR; ?>tags/query.php' // All this little fella does is sends the same output. Don't let this confuse you.
		});
		
		// And second one to #limitedTags
		$("#limitedTags").tagit({
			availableTags: '<? echo SCRIPTS_DIR; ?>tags/query.php',
			suggestionsOnly: true
		});
		
		
		


});


</script>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
<!-- for regions -->

<script type="text/javascript">
$(document).ready(function(){
	$('.hide-js').hide();

	$('#cap').keyup(function(){
		if($(this).val().length==5){
			$.ajax({
				type: 'GET',
				url: '<?php echo AJAX_PAGES?>locations.php',
				data: $("#cap").serialize(),
				beforeSend: function(){
					$('#additional_options select').selectmenu('destroy');
					$("#additional_options select").empty().hide();
					$('#additional_options').hide();
					
					$('#additional_options .message').hide();
					$("#cap").siblings('.waiter').css("display", "inline-block");
				},
				complete: function(){
					$('#additional_options').show();
					$('#additional_options .message').html();
					
					if ($('#additional_options option').length == 0){
						if($("#cap").val().substr(($("#cap").val().length-2, 2))== '00')
							$('#additional_options .message').html("Last numbers are two 00. Perhaps, it's a generic code. Try entering the specific one.").fadeIn();
						else
							$('#additional_options .message').html('No results found.').fadeIn();
					}
					else{
						$('#additional_options select').show();
												
						if ($('#additional_options select option').length > 1){
							$("#additional_options option:first").before($("<option value=''>Select</option>"));
							$("#additional_options option:first").attr("selected", "selected").attr("disabled", "disabled");
						}
						
						$('#additional_options select').selectmenu({style: 'popup', format: function(text){
							var newText = text.split('|');
							
							var classes = ['comune', 'provincia', 'br', 'fraz', 'frazione', 'br', 'regione', 'lat', 'lng'];					
							for (var i = 0; i < newText.length; i++){
								newText[i] = '<span class="'+classes[i]+'">'+newText[i]+'</span>';
							};
						
							return newText.join(' ');
						}});
					}
					$("#cap").siblings('.waiter').css("display", "none");
				},
				cache: false,
				success: function(html){
					$("#additional_options select").html(html);
				}
			});
		}
	});

});

</script>