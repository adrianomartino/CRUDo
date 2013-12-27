/**
* Customized version
*/



/*
 * jQuery UI Autocomplete Select First Extension
 *
 * Copyright 2010, Scott Gonzalez (http://scottgonzalez.com)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * http://github.com/scottgonzalez/jquery-ui-extensions
 */
(function( $ ) {

$( ".ui-autocomplete-input" ).live( "autocompleteopen", function() {
	var autocomplete = $( this ).data( "autocomplete" ),
		menu = autocomplete.menu;

	if ( !autocomplete.options.selectFirst ) {
		return;
	}

	menu.activate( $.Event({ type: "mouseenter" }), menu.element.children().first() );
});

}(jQuery));



(function($) {

	$.fn.tagit = function(options) {

		var el = this;

		const BACKSPACE		= 8;
		const ENTER			= 13;
		const COMMA			= 44;

		var id = el.attr('id');
		
		el.replaceWith('<ul id="' + id + '"></ul>');
		
		el = $('#'+id);
		
		// add the tagit CSS class.
		el.addClass("tagit");

		// create the input field.
		var html_input_field = "<li class=\"tagit-new\"><input class=\"tagit-input\" type=\"text\" /></li>\n";
		el.html (html_input_field);

		tag_input =  el.children(".tagit-new").children(".tagit-input");

		$(this).click(function(e){
			if (e.target.tagName == 'A') {
				// Removes a tag when the little 'x' is clicked.
				// Event is binded to the UL, otherwise a new tag (LI > A) wouldn't have this event attached to it.
				$(e.target).parent().remove();
			}
			else {
				// Sets the focus() to the input field, if the user clicks anywhere inside the UL.
				// This is needed because the input field needs to be of a small size.
				$(this).children(".tagit-new").children(".tagit-input").focus();
			}
		});

		tag_input.keypress(function(event){
			if (event.which == BACKSPACE) {
				if ($(this).val() == "") {
					// When backspace is pressed, the last tag is deleted.
					$(el).children(".tagit-choice:last").remove();
				}
			}
			// Comma/Enter are all valid delimiters for new tags.
			else if ((event.which == COMMA || event.which == ENTER) && !options.suggestionsOnly) {
				event.preventDefault();

				var typed = $(this).val();
				typed = typed.replace(/,+$/,"");
				typed = typed.trim();

				if (typed != "") {
					if (is_new (typed, $(this))) {
						create_choice (typed, $(this));
					}
					// Cleaning the input.
					$(this).val("");
				}
			}
		});

		tag_input.autocomplete({
			source: options.availableTags,
			selectFirst: true,
			select: function(event,ui){
				if (is_new (ui.item.value, $(this))) {
					create_choice (ui.item.value, $(this), ui.item.label);
				}
				// Cleaning the input.
				$(this).val("");

				// Preventing the tag input to be update with the chosen value.
				return false;
			}
		});

		function is_new (value, tag_input){
			var is_new = true;
			tag_input.parents("ul").children(".tagit-choice").each(function(i){
				n = $(this).children("input").val();
				if (value == n) {
					is_new = false;
				}
			})
			return is_new;
		}
		function create_choice (value, tag_input, label){
			var el = "";
			el  = "<li class=\"tagit-choice\">\n";
			el += label ? label : value + "\n";
			el += "<a class=\"close\">x</a>\n";
			el += "<input type=\"hidden\" style=\"display:none;\" value=\""+value+"\" name=\"" + tag_input.parents('.tagit').attr('id');
			el += "[" + (label ? "id" : "new") + "][]\">\n";
			el += "</li>\n";
			var li_search_tags = tag_input.parent();
			$(el).insertBefore (li_search_tags);
			tag_input.val("");
		}
	};

	String.prototype.trim = function() {
		return this.replace(/^\s+|\s+$/g,"");
	};

})(jQuery);
