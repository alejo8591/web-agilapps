(function($){
	$(document).ready(function(){
		fbuilderControlsInit();
		fbuilderRefreshControls();
	
	});
	
	var keyTimeout;
	/*
	function fbuilderContolChange($control, timeout = false) {
		var name = $control.attr('name');
		var modid = parseInt($('.fbuilder_shortcode_menu').attr('data-modid'));
		var $module = $('.fbuilder_module[data-modid='+modid+']');
		if(name.search('fsort') == -1) {
			fbuilder_items['items'][modid]['options'][name] = $control.val();
		}
		else {
			var subname = name.substr(name.search('-')+1);
			name = subname.substr(subname.search('-')+1);
			var sortid = parseInt(subname.substr(0,subname.search('-')));
			var $parent = $control.parent();
			while(!$parent.hasClass('fbuilder_sortable_item')) $parent = $parent.parent();
			sortname = $parent.attr('data-sortname');
			fbuilder_items['items'][modid]['options'][sortname]['items'][sortid][name] = $control.val();
		}
		if(timeout) {
			window.clearTimeout(keyTimeout);
			keyTimeout = window.setTimeout(function(){
				$('.fbuilder_shortcode_menu').trigger('fchange');
			},1000);
		}
		else {
			$('.fbuilder_shortcode_menu').trigger('fchange');
		}
		
		fbuilderRefreshControls();
	}*/
	
	/*  Refresh Frontend Builder Controls  */

	function fbuilderRefreshControls() {
		
		
		/* UI slider for number controles */		
		$( ".fbuilder_number_bar" ).each(function(){
			if(!$(this).hasClass('ui-slider')) {
				var min = parseInt($(this).attr('data-min'));
				var max = parseInt($(this).attr('data-max'));
				var std = parseInt($(this).attr('data-std'));
				var unit = $(this).attr('data-unit');
				 
				$(this).slider({
					min: min,
					max: max,
					value: std,
					range: "min",
					slide: function( event, ui ) {
						$(this).parent().find( ".fbuilder_number_amount" ).val( ui.value + ' ' + unit);
					},
					change : function( event, ui) {
						var $input = $(this).parent().find( ".fbuilder_number_amount" );
						//fbuilderContolChange($input);
						
					}
				});
			}
		});
		
		/* Sortable init on new controles */
		$('.fbuilder_sortable').each(function(){
			if(!$(this).hasClass('ui-sortable')) {
				$(this).sortable({
					items: '.fbuilder_sortable_item',
					handle : '.fbuilder_sortable_handle',
					stop : function(event,ui) {
						var name = $(this).parent().attr('data-name');
						var itemId = parseInt($('.fbuilder_shortcode_menu').attr('data-modid'));
						fbuilder_items['items'][itemId]['options'][name]['order'] = {};
						$(this).children('.fbuilder_sortable_item').each(function(index){
							fbuilder_items['items'][itemId]['options'][name]['order'][index] = parseInt($(this).attr('data-sortid'));
						});
						$('.fbuilder_shortcode_menu').trigger('fchange');
					}
				});
			}	
		});
		
		
	   
		
		var modid = parseInt($('.fbuilder_shortcode_menu').attr('data-modid'));
		var $module = $('.fbuilder_module[data-modid='+modid+']');
		$('.fbuilder_hidable').each(function(){
			var hideBool = false;
			var hideName = $(this).find('.fbuilder_hidable_control').attr('name');
			
			var hideArr = hideIfs[hideName];
			for (var x in hideArr) {
				var $hideObj = $('.fbuilder_controls_wrapper').find('[name='+x+']');
				if(hideArr[x].indexOf($hideObj.val()) != -1) {
					hideBool = true;
					break;
				}
			}
			if(hideBool) $(this).hide();
			else $(this).show();
		});
		
		/* mCustomScrollbar when new items are created */

		$('.fbuilder_select ul').each(function(){
			if(!$(this).hasClass('fmCustomScrollbar')) {
				$(this).fmCustomScrollbar({mouseWheelPixels:150});
			}
			else {
				$(this).fmCustomScrollbar('update');
			}
		});
	}

	/*  Activate Frontend Builder Controls  */

	function fbuilderControlsInit() {
		var ctime;
		/* Shortcode color control */	
		$( '.fbuilder_color' ).each(function(){
			$(this).parent().find('.fbuilder_color_display').css('background', $(this).val());
			$(this).fbiris({
				width:228,
				target:$(this).parent().find('.fbuilder_colorpicker'),
				palettes: ['', '#1abc9c', '#16a085', '#3498db', '#2980b9', '#9b59b6', '#8e44ad', '#34495e', '#2c3e50', '#e67e22', '#d35400', '#e74c3c', '#c0392b', '#ecf0f1', '#bdc3c7', '#ffffff', '#000000'],
				change: function(event, ui) {
				    $(this).parent().find('.fbuilder_color_display').css( 'background-color', ui.color.toString());
					$(this).val(ui.color.toString());
					//fbuilderContolChange($(this), true);
				}
			});
		});
		/* Shortcode select control */
		
		$('.fbuilder_select')
			.live('mouseenter', function(){
				$(this).data('hover',true);
			}).live('mouseleave',function(){
				$(this).data('hover', false);
			});
			
		$('.fbuilder_select span, .fbuilder_select .drop_button').live('click', function(e){
			e.preventDefault();
			$parent = $(this).parent();
			if(!$parent.hasClass('active')) {
				$parent.addClass('active').find('ul, input').show();
			}
			else {
				$parent.removeClass('active').find('ul, input').val('').hide();
			}
			fbuilderRefreshControls();
		});
		$('.fbuilder_select ul a').live('click', function(e){
			e.preventDefault();
			var $parent = $(this).closest('.fbuilder_select');
			var $select = $('select[name='+$parent.attr('data-name')+']');
			$select.val($(this).attr('data-value')).change();
			$parent.find('span').html($(this).html());
			$parent.removeClass('active').find('ul, input').val('').hide();
			$parent.find('ul a.selected').removeClass('selected');
			$(this).addClass('selected');
			fbuilderRefreshControls();
			/*
			fbuilderContolChange($select);
			*/
		});
		
		$('.fbuilder_select input').live('keyup', function(){
			var inValue = $(this).val();
			if(inValue == '') {
				$(this).closest('.fbuilder_select').find('ul li').show();
			}
			else {
				$(this).closest('.fbuilder_select').find('ul li').each(function(){
					if($(this).html().toLowerCase().search(inValue) > -1) {
						$(this).show();
					}
					else {
						$(this).hide();
					}
				});
			}
			$(this).closest('.fbuilder_select').find('ul').fmCustomScrollbar('update');
		});
		$('body').click(function(){
			$('.fbuilder_select.active').each(function(){
				if(!$(this).data('hover')) {
					$(this).removeClass('active').find('ul, input').val('').hide();
				}
			});
		});
		
		
		
		$('.fbuilder_font_select select').live('change', function(){
			var name = $(this).attr('name');
			name = name.substr(0,name.length-12);
			var $style = $('[name="'+name+'_font_style"]');
			var $styleCtrl = $style.closest('.fbuilder_control');
			var $styleUl = $styleCtrl.find('ul');
			var $styleMCSB = $styleCtrl.find('.mCSB_container');
			var $styleSpan = $styleCtrl.find('span:first');
			var font = $(this).val();
			var newOptions = {};
			if(font == 'default')  newOptions = { 'default' : 'Default'};
			else {
				for (var x in fontsObj['items']) {
					font = font.replace(/\+/g, ' ');
					if(fontsObj['items'][x]['family'] == font){
						for (y in fontsObj['items'][x]['variants']) {
							var variant = fontsObj['items'][x]['variants'][y];
							newOptions[variant] = variant.replace('+',' ');
						}
					}
				}
			}
			
			$styleMCSB.empty();
			$style.empty(); // remove old options
			var firstOpt = true;
			$.each(newOptions, function(key, value) {
				$style.append($('<option value="'+key+'">'+value+'</option>'));
				$styleMCSB.append($('<li><a'+(firstOpt ? ' class="selected"' : '')+' data-value="'+key+'">'+value+'</a></li>'));
				if(firstOpt){
					$styleSpan.html(value);
					firstOpt = false;
				}
			});
			$styleUl.fmCustomScrollbar('update');
		});
		
		$('.fbuilder_save').live('click', function(e){
			e.preventDefault();
			var json = {};
			$('.fbuilder_controls_wrapper input[name], .fbuilder_controls_wrapper select[name], .fbuilder_controls_wrapper textarea[name]').each(function(){
				json[$(this).attr('name')] = $(this).val();
			});
			var data = {
				action : 'fbuilder_admin_save',
				json : json
			}
			var $this = $(this);
			if(typeof window.fbuilder_saveajax != 'undefined') {
				window.fbuilder_saveajax.abort();
				$('.inProcess').next().stop(true).show().animate({'opacity' : '0'});
				$('.inProcess').stop(true).animate({paddingRight : 20, paddingLeft:20},200).removeClass('inProcess');
			}
			$this.stop(true).animate({paddingRight : 28, paddingLeft:15},200).addClass('inProcess');
			$this.next().stop(true).show().animate({'opacity' : '1'});
			window.fbuilder_saveajax = $.post(ajaxurl, data, function(response) {
				console.log(response);
				$this.stop(true).animate({paddingRight : 20, paddingLeft:20},200);
				$this.next().stop(true).show().animate({'opacity' : '0'});
			});
		});
		/* Shortcode input/textarea control 
		
		$('.fbuilder_shortcode_menu input, .fbuilder_shortcode_menu textarea').live('keyup', function(){
			fbuilderContolChange($(this), true);
		});
		*/
		
		/* Shortcode checkbox control */
		$('.fbuilder_checkbox').live('click', function(){
			var $input = $(this).parent().find('.fbuilder_checkbox_input');
			if($(this).hasClass('active')) {
				$input.val('false');
				$(this).removeClass('active');
			}
			else {
				$input.val('true');
				$(this).addClass('active');
			}
			// fbuilderContolChange($input);
			
		});
		
		/* Shortcode icon control */
		
		$('.fbuilder_icon_left').live('click', function(e){
			e.preventDefault();
			var $input = $(this).parent().find('input');
			var val = parseInt($input.attr('data-current'));
			if (val == parseInt($input.attr('data-min'))) val = fbuilder_icons.length - 1;
			else val--;
			$input.val(fbuilder_icons[val]).attr('data-current', val);
			$(this).parent().find('.fbuilder_icon_holder i').attr('class',fbuilder_icons[val] + ' fawesome');
			//fbuilderContolChange($input, true);
		});
		
		$('.fbuilder_icon_right').live('click', function(e){
			e.preventDefault();
			var $input = $(this).parent().find('input');
			var val = parseInt($input.attr('data-current'));
			if (val == fbuilder_icons.length-1) val = parseInt($input.attr('data-min'));
			else val++;
			$input.val(fbuilder_icons[val]).attr('data-current', val);
			$(this).parent().find('.fbuilder_icon_holder i').attr('class',fbuilder_icons[val] + ' fawesome');
			//fbuilderContolChange($input, true);
		});
		
		$('.fbuilder_icon_pick').live('click', function(e){
			e.preventDefault();
			var $drop = $(this).parent().find('.fbuilder_icon_dropdown');
			if($(this).hasClass('fbuilder_gradient')) {
				$(this).removeClass('fbuilder_gradient').addClass('fbuilder_gradient_primary');
				$drop.show().addClass('active').fmCustomScrollbar('update');
				$(this).parent().find('.fbuilder_icon_drop_arrow').show();
			}
			else {
				$(this).addClass('fbuilder_gradient').removeClass('fbuilder_gradient_primary');
				$drop.hide().addClass('active');
				$(this).parent().find('.fbuilder_icon_drop_arrow').hide();
			}
		});
		$('.fbuilder_icon_dropdown a').live('click', function(e){
			e.preventDefault();
			var $parent = $(this).parent();
			while(!$parent.hasClass('fbuilder_control')) {
				$parent = $parent.parent();
			}
			var $input = $parent.find('input');
			var val = parseInt($(this).attr('href'));
			$input.val(fbuilder_icons[val]).attr('data-current',val);
			$parent.find('.fbuilder_icon_holder i').attr('class',fbuilder_icons[val] + ' fawesome');
			//fbuilderContolChange($input);
		});
		
		
		$('.fbuilder_icon_dropdown, .fbuilder_icon_pick')
			.live('mouseenter', function(){
				$(this).data('hover',true);
			}).live('mouseleave',function(){
				$(this).data('hover', false);
			});
		
		$('body').click(function(){
			$('.fbuilder_icon_dropdown.active').each(function(){
				if(!$(this).data('hover') && !$(this).parent().find('.fbuilder_icon_pick').data('hover')) {
					$(this).removeClass('active').hide();
					$(this).parent().find('.fbuilder_icon_drop_arrow').hide();
					$(this).parent().find('.fbuilder_icon_pick').addClass('fbuilder_gradient').removeClass('fbuilder_gradient_primary');
				}
			});
		});
		
		
		/* Shortcode image control */
		
		var thickboxId =  '';
		$('.fbuilder_image_button').live('click', function(e) {
			e.preventDefault();
			thickboxId = '#'+ $(this).attr('data-input') + '_holder';
			formfield = $(this).attr('data-input');
			var mediaurl = ajaxurl.substr(0,ajaxurl.indexOf('admin-ajax'))+'media-upload.php';
			tb_show('', mediaurl+ '?type=image&amp;width=620&amp;height=420&amp;TB_iframe=true');
			return false;
		});
		
		$('.fbuilder_image_input span').live('click', function(){
			$(this).hide();
			$(this).parent().find('input').focus();
		});
		
		$('.fbuilder_image_input input').live('focusout', function(){
			if($(this).val() == '') {
				$(this).parent().find('span').show();
			}
		});
		
		$('.fbuilder_image_input input').live('keyup', function(){
			thickboxId = '#' + $(this).attr('id') + '_holder';
			imgurl = $(this).val();
			var ww = $(thickboxId).width();
			var hh = $(thickboxId).height();
			if ($(thickboxId).hasClass('fbuilder_background_holder')) {
				$(thickboxId).css('background','url('+imgurl+') repeat');
			}
			else {
				$(thickboxId).html('<img style="max-width:' + ww + 'px; max-height:' + hh + 'px;" src="' + imgurl + '" alt="" />');
			}
			//fbuilderContolChange($(this), true);
		});
		
		window.send_to_editor = function(html) {
			var img_pos=html.indexOf('<img');
			if (img_pos>0) html=html.substring(img_pos);
			img_pos=html.indexOf('>');
			if (img_pos>0) html=html.substring(0, img_pos+1);
			while (html.indexOf('\\"')>-1) html=html.replace('\\"','"');
			var $jhtml=$(html);
			var imgurl = $jhtml.attr('src');
			
			$('#' + formfield).parent().find('span').hide();
			$('#' + formfield).val(imgurl);
			var ww = $(thickboxId).width();
			var hh = $(thickboxId).height();
			if ($(thickboxId).hasClass('fbuilder_background_holder')) {
				$(thickboxId).css('background','url('+imgurl+') repeat');
			}
			else {
				$(thickboxId).html('<img style="max-width:' + ww + 'px; max-height:' + hh + 'px;" src="' + imgurl + '" alt="" />');
			}
			tb_remove();
			//fbuilderContolChange($('#' + formfield));
		}
		
		
		/* Shortcode sortable control */
		
		$('.fbuilder_sortable_add').live('click', function(e){
			e.preventDefault();
			var html = '';
			var name = $(this).parent().attr('data-name');
			var item_name = $(this).parent().attr('data-iname');
			var $smenu = $(this).parent().parent();
			while(!$smenu.hasClass('fbuilder_shortcode_menu'))
				$smenu = $smenu.parent();
			var itemId = parseInt($smenu.attr('data-modid'));
			var itemSh = $smenu.attr('data-shortcode');
			console.log(fbuilder_shortcodes);
			console.log(fbuilder_items);
			
			var shortcodeJSON = $.extend({},fbuilder_shortcodes[itemSh]['options'][name]);
			if(typeof fbuilder_items['items'][itemId]['options'][name]['items'] == 'undefined') {
				fbuilder_items['items'][itemId]['options'][name]['items'] = {};
				fbuilder_items['items'][itemId]['options'][name]['order'] = {};
			}
			var count = 0;
			while(typeof fbuilder_items['items'][itemId]['options'][name]['items'][count] != 'undefined' && fbuilder_items['items'][itemId][name]['items'][count] != '')
				count++;
				
			var pos = 0;
			while(typeof fbuilder_items['items'][itemId]['options'][name]['order'][pos] != 'undefined')
				pos++;
			fbuilder_items['items'][itemId]['options'][name]['order'][pos] = count;
			
			html += '<div class="fbuilder_sortable_item fbuilder_collapsible" data-sortid="'+count+'" data-sortname="'+name+'"><div class="fbuilder_gradient fbuilder_sortable_handle fbuilder_collapsible_header">'+item_name+' '+count+' - <span class="fbuilder_sortable_delete">delete</span><span class="fbuilder_collapse_trigger">+</span></div><div class="fbuilder_collapsible_content">';
			console.log(shortcodeJSON);
			fbuilder_items['items'][itemId]['options'][name]['items'][count] = {};
			for (var x in shortcodeJSON['options']) {
				var newControl = new fbuilderControl('fsort-'+count+'-'+x,shortcodeJSON['options'][x]);
				html += newControl.html();
				
				fbuilder_items['items'][itemId]['options'][name]['items'][count][x] = (typeof shortcodeJSON['options'][x]['std'] != 'undefined' ? shortcodeJSON['options'][x]['std'] : '');
			}
			html +='</div></div>';
			$(this).parent().find('.fbuilder_sortable').append(html);
			fbuilderRefreshControls();
			$('.fbuilder_shortcode_menu').trigger('fchange');
		});
		
		$('.fbuilder_sortable_delete').live('click', function(){
			var $sortitem = $(this).parent().parent();
			var id = parseInt($sortitem.attr('data-sortid'));
			var name = $sortitem.attr('data-sortname');
			var itemId = parseInt($('.fbuilder_shortcode_menu').attr('data-modid'));
			var $sortable = $sortitem.parent();
			$sortitem.remove();
			console.log(id, name);
			delete fbuilder_items['items'][itemId]['options'][name]['items'][id];
			delete fbuilder_items['items'][itemId]['options'][name]['order'];
			fbuilder_items['items'][itemId][name]['order'] = {};
			$sortable.children('.fbuilder_sortable_item').each(function(index){
				fbuilder_items['items'][itemId]['options'][name]['order'][index] = parseInt($(this).attr('data-sortid'));
			});
			$('.fbuilder_shortcode_menu').trigger('fchange');
		});
		
		
		/* Shortcode collapsible control */
		
		$('.fbuilder_collapsible_header').live('click', function(){
			var $content = $(this).parent().children('.fbuilder_collapsible_content');
			if(!$(this).hasClass('active')) {
				$(this).addClass('active').find('.fbuilder_collapse_trigger').html('-');
				$content.show();
			}
			else {
				$(this).removeClass('active').find('.fbuilder_collapse_trigger').html('+');
				$content.hide();
			}
			fbuilderRefreshControls();
			
		});
		
		/* Shortcode colorpicker control */
		
		$( '.fbuilder_color' ).live('focus', function(){
			$(this).parent().find('.fbuilder_colorpicker').addClass('active').show();
			fbuilderRefreshControls();
		}).live('mouseenter', function(){
			$(this).parent().find('.fbuilder_colorpicker').data('hover', true);
		}).live('mouseleave', function(){
			$(this).parent().find('.fbuilder_colorpicker').data('hover', false);
		});
		
		$( '.fbuilder_colorpicker' ).live('mouseenter', function(){
			$(this).data('hover', true);
		}).live('mouseleave', function(){
			$(this).data('hover', false);
		});
		
		$('body').click(function(){
			$('.fbuilder_colorpicker.active').each(function(){
				if(!$(this).data('hover')) {
					$(this).removeClass('active').hide();
					fbuilderRefreshControls();
				}
			});
		});
		
		
		/* Shortcode change 
		
		$('.fbuilder_shortcode_menu').live('fchange', function(){
			var id = parseInt($(this).attr('data-modid'));
			var $module = $('.fbuilder_module[data-modid='+id+']');
			var f = fbuilder_items['items'][id]['f'];
			var holder = $module.find('.fbuilder_module_content:first');
			var options = fbuilder_items['items'][id]['options'];
			fbuilderGetShortcode(f, holder, options);
		});
		*/
		$('.ui-draggable').live('click', function(e){
			e.preventDefault();
		});
		
	}
	
})(jQuery);