(function($){
	$(document).ready(function(){
		if($('.wp-editor-container').length > 0) {
			if(typeof fbuilderSwitch == 'undefined') fbuilderSwitch = 'off';
			var html = '<a href="#" id="fbuilder_switch" class="wp-switch-editor switch-fbuilder'+(fbuilderSwitch == 'on' ? ' active' : '')+'">Frontend Builder</a>';
			$('#wp-content-editor-tools').prepend(html);
			
			html = '';
			html += '<div class="fbuilder_editor_mask'+(fbuilderSwitch == 'on' ? ' active' : '')+'">';
			html += '<div class="fbuilder_editor_border">';
			html += '<div class="fbuilder_editor_content">';
			html += '<div class="fbuilder_editor_buttons">';
			html += '<a href="'+ajaxurl+'?action=fbuilder_edit&p='+$('#post_ID').val()+'" id="fbuilder_edit_page" class="fbuilder_button_primary">Edit page</a>';
			html += '<a href="'+ajaxurl+'?action=fbuilder_switch&p='+$('#post_ID').val()+'&sw=off" id="fbuilder_deactivate" class="fbuilder_button">Deactivate</a>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
		
			$('.wp-editor-container').append(html);
			
			$('#fbuilder_switch').click(function(e){
				e.preventDefault();
				if(!$(this).hasClass('active')) {
					$('#publishing-action .spinner').show();
					$.get(ajaxurl+'?action=fbuilder_switch&p='+$('#post_ID').val()+'&sw=on', function(response) {
						if(response == 'success') {
							$('#fbuilder_switch').addClass('active').blur();
							$('.fbuilder_editor_mask').addClass('active');
							$('#wp-admin-bar-fbuilder_edit a').attr('href', ajaxurl+'?action=fbuilder_edit&p='+$('#post_ID').val());
							$('#publishing-action .spinner').hide();
						}
						else {
							alert(response);
							$('#publishing-action .spinner').hide();
						}
					});
				}
			});
			
			$('#fbuilder_deactivate').click(function(e){
				e.preventDefault();
				$('#publishing-action .spinner').show();
				$.get($(this).attr('href'), function(response){
					$('#fbuilder_switch').removeClass('active');
					$('.fbuilder_editor_mask').removeClass('active');
					$('#wp-admin-bar-fbuilder_edit a').attr('href', ajaxurl+'?action=fbuilder_edit&p='+$('#post_ID').val()+'&sw=on');
					$('#publishing-action .spinner').hide();
				});
			});
			
			$('#content-tmce, #content-html').click(function(){
				if($('#fbuilder_switch').hasClass('active')) {
					$('#fbuilder_deactivate').trigger('click');
				}
			});
		}
	});
})(jQuery)