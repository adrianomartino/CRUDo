<script>
		var topContentAreaScript = '<?php echo AJAX_PAGES?>printr.php?ajax=true';
		var bottomContentAreaScript = '<?php echo AJAX_PAGES?>ristoranti.php';
		
		function updateTopTabs(){
			$('#top_content_area').addClass('waiter');
			
			$('#top_content_area').data('infiniteScrollPage', 0);
			
			$('#top_content_area').load(topContentAreaScript, {
					page: 0,
					top_tab: $('#top_tabs .selected').text(),
					left_tab: $('#left_tab_menu .selected').text()
				}, function(){
					$('#top_content_area').removeClass('waiter');
				}
			);
			
			$('#top_content_area').scrollLoad({
				url : topContentAreaScript,

				getData : function() {
					$(this).data('infiniteScrollPage', $(this).data('infiniteScrollPage')+1);
					return {
						page : $(this).data('infiniteScrollPage'),
						top_tab: $('#top_tabs .selected').text(),
						left_tab: $('#left_tab_menu .selected').text()
					};
				},
				start : function() {
					$('#top_content_area').addClass('waiter');
				},
				ScrollAfterHeight : 95,

				onload : function(data) {
					$(this).append(data);
					$('#top_content_area').removeClass('waiter');
				},

				continueWhile: function(resp) {
					if(resp.length == '') {
						return false;
					}
					return true;
				}
			});
		};
		
		function updateBottomArea(){
			$('#bottom_content_area').addClass('waiter')
				.load(bottomContentAreaScript, $('#ristoranti_search_form').serialize(), function(){
					$('#bottom_content_area').removeClass('waiter');
				}
			);
			
			return false;
		}
		
		$(document).ready(function(){
			$('body').removeClass('no-js').addClass('has-js');
			
			$('#top_tabs .tab').click(function(){
				if(!$(this).hasClass('selected') && !$('#top_content_area').hasClass('waiter')){
					$('#top_tabs .selected').removeClass('selected');
					
					$(this).addClass('selected');
					updateTopTabs();
				}
				return false;
			});
			
			$('#left_tab_menu .tab').click(function(){
				if(!$(this).hasClass('selected') && !$('#top_content_area').hasClass('waiter')){
					$('#left_tab_menu .selected').removeClass('selected');
					
					$(this).addClass('selected');
					updateTopTabs();
				}
				return false;
			})
			
			$('#ristoranti_search_form').submit(updateBottomArea);
			
			$('#filters select').change(updateBottomArea);
			
			$('#filters select').selectmenu({width: 147});
		});
		
		
	</script>