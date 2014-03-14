(function($){
	var fbuilder_shortcode_sw = false;
	$(document).ready(function(){
		if(fbuilder_sw == 'on' && fbuilder_user) {
			var html = '<div id="fbuilder_main_menu" class="fbuilder_controls_wrapper"><formautocomplete="off"><div class="fbuilder_menu_inner">';
			
			for (var x in fbuilder_main_menu) {
				if(x == 'fbuilder_layout') {
					if(typeof fbuilder_items['sidebar'] != 'undefined' && fbuilder_items['sidebar']['active'] == true)
						fbuilder_main_menu[x]['std'] = fbuilder_items['sidebar']['type'];
				}
				var newControl = new fbuilderControl(x,fbuilder_main_menu[x]);
				html += newControl.html();
			}
			
			html += '</div></form></div>';
			
			html += '<div class="fbuilder_toggle_wrapper"><a class="fbuilder_gradient fbuilder_button fbuilder_toggle_screen" data-width="1200"><i class="icon-desktop fawesome"></i></a><a class="fbuilder_gradient fbuilder_button fbuilder_toggle_screen" data-width="960"><i class="icon-laptop fawesome"></i></a><a class="fbuilder_gradient fbuilder_button fbuilder_toggle_screen" data-width="768"><i class="icon-tablet fawesome"></i></a><a class="fbuilder_gradient fbuilder_button fbuilder_toggle_screen" data-width="340"><i class="icon-mobile-phone fawesome"></i></a><a class="fbuilder_gradient fbuilder_button fbuilder_toggle">Hide builder</a><div style="clear:both;"></div></div>';
			$('#fbuilder_body').css({borderLeftWidth:250});
			$('body').append(html);
		}
		else if(fbuilder_showall && fbuilder_sw == 'on'){
			var html = '<div id="fbuilder_main_menu" class="fbuilder_controls_wrapper"><formautocomplete="off"><div class="fbuilder_menu_inner">';
			
			for (var x in fbuilder_main_menu) {
				if(x == 'fbuilder_layout') {
					if(typeof fbuilder_items['sidebar'] != 'undefined' && fbuilder_items['sidebar']['active'] == true)
						fbuilder_main_menu[x]['std'] = fbuilder_items['sidebar']['type'];
				}
				if(x == 'fbuilder_save_page') {
					fbuilder_main_menu[x]['class'] = 'fbuilder_false_save left'
				}
				var newControl = new fbuilderControl(x,fbuilder_main_menu[x]);
				html += newControl.html();
			}
			
			html += '</div></form></div>';
			
			html += '<div class="fbuilder_toggle_wrapper"><a class="fbuilder_gradient fbuilder_button fbuilder_toggle_screen" data-width="1200"><i class="icon-desktop fawesome"></i></a><a class="fbuilder_gradient fbuilder_button fbuilder_toggle_screen" data-width="960"><i class="icon-laptop fawesome"></i></a><a class="fbuilder_gradient fbuilder_button fbuilder_toggle_screen" data-width="768"><i class="icon-tablet fawesome"></i></a><a class="fbuilder_gradient fbuilder_button fbuilder_toggle_screen" data-width="300"><i class="icon-mobile-phone fawesome"></i></a><a class="fbuilder_gradient fbuilder_button fbuilder_toggle">Hide builder</a><div style="clear:both;"></div></div>';
			
			$('#fbuilder_body').css({borderLeftWidth:0});
			$('body').append(html);
			$('#fbuilder_main_menu').css({left:-250});
		}
		$('#fbuilder_body_frame').ready(function(){
			if(fbuilder_sw == 'on' && (fbuilder_user || fbuilder_showall)) {
				fbuilderIframeInit(this);
			}
		});
	});
	function fbuilderIframeInit($this) {
		if(typeof $this.contentWindow == 'undefined' || typeof $this.contentWindow.jQuery === 'undefined' || typeof $this.contentWindow.jQuery.ui === 'undefined' || typeof $this.contentWindow.jQuery.ui.sortable === 'undefined' || typeof $this.contentWindow.jQuery.ui.draggable === 'undefined') {
			setTimeout(function(){fbuilderIframeInit($('#fbuilder_body_frame')[0])}, 1000);
		}
		else {
			var loc = '',
				win = $this.contentWindow,
	            doc = win.document,
	            body = doc.body;
			win.jQuery(doc).on('click', 'a', function(){
				if(win.jQuery(this).attr('href') != '' && win.jQuery(this).attr('href').substr(0,1) != '#') loc = win.jQuery(this).attr('href');
			});
			$(win).unload(function(){
				if(loc != '' && loc != '#') {
					window.location = loc;
				}
			});
			
			
			
			var $iframe = $($this).contents();
			var $fbMainMenu = $('#fbuilder_main_menu');
			var $fbDraggable = $fbMainMenu.find('.fbuilder_draggable').parent();
				
				fbuilderFrameControls($iframe);
				fbuilderSortableInit(win.jQuery( '#fbuilder_content .fbuilder_row'));
				fbuilderControlsInit(win.jQuery, doc);
				$('#fbuilder_frame_cover').hide();
				if(!fbuilder_user)
					$('.fbuilder_toggle').trigger('click');
		}
		
	}
	
	function fbuilderFrameControls($iframe) {
		$iframe.find('#fbuilder_wrapper .fbuilder_row').each(function(){
			var parentRow = $(this).parent().closest('.fbuilder_row');
			if(parentRow.length <= 0 || (parentRow.closest('#fbuilder_wrapper').length <= 0 && $(this).closest('#fbuilder_wrapper').length > 0)) {
				if(!$(this).hasClass('fbuilder_sidebar'))
					$(this).prepend('<div class="fbuilder_row_controls"><a class="fbuilder_drag_handle" href="#" title="Move"></a><a href="#" class="fbuilder_edit" title="Edit"><a class="fbuilder_clone" href="#" title="Clone"></a><a class="fbuilder_delete" href="#" title="delete"></a></div>');
				else 
					$(this).prepend('<div class="fbuilder_row_controls"><span class="fbuilder_sidebar_label">Sidebar</span></div>');
			}
		});
		
		$iframe.find('#fbuilder_wrapper .fbuilder_column').each(function(){
			var parentCol = $(this).parent().closest('.fbuilder_column');
			if(parentCol.length <= 0 || (parentCol.closest('#fbuilder_wrapper').length <= 0 && $(this).closest('#fbuilder_wrapper').length > 0)) {
				$(this).append('<div class="fbuilder_drop_borders"></div>');
			}
			else if(parentCol.length > 0 && parentCol.closest('#fbuilder_wrapper').length <= 0) {
				$(this).append('<div class="fbuilder_drop_borders"></div>');
			}
		});
		
		$iframe.find('#fbuilder_wrapper .fbuilder_module').each(function(){
			if($(this).parent().closest('.fbuilder_module').length <= 0) {
				$(this).wrapInner('<div class="fbuilder_module_content" />');
				var text = fbuilder_shortcodes[$(this).attr('data-shortcode')]['text'];
				
				$(this).prepend('<div class="fbuilder_module_controls fbuilder_gradient"><span class="fbuilder_module_name">'+text+'</span> <img class="fbuilder_module_loader" src="'+fbuilder_url+'images/save-loader.gif" /><a href="#" class="fbuilder_edit" title="Edit"></a><a href="#" class="fbuilder_clone" title="Clone"></a><a href="#" class="fbuilder_delete" title="delete"></a></div>');
			}
		});
		
		var rows = '<div class="fbuilder_row_holder">'+
		'<a href="#" class="fbuilder_new_row fbuilder_gradient">+ Add new row</a>'+
		'<div class="fbuilder_row_holder_inner">';
		
		for (var x in fbuilder_rows) {
			var newRow = fbuilder_rows[x];
			rows += '<a href="#'+x+'" class="fbuilder_row_button fbuilder_gradient" title="'+newRow.label+'"><img src="'+newRow.image+'" alt="" /></a>';
		}
		
		rows += '<div style="clear:both;"></div></div></div>';
		$iframe.find('#fbuilder_wrapper').addClass('edit').children('#fbuilder_content_wrapper').append(rows);
		
		
		$iframe.find('#fbuilder_content').sortable({
			items : "> div",
			handle : '.fbuilder_row_controls .fbuilder_drag_handle',
			stop : function(event,ui) {
				fbuilder_items['rowOrder'] = [];
				$iframe.find('#fbuilder_content .fbuilder_row').each(function(index){
					fbuilder_items['rowOrder'][index] = parseInt($(this).attr('data-rowid'));
				});
			}
		});
	}
	
	// fbuilderControl Class
	function fbuilderControl(name, values) {
		
		this.name = name;
		this.values = values;
		
		this.html = function(){
			var hideCond = '';
			
			var wrapper = 
				'<div class="fbuilder_control'+(typeof this.values['hide_if'] != 'undefined' ? ' fbuilder_hidable' : '')+'">'+
				(typeof(this.values.label) != 'undefined' ? '<label for="'+this.name+'">'+this.values.label+' </label>' : '')+
				(typeof(this.values.desc) != 'undefined' ? '<span class="fbuilder_desc">('+this.values.desc+')</span>' : '')+
				(typeof(this.values.label) != 'undefined' || typeof(this.values.desc) != 'undefined' ? '<div style="height:8px;"></div>' : '');
			var wrapperClose = '</div>';
			var html = '';	
		
			switch(this.values.type) {
				case 'input' : 
					html += wrapper;
					html += '<div class="fbuilder_input_wrapper"><label class="fbuilder_input_icon" for="'+this.name+'" ></label><input class="fbuilder_input'+(typeof this.values['hide_if'] != 'undefined' ? ' fbuilder_hidable_control' : '')+'" name="'+this.name+'" id="fbuilder_'+this.values.type+'_'+this.name+'" '+(typeof(this.values.std) != 'undefined' && this.values.std != '' ? 'value="'+this.values.std+'"' : '')+'/></div>';
					html += wrapperClose;
					break;
			
				case 'textarea' :
					html += wrapper;
					html += '<textarea class="fbuilder_textarea'+(typeof this.values['hide_if'] != 'undefined' ? ' fbuilder_hidable_control' : '')+'" name="'+this.name+'" id="fbuilder_'+this.values.type+'_'+this.name+'">'+(typeof(this.values.std) != 'undefined' && this.values.std != '' ? this.values.std : '')+'</textarea>';
					html += '<a href="#" class="fbuilder_wp_editor_button fbuilder_gradient_primary fbuilder_button">Open in WP Editor</a><div style="clear:both;"></div>';
					html += wrapperClose;
					break;
				
				case 'checkbox' :
					html += 
						'<div class="fbuilder_control">'+
						'<div class="fbuilder_checkbox'+(typeof(this.values.std) != 'undefined' && this.values.std != '' && this.values.std == 'true' ? ' active' : '')+'"></div>'+
						'<input class="fbuilder_checkbox_input'+(typeof this.values['hide_if'] != 'undefined' ? ' fbuilder_hidable_control' : '')+'" name="'+this.name+'" id="fbuilder_'+this.values.type+'_'+this.name+'" style="display:none;"'+
						(typeof(this.values.std) != 'undefined' && this.values.std == 'true' ? ' value="'+this.values.std+'"' : ' value="false"')+' />'+
						'<div class="fbuilder_checkbox_label">'+
						(typeof(this.values.label) != 'undefined' ? '<label for="'+this.name+'">'+this.values.label+' </label>' : '')+
						(typeof(this.values.desc) != 'undefined' ? '<span class="fbuilder_desc">('+this.values.desc+')</span>' : '')+
						'</div><div style="clear:both;"></div>'+
						'</div>';
					break;
				
				case 'select' :
					var options = this.values.options;
					html += wrapper;
					
					html += '<input class="'+(typeof this.values['hide_if'] != 'undefined' ? 'fbuilder_hidable_control' : '')+(typeof this.values['class'] != 'undefined' ? ' '+this.values['class'] : '')+'" name="'+this.name+'" id="fbuilder_'+this.values.type+'_'+this.name+'" style="display:none;"';
					html += (typeof this.values.std != 'undefined' && this.values.std != '' ? ' value="'+this.values.std+'"' : '');
					
					var visibleSelect = '<div class="fbuilder_select fbuilder_gradient'+(typeof this.values['search'] != 'undefined' && this.values['search'] == 'true' ? ' fbuilder_select_with_search' : '')+(typeof this.values['multiselect'] != 'undefined' && this.values['multiselect'] == 'true' ? ' fbuilder_select_multi' : '')+'" data-name="'+this.name+'">';
						
					var count = 0;
					if(typeof(this.values.multiselect) != 'undefined' && this.values.multiselect == 'true')
						var explVal = this.values.std.split(',');
					for(var x in options) {
						if (count == 0) {
							html += (typeof this.values.std == 'undefined' || this.values.std != '' ? ' value="'+x+'"' : '');
							if(typeof(this.values.multiselect) != 'undefined' && this.values.multiselect == 'true') {
								if(typeof(this.values.std) != 'undefined' && this.values.std != '') {
									visibleSelect += '<span>';
									for(y in explVal) {
										if(y != 0) 
											visibleSelect += ',';
										visibleSelect += options[explVal[y]];
									}
									visibleSelect +='</span>';
								}
								else {
									visibleSelect += '<span>'+options[x]+'</span>';
								}
							}
							else {
								visibleSelect +=
								'<span>'+(typeof(this.values.std) != 'undefined' && this.values.std != '' ? options[this.values.std] : options[x])+'</span>';
							}
							visibleSelect +=
								'<div class="drop_button"></div>'+
								(typeof this.values['search'] != 'undefined' && this.values['search'] == 'true' ? '<input class="fbuilder_select_search" placeholder="Search..." value="" style="display:none" />' : '')+
								'<ul style="display:none">';
							
							
							if(typeof(this.values.multiselect) != 'undefined' && this.values.multiselect == 'true') {
								visibleSelect +=	
								'<li><a href="#" data-value="'+x+'"'+((explVal.indexOf(x) != -1) ? ' class="selected"' : '')+'>'+options[x]+'</a></li>';
							}
							else {
								
								visibleSelect +=	
								'<li><a href="#" data-value="'+x+'"'+((typeof this.values.std == 'undefined' || this.values.std == '' || this.values.std == x) ? ' class="selected"' : '')+'>'+options[x]+'</a></li>';
							}
						}
						else {
							if(typeof(this.values.multiselect) != 'undefined' && this.values.multiselect == 'true') {
								visibleSelect +=	
								'<li><a href="#" data-value="'+x+'"'+((explVal.indexOf(x) != -1) ? ' class="selected"' : '')+'>'+options[x]+'</a></li>';
							}
							else {
								visibleSelect += '<li><a href="#" data-value="'+x+'"'+(this.values.std == x ? ' class="selected"' : '')+'>'+options[x]+'</a></li>';
							}
						}
						count++;
					}
					
					html += ' />';
					visibleSelect +=
						'</ul>'+
						'<div class="clear"></div>'+
						'</div>';
					html += visibleSelect;
					html += wrapperClose;
					
					break;
				
				case 'icon' :
					var dataMin = ((typeof this.values['notNull'] != 'undefined' && this.values['notNull'] == false) ? 0 : 1);
					var current = ((typeof(this.values.std) != 'undefined' && this.values.std != '' && this.values.std != null ) ? this.values.std : fbuilder_icons[dataMin]);
					html += wrapper;
					html += '<input class="'+(typeof this.values['hide_if'] != 'undefined' ? ' fbuilder_hidable_control' : '')+'" type="hidden" name="'+this.name+'" id="fbuilder_'+this.values.type+'_'+this.name+'" data-current="'+fbuilder_icons.indexOf(current)+'" data-min="'+dataMin+'" value="'+current+'" /><div class="fbuilder_icon_holder"><i class="'+current+' fawesome"></i></div><a href="#" class="fbuilder_gradient fbuilder_icon_left"><span></span></a><a href="#" class="fbuilder_gradient fbuilder_icon_right"><span></span></a><a href="#" class="fbuilder_gradient fbuilder_icon_pick">Show all</a>';
					html += '<div style="clear:both;"></div><span class="fbuilder_icon_drop_arrow"></span><div class="fbuilder_icon_dropdown">';
					if(typeof this.values['notNull'] != 'undefined' && this.values['notNull'] == false) {
						html += '<a href="0" title="No icon"><i class="no-icon fawesome"></i></a>';
					}
					for(var x=1; x<fbuilder_icons.length; x++) {
						html += '<a href="'+x+'"><i class="'+fbuilder_icons[x]+' fawesome"></i></a>';
					}
					html += '<div style="clear:both;"></div></div><div style="clear:both;"></div>';
					html += wrapperClose;
					break;
				case 'image' : 
					html += wrapper;
					html += '<div class="fbuilder_image_holder" id="fbuilder_'+this.values.type+'_'+this.name+'_holder">'+(typeof(this.values.std) != 'undefined' && this.values.std != '' ? '<img src="'+this.values.std+'" alt="" />' : '')+'</div>';
					html += '<div class="fbuilder_image_input"><input class="fbuilder_input'+(typeof this.values['hide_if'] != 'undefined' ? ' fbuilder_hidable_control' : '')+'" name="'+this.name+'" id="fbuilder_'+this.values.type+'_'+this.name+'" value="'+(typeof(this.values.std) != 'undefined' && this.values.std != '' ? this.values.std+'" />' : '" /><span>Enter image url...</span>')+'</div>';
					html += '<a html="'+this.name+'" class="fbuilder_image_button fbuilder_gradient_primary" data-input="fbuilder_'+this.values.type+'_'+this.name+'">Upload</a>';
					html += '<div style="clear:both;"></div>';
					html += wrapperClose;
					break;
				case 'shortcode-holder' :
					html += wrapper;
					html += '<div class="fbuilder_draggable_holder">';
					
					for (var x in fbuilder_shortcodes) {
						var newControl = new fbuilderControl(x,fbuilder_shortcodes[x]);
						html += newControl.html();
					}
					
					html += '</div>';
					html += wrapperClose;
				
					break;
				
				case 'draggable' :
					html += '<div class="fbuilder_draggable" data-shortcode="'+this.name+'"><span class="shortcode_icon">'+(typeof this.values.icon != 'undefined' && this.values.icon != '' ? '<img src="'+this.values.icon+'" alt="" />' : '<img src="'+fbuilder_url+'images/icons/11.png" alt="" />')+'</span>'+this.values.text+'<span class="draggable_icon"></span></div>';
					break
				
				case 'button' :
					var cl = (typeof this.values['class'] != 'undefined' && this.values['class'] != '' ? this.values['class'] : '');
					var href = (typeof this.values['href'] != 'undefined' && this.values['href'] != '' ? this.values['href'] : '#');
					var id = (typeof this.values['id'] != 'undefined' && this.values['id'] != '' ? ' id="'+this.values['id']+'"' : '');
					var style = (this.values['style'] == 'primary' ? 'fbuilder_gradient_primary' : 'fbuilder_gradient');
					var align = (this.values['align'] == 'right' ? ' style="float:right;"' : '');
					
					html += '<a'+id+' href="'+href+'" class="'+style+' fbuilder_button '+cl+'"'+align+'>'+this.values['label']+'</a>'+(typeof this.values['loader'] != 'undefined' && this.values['loader'] == 'true' ? '<img src="'+fbuilder_url+'images/save-loader.gif" class="fbuilder_save_loader" alt="" />' : '')+(this.values['clear'] != 'false' ? '<div style="clear:both;"></div>' : '');
					break;
				
				case 'number' :
					var min = (typeof this.values['min'] != 'undefined' && this.values['min'] != '' ? parseInt(this.values['min']) : 0);
					var max = (typeof this.values['max'] != 'undefined' && this.values['max'] != '' ? parseInt(this.values['max']) : 100);
					var std = (typeof this.values['std'] != 'undefined' && this.values['std'] != '' ? parseInt(this.values['std']) : 0);
					var step = (typeof this.values['step'] != 'undefined' && this.values['step'] != '' ? parseInt(this.values['step']) : 1);
					var unit = (typeof this.values['unit'] != 'undefined' && this.values['unit'] != '' ? this.values['unit'] : '');
					var maxStr = ''+max;
					
					html += wrapper;
					html += '<div class="fbuilder_number_bar" data-min="'+min+'" data-max="'+max+'" data-std="'+std+'" data-step="'+step+'" data-unit="'+unit+'"></div><input class="fbuilder_number_amount'+(typeof this.values['hide_if'] != 'undefined' ? ' fbuilder_hidable_control' : '')+'" name="'+this.name+'" id="fbuilder_'+this.values.type+'_'+this.name+'" value="'+std+' '+unit+'"/><div style="clear:both;"></div>';
					html += wrapperClose;
					break;
				
				case 'color' : 
					html += wrapper;
					html += '<div class="fbuilder_color_wrapper">';
					html += '<input class="fbuilder_color fbuilder_input'+(typeof this.values['hide_if'] != 'undefined' ? ' fbuilder_hidable_control' : '')+'" name="'+this.name+'" id="fbuilder_'+this.values.type+'_'+this.name+'" '+(typeof(this.values.std) != 'undefined' && this.values.std != '' ? 'value="'+this.values.std+'"' : '')+'/>';
					html += '<div class="fbuilder_color_display"></div><div class="fbuilder_colorpicker"></div>';
					html += '</div>';
					html += wrapperClose;
					break;
			
				case 'sortable' :
					var item_name = (typeof this.values['item_name'] != 'undefined' && this.values['item_name'] != '' ? this.values['item_name'] : 'item');
					html += wrapper;
					html += '<div class="fbuilder_sortable_holder" data-name="'+this.name+'" data-iname="'+item_name+'" id="fbuilder_'+this.values.type+'_'+this.name+'">';
					html += '<div class="fbuilder_sortable">';
					
					
					if(typeof this.values['std'] != 'undefined' && this.values['std'] != '') {
						if(typeof this.values['std']['order'] != 'undefined' && this.values['std']['order'] != '' && this.values['std']['order'] != {}) {
							for(var x in this.values['std']['order']) {
								var sortid = this.values['std']['order'][x];
								html += '<div class="fbuilder_sortable_item fbuilder_collapsible" data-sortid="'+sortid+'" data-sortname="'+this.name+'"><div class="fbuilder_gradient fbuilder_sortable_handle fbuilder_collapsible_header">'+item_name+' '+sortid+' - <span class="fbuilder_sortable_delete">delete</span><span class="fbuilder_collapse_trigger">+</span></div><div class="fbuilder_collapsible_content">';
								
								var controlObj = $.extend(true, {}, this.values['options']);
								for (var y in controlObj) {
									if(typeof this.values['std']['items'][sortid][y] != 'undefined') {
										controlObj[y]['std'] = this.values['std']['items'][sortid][y];
									}
									var newControl = new fbuilderControl('fsort-'+sortid+'-'+y,controlObj[y]);
									html += newControl.html();
								}
								html +='</div></div>';
							}
						}
					}
					
					
					
					html += '</div>';
					html += '<a href="#" class="fbuilder_sortable_add fbuilder_gradient_primary fbuilder_button">+ Add new '+item_name+'</a>';
					html += '<div style="clear:both;"></div>';
					html += '</div>';
					html += wrapperClose;
					break;
			}
			
			return html;
		}
		
	}
	
	
	/*  Ajax shortcode gathering  */
	window.fbuilder_shajax = {}
	function fbuilderGetShortcode(f,holder,options) {
		holder.closest('.fbuilder_module').find('.fbuilder_module_loader').show();
		var data = {
			action : 'fbuilder_shortcode',
			f : f
		}
		if(typeof options !== 'undefined') {
			data.options = JSON.stringify(options);
		}
		var modid = holder.closest('.fbuilder_module').attr('data-modid');
		if(typeof window.fbuilder_shajax[modid] != 'undefined') window.fbuilder_shajax[modid].abort();
		window.fbuilder_shajax[modid] = $.post(ajaxurl, data, function(response) {
			holder.html(response);
			holder.closest('.fbuilder_module').trigger('refresh');
			holder.closest('.fbuilder_module').find('.fbuilder_module_loader').hide();
		});
	}
	
	var keyTimeout = {};
	function fbuilderContolChange($jq, $control, timeout) {
		var name = $control.attr('name');
		$menu = $('.fbuilder_shortcode_menu:first');
		if($menu .length > 0) {
			var modid = parseInt($menu.attr('data-modid'));
			if(name.search('fsort') == -1) {
				if(!$menu.hasClass('fbuilder_rowedit_menu')) {
					fbuilder_items['items'][modid]['options'][name] = $control.val();
				}
				else {
					if(typeof fbuilder_items['rows'][modid]['options'] == 'undefined') fbuilder_items['rows'][modid]['options'] = {};
					fbuilder_items['rows'][modid]['options'][name] = $control.val();
				}
			}
			else {
				var subname = name.substr(name.search('-')+1);
				name = subname.substr(subname.search('-')+1);
				var sortid = parseInt(subname.substr(0,subname.search('-')));
				var $parent = $control.closest('.fbuilder_sortable_item');
				sortname = $parent.attr('data-sortname');
				if(!$menu.hasClass('fbuilder_rowedit_menu')) {
					fbuilder_items['items'][modid]['options'][sortname]['items'][sortid][name] = $control.val();
				}
				else {
					if(typeof fbuilder_items['rows'][modid]['options'] == 'undefined') fbuilder_items['rows'][modid]['options'] = {};
					fbuilder_items['rows'][modid]['options'][sortname]['items'][sortid][name] = $control.val();
				}
				
			}
			if(typeof keyTimeout[modid] !== 'undefined') {
				window.clearTimeout(keyTimeout[modid]);
				keyTimeout[modid] = window.setTimeout(function(){
					$menu.trigger('fchange');
				},300);
			}
			else {
				$menu.trigger('fchange');
			}
		}
		fbuilderHideControls($control);
		fbuilderRefreshControls($jq, $control)
	}
	
	function fbuilderRowChange($row, options) {
		for(var x in options) {
			switch(x) {				
				case 'padding_top':
					$row.css('padding-top',parseInt(options[x])+'px'); 
					break;
				
				case 'padding_bot':
					$row.css('padding-bottom',parseInt(options[x])+'px');
					break;
				
				case 'back_type' :
					if(options[x] == 'parallax') 
						$row.addClass('fbuilder_row_parallax');
					else
						$row.removeClass('fbuilder_row_parallax');
					break;
					
				case 'back_color' :
					if(options[x] == '') 
						$row.css('background-color','transparent');
					else
						$row.css('background-color',options[x]);
					break;
				
				case 'back_image' :
					if(options[x] == '') 
						$row.css('background-image','none');
					else
						$row.css('background-image','url('+options[x]+')');
					break;
				case 'back_repeat' :
					if(options[x] == 'true') 
						$row.css('background-repeat','repeat');
					else
						$row.css('background-repeat','no-repeat');
					break;
				
				case 'column_padding' :
					$row.children('div').children('.fbuilder_column').children('div:first-child').css('padding',parseInt(options[x])+'px');
					break;
				
				case 'column_back' :
					if(typeof options['column_back_opacity'] == 'undefined') {
						if(options[x] == '')
							$row.children('div').children('.fbuilder_column').children('div:first-child').css('background','transparent');
						else
							$row.children('div').children('.fbuilder_column').children('div:first-child').css('background',options[x]);
					}
					else {
					    var hex = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(options[x]);
					    if(hex){
					        var r = parseInt(hex[1], 16);
					        var g = parseInt(hex[2], 16);
					        var b = parseInt(hex[3], 16);
							$row.children('div').children('.fbuilder_column').children('div:first-child').css('background','rgba('+r+','+g+','+b+','+(parseInt(options['column_back_opacity'])/100)+')');
					    }
						else {
							$row.children('div').children('.fbuilder_column').children('div:first-child').css('background','transparent');
						}
						
					}
			}
		}	
	}
	
	function fbuilderCreateRowMenu(rowId, $item) {
			
		var rowJSON = $.extend(true, {},fbuilder_row_controls);	
		var html = '';
		for (var x in rowJSON) {
			if(typeof(fbuilder_items['rows'][rowId]['options']) != "undefined" && typeof(fbuilder_items['rows'][rowId]['options'][x]) != "undefined") {
				rowJSON[x]['std'] = fbuilder_items['rows'][rowId]['options'][x];
			}
			var newControl = new fbuilderControl(x,rowJSON[x]);
			html += newControl.html();
		}
			
		return html;
	}
	
	function fbuilderCreateShortcodeMenu(itemId,$item) {
			
		var shortcodeJSON = $.extend(true, {},fbuilder_shortcodes[$item.attr('data-shortcode')]);	
		var html = '';
		for (var x in shortcodeJSON['options']) {
			if(typeof(fbuilder_items['items'][itemId]['options'][x]) != "undefined") {
				shortcodeJSON['options'][x]['std'] = fbuilder_items['items'][itemId]['options'][x];
			}
			var newControl = new fbuilderControl(x,shortcodeJSON['options'][x]);
			html += newControl.html();
		}
			
		return html;
	}
	
	function fbuilderLoadContent(content) {
		var items = $.extend(true, {}, content);
		var output = '';
		var html = '';
		if(!$.isEmptyObject(items)) {
			if(typeof items['sidebar'] != 'undefined' && items['sidebar']['active']) {
				var sidebar = items['sidebar']['type'];
				html = '<div class="fbuilder_sidebar fbuilder_'+sidebar+' fbuilder_row" data-rowid="sidebar"><div class="fbuilder_column">';
				for(var x in items['sidebar']['items']) {
					if(typeof items['items'][items['sidebar']['items'][x]] != 'undefined' && items['items'][items['sidebar']['items'][x]] != null) {
						html += '<div class="fbuilder_module" data-shortcode="'+items['items'][items['sidebar']['items'][x]]['slug']+'" data-modid="'+items['sidebar']['items'][x]+'">';
						html += '</div>';
					}
				}
				html += '</div><div style="clear:both;"></div></div>';
			}
			
		}
		output += html+
			'<div id="fbuilder_content_wrapper"'+(sidebar != false ? ' class="fbuilder_content_'+sidebar+'"' : '')+'>'+
				'<div id="fbuilder_content">';

		if(!$.isEmptyObject(items)) {
			
			for(var rowId = 0; rowId<items['rowCount']; rowId++) {
				if(typeof items['rowOrder'] != 'undefined')
					var row = items['rowOrder'][rowId];
				else 
					var row = null;
				if(row != null) {
					var current = items['rows'][row];
					html = fbuilder_rows[current['type']]['html'];
					
					html = html.replace('%1$s', row);
					var rowInterface = '<div class="fbuilder_row_controls"><a href="#" class="fbuilder_drag_handle" title="Move"></a><a href="#" class="fbuilder_edit" title="Edit"></a><a href="#" class="fbuilder_clone" title="Clone"></a><a href="#" class="fbuilder_delete" title="delete"></a></div>';
					html = html.replace('%2$s', rowInterface);
					
					
					
					for( var colId in current['columns']) {
						columnInterface = '<div class="fbuilder_droppable">';
						for(var x in current['columns'][colId]) {
							if(typeof items['items'][current['columns'][colId][x]] != 'undefined' && items['items'][current['columns'][colId][x]] != null) {
								
								var shortcode_slug = items['items'][current['columns'][colId][x]]['slug'];
								
								columnInterface += '<div class="fbuilder_module" data-shortcode="'+shortcode_slug+'" data-modid="'+current['columns'][colId][x]+'">';
								columnInterface += '<div class="fbuilder_module_controls fbuilder_gradient"><span class="fbuilder_module_name">'+fbuilder_shortcodes[shortcode_slug]['text']+'</span> <img class="fbuilder_module_loader" src="'+fbuilder_url+'images/save-loader.gif" /><a href="#" class="fbuilder_edit" title="Edit"></a><a href="#" class="fbuilder_clone" title="Clone"></a><a href="#" class="fbuilder_delete" title="delete"></a></div>';
								columnInterface += '<div class="fbuilder_module_content"></div></div>';
								
							}
						}
						
						columnInterface += '</div><div class="fbuilder_drop_borders"></div>';
						html = html.replace('%'+(parseInt(colId)+3)+'$s', columnInterface);
					}
					
					output += html;
				}
			}
		}


		output += '</div>'+
				'<div style="clear:both"></div>'+
			'</div>'+
			'<div style="clear:both"></div>';
		return output;
	}
	
	
	function fbuilderHideControls($src, init, $mainquery) {
		var shortcode = $('.fbuilder_shortcode_menu').attr('data-shortcode');
		var name = $src.attr('name');
		var qquery = '';
		if(typeof $mainquery == 'undefined')
			$mainquery = $('body');
		if(typeof init == 'undefined') {
			if(name.substr(0,5) != 'fsort') {
				if(typeof fbuilder_hideifs['parents'][shortcode] == 'object' && typeof fbuilder_hideifs['parents'][shortcode][name] != 'undefined') {
					var objects = fbuilder_hideifs['parents'][shortcode][name];
					for(var x in objects) {
						if(typeof objects[x][0] == 'undefined') {
							for(var y in objects[x]) {
								if(qquery != '') qquery += ', ';
								qquery += '[name$='+y+']';
							}
						}
						else {
							if(qquery != '') qquery += ', ';
							qquery += '[name='+x+']';
						}
						
					}
				}
			}
			else {
				var sliceName = name.split('-');
				var sortName = sliceName.slice(2).join('-');
				var sortStart = sliceName.slice(0,2).join('-');
				var $sortHolder = $src.closest('.fbuilder_sortable_holder')
				var sortHolderName = $sortHolder.attr('data-name');
				
				if(typeof fbuilder_hideifs['parents'][shortcode][sortHolderName] == 'object' && typeof fbuilder_hideifs['parents'][shortcode][sortHolderName][sortName] != 'undefined') {
					for(x in fbuilder_hideifs['parents'][shortcode][sortHolderName][sortName][sortHolderName]) {
						if(qquery != '') qquery += ', ';
						qquery += '[name='+sortStart+'-'+x+']';
					}
				}
			}
		}
		else {
			qquery = '.fbuilder_hidable_control';
		}
		$mainquery.find(qquery).each(function(){
			var hideBool = false;
			var hideName = $(this).attr('name');
			if(hideName.substr(0,5) != 'fsort') {
				var hideArr = fbuilder_hideifs['children'][shortcode][hideName];
				for (var x in hideArr) {
					var $hideObj = $('.fbuilder_shortcode_menu .fbuilder_control [name='+x+']:first');
					if(hideArr[x].indexOf($hideObj.val()) != -1) {
						hideBool = true;
						break;
					}
				}
			}
			else {
				var sliceName = hideName.split('-');
			    var hideSName = sliceName.slice(2).join('-');
				var hideSStart = sliceName.slice(0,2).join('-');
				var $hideSHolder = $(this).closest('.fbuilder_sortable_holder')
				var hideHName = $hideSHolder.attr('data-name');
				var hideArr = fbuilder_hideifs['children'][shortcode][hideHName][hideSName];
				for (var x in hideArr) {
					if(!(hideArr[x] instanceof Array)) {
						for(var y in hideArr[x]) {
							if(hideArr[x][y] instanceof Array) {
								var $hideObj = $hideSHolder.find('.fbuilder_control [name='+hideSStart+'-'+y+']:first');
								if(hideArr[x][y].indexOf($hideObj.val()) != -1){
									hideBool = true;
									break;
								}
							}
							else {
								var $hideObj = $hideSHolder.find('[name='+x+']:first');
								if(hideArr[x][y] == $hideObj.val()) {
									hideBool = true;
									break;
								}
							}
						}
					}
					else {
						var $hideObj = $('.fbuilder_shortcode_menu .fbuilder_control [name='+x+']:first');
						if(hideArr[x].indexOf($hideObj.val()) != -1){
							hideBool = true;
							break;
						}
					}
				}
			}
			
			if(hideBool) $(this).closest('.fbuilder_control').hide();
			else $(this).closest('.fbuilder_control').show();
		});
	}
	
	/*  Refresh Frontend Builder Controls  */

	function fbuilderRefreshControls($jq, $location) {
		if(typeof $jq == 'undefined') $jq = jQuery;
		if(typeof $location == 'undefined') $location = $('body');
	
		/* UI slider for number controles */		
		$location.find( ".fbuilder_number_bar" ).each(function(){
			if(!$(this).hasClass('ui-slider')) {
				var min = parseInt($(this).attr('data-min'));
				var max = parseInt($(this).attr('data-max'));
				var std = parseInt($(this).attr('data-std'));
				var step = parseInt($(this).attr('data-step'));
				var unit = $(this).attr('data-unit');
				 
				$(this).slider({
					min: min,
					max: max,
					step : step,
					value: std,
					range: "min",
					slide: function( event, ui ) {
						$(this).parent().find( ".fbuilder_number_amount" ).val( ui.value + ' ' + unit);
					},
					change : function( event, ui) {
						var $input = $(this).parent().find( ".fbuilder_number_amount" );
						fbuilderContolChange($jq, $input);
						
					}
				});
			}
		});
		
		/* Sortable init on new controles */
		$location.find('.fbuilder_sortable').each(function(){
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
		
		
		/* Shortcode color control */	
		var fbuilder_color_iris;
		$location.find( '.fbuilder_color' ).each(function(){
			var $this = $(this);
			$(this).parent().find('.fbuilder_color_display').css('background', $(this).val());
			$(this).fbiris({
				width:228,
				target:$(this).parent().find('.fbuilder_colorpicker'),
				palettes: ['', '#1abc9c', '#16a085', '#3498db', '#2980b9', '#9b59b6', '#8e44ad', '#34495e', '#2c3e50', '#e67e22', '#d35400', '#e74c3c', '#c0392b', '#ecf0f1', '#bdc3c7', '#ffffff', '#000000'],
				change: function(event, ui) {
					var $thisChange = $(this);
				    $(this).parent().find('.fbuilder_color_display').css( 'background-color', ui.color.toString());
					clearTimeout(fbuilder_color_iris);
					fbuilder_color_iris = setTimeout(function(){fbuilderContolChange($jq, $thisChange, true)},400);
				}
			});
		});
	   
		
		/*
		var modid = parseInt($('.fbuilder_shortcode_menu').attr('data-modid'));
		var $module = $jq('.fbuilder_module[data-modid='+modid+']');
		
		$hideLocation.find('.fbuilder_hidable').each(function(){
			var hideBool = false;
			var hideName = $(this).find('.fbuilder_hidable_control').attr('name');
			if(hideName.substr(0,5) != 'fsort') {
				var hideArr = fbuilder_shortcodes[$module.attr('data-shortcode')]['options'][hideName]['hide_if'];
				for (var x in hideArr) {
					var $hideObj = $('.fbuilder_shortcode_menu').find('[name='+x+']');
					if(hideArr[x].indexOf($hideObj.val()) != -1) {
						hideBool = true;
						break;
					}
				}
			}
			else {
				var sliceName = hideName.split('-');
			    var hideSName = sliceName.slice(2).join('-');
				var hideSStart = sliceName.slice(0,2).join('-');
				var $hideSHolder = $(this).closest('.fbuilder_sortable_holder')
				var hideHName = $hideSHolder.attr('data-name');
				var hideArr = fbuilder_shortcodes[$module.attr('data-shortcode')]['options'][hideHName]['options'][hideSName]['hide_if'];
				
				for (var x in hideArr) {
					if(typeof hideArr[x] === 'object') {
						for(var y in hideArr[x]) {
							if(hideArr[x][y] instanceof Array) {
								var $hideObj = $hideSHolder.find('[name='+hideSStart+'-'+x+']');
								if(hideArr[x][y].indexOf($hideObj.val()) != -1){
									hideBool = true;
									break;
								}
							}
							else {
								var $hideObj = $hideSHolder.find('[name='+x+']');
								if(hideArr[x][y] == $hideObj.val()) {
									hideBool = true;
									break;
								}
							}
						}
					}
					else {
						var $hideObj = $hideSHolder.find('[name='+x+']');
						if(hideArr[x].indexOf($hideObj.val()) != -1){
							hideBool = true;
							break;
						}
					}
				}
			}
			
			if(hideBool) $(this).hide();
			else $(this).show();
		});
		*/
		
		/* mCustomScrollbar when new items are created */

		$location.find('.fbuilder_select ul').each(function(){
			if(!$(this).hasClass('fmCustomScrollbar')) {
				$(this).fmCustomScrollbar({mouseWheelPixels:150});
			}
			else {
				$(this).fmCustomScrollbar('update');
			}
		});
		
		$location.find('.fbuilder_icon_dropdown').each(function(){
			
			if(!$(this).hasClass('fmCustomScrollbar')) {
				$(this).fmCustomScrollbar();
			}
			else {
				$(this).fmCustomScrollbar('update');
			}
		});
		if(!$('.fbuilder_shortcode_menu').hasClass('fmCustomScrollbar')) {
			$('.fbuilder_shortcode_menu').fmCustomScrollbar({mouseWheelPixels:150, advanced:{autoScrollOnFocus:false}});
		}
		else {
			$('.fbuilder_shortcode_menu').fmCustomScrollbar('update');
		}
		
	}


	function fbuilderSortableInit($column) {
		$column.find( '.fbuilder_droppable' ).sortable({
			items: '.fbuilder_module',
			connectWith: '.fbuilder_droppable',
			handle : '.fbuilder_module_controls',
			start: function( event, ui) {
				fbuilder_sender = ui.item.parent();
				fbuilder_sender.css('z-index' ,'10');
			},
			stop: function( event, ui ) {
				if (!ui.item.hasClass('fbuilder_module')) {
					var shortcode_slug = ui.item.attr('data-shortcode');
					ui.item.removeClass('fbuilder_draggable fbuilder_gradient').addClass('fbuilder_module').css('z-index' ,'2');
					var moduleInterface = '<div class="fbuilder_module_controls fbuilder_gradient"><span class="fbuilder_module_name">'+fbuilder_shortcodes[shortcode_slug]['text']+'</span> <img class="fbuilder_module_loader" src="'+fbuilder_url+'images/save-loader.gif" /><a href="#" class="fbuilder_edit" title="Edit"></a><a href="#" class="fbuilder_clone" title="Clone"></a><a href="#" class="fbuilder_delete" title="delete"></a></div>';
					ui.item.html(moduleInterface + '<div class="fbuilder_module_content"></div>');
					var sid = 0;
					while(typeof fbuilder_items['items'][sid] != 'undefined') {
						sid++;
					}	
					ui.item.attr('data-modid',sid);
					
					fbuilder_items['items'][sid] = {};
					fbuilder_items['items'][sid]['f'] = fbuilder_shortcodes[shortcode_slug]['function']; 
					fbuilder_items['items'][sid]['slug'] = shortcode_slug; 
					fbuilder_items['items'][sid]['options'] = {}; 
					for(var x in fbuilder_shortcodes[shortcode_slug]['options']) {
						if(fbuilder_shortcodes[shortcode_slug]['options'][x]['type'] == 'sortable'){
							fbuilder_items['items'][sid]['options'][x] = $.extend(true, {},fbuilder_shortcodes[shortcode_slug]['options'][x]['std']);
						}
						else if(typeof fbuilder_shortcodes[shortcode_slug]['options'][x]['std'] != 'undefined') {
							fbuilder_items['items'][sid]['options'][x] = fbuilder_shortcodes[shortcode_slug]['options'][x]['std'];
						}
						else {
							fbuilder_items['items'][sid]['options'][x] = '';
						}
					}
					
					fbuilderGetShortcode(fbuilder_items['items'][sid]['f'], ui.item.find('.fbuilder_module_content'), fbuilder_items['items'][sid]['options']);
					ui.item.find('.fbuilder_edit').trigger('click');
				}
				else {
					fbuilder_sender.css('z-index', 1);
					var shortcode_slug = ui.item.attr('data-shortcode');
					var sid = parseInt(ui.item.attr('data-modid'));
					fbuilderGetShortcode(fbuilder_shortcodes[shortcode_slug]['function'], ui.item.find('.fbuilder_module_content'), fbuilder_items['items'][sid]['options']);
					ui.item.find('.fbuilder_edit').trigger('click');
				}
				
				// update data
				for(var ii=0; ii<2; ii++) {
					if(ii==0) {
						var $fbCol = ui.item.parent();
					}
					else {
						if(fbuilder_sender[0] != ui.item.parent()[0]) {
							var $fbCol = fbuilder_sender;
						}
						else {
							break;
						}
						
					}
				
					while(!$fbCol.hasClass('fbuilder_column')) {
						$fbCol = $fbCol.parent();
					}
					var ind = parseInt($fbCol.attr('data-colnumber'));
					var rowId = $fbCol.closest('[data-rowid]').attr('data-rowid');
					if(rowId != 'sidebar') {
						rowId = parseInt(rowId);
						fbuilder_items['rows'][rowId]['columns'][ind] = new Array();
						$fbCol.find('.fbuilder_module').each(function(index){
							fbuilder_items['rows'][rowId]['columns'][ind][index] = parseInt($(this).attr('data-modid'));	
						});
					}
					else {
						if(typeof fbuilder_items['sidebar'] == 'undefined')
							fbuilder_items['sidebar'] = {}
						fbuilder_items['sidebar']['items'] = [];
						$fbCol.find('.fbuilder_module').each(function(index){
							fbuilder_items['sidebar']['items'][index] = parseInt($(this).attr('data-modid'));	
						});
					}
					
				}
				
			}
		});
	}
	function fbuilderRefreshDragg($jq) {
		$jq( ".fbuilder_draggable", document ).draggable("option", "connectToSortable", $jq('.fbuilder_droppable'));
	}
	/*  Activate Frontend Builder Controls  */

	function fbuilderControlsInit($jq, iDocument) {
		
		if(typeof $jq == 'undefined') $jq = jQuery;
		$jq('#fbuilder_content').sortable({
			items : "> div",
			handle : '.fbuilder_row_controls .fbuilder_drag_handle',
			stop : function(event,ui) {
				fbuilder_items['rowOrder'] = [];
				$jq('#fbuilder_content .fbuilder_row').each(function(index){
					fbuilder_items['rowOrder'][index] = parseInt($(this).attr('data-rowid'));
				});
			}
		});
		$( ".fbuilder_draggable_holder" ).fmCustomScrollbar();
		
		$jq( ".fbuilder_draggable", document ).draggable({
			appendTo: $jq('body'),
			helper: 'clone',
			connectToSortable: $jq('.fbuilder_droppable'),
			start: function( event, ui ) {
				ui.helper.css({width : $jq(this).width()});
			},
			drag: function( event, ui ) {
				ui.helper.css({marginTop:ui.offset.top - ui.position.top});
			}
		});
		$('.fbuilder_toggle_wrapper').hover(function(){
			$(this).stop(true).animate({bottom:0}, 300);	
		},function(){
			$(this).stop(true).animate({bottom:-54},300);
		});
		
		$('.fbuilder_toggle').click(function(e){
			e.preventDefault();
			if(!$(this).hasClass('fbuilder_gradient_primary')) {
				$(this).addClass('fbuilder_gradient_primary').html('Show builder');
				$jq('.fbuilder_module_controls, .fbuilder_row_controls, .fbuilder_drop_borders, .fbuilder_row_holder').hide();
				$('#fbuilder_main_menu').stop(true).animate({left:-250},300);
				$('.fbuilder_shortcode_menu').stop(true).animate({right:-260},300);
				$('#fbuilder_body').stop(true).animate({borderLeftWidth:0, borderRightWidth:0},300);
			}
			else {
				$(this).removeClass('fbuilder_gradient_primary');
				$jq('.fbuilder_module_controls, .fbuilder_row_controls, .fbuilder_drop_borders, .fbuilder_row_holder').show();
				$('#fbuilder_main_menu').stop(true).animate({left:0},300);
				if($('.fbuilder_shortcode_menu').length > 0) {
					$('.fbuilder_shortcode_menu').stop(true).animate({right:0},300);
					$('#fbuilder_body').stop(true).animate({borderLeftWidth:250, borderRightWidth:260},300);
				}
				else {
				$('#fbuilder_body').stop(true).animate({borderLeftWidth:250},300);
				}
					
			}
		});
		$('.fbuilder_toggle_screen').click(function(){
			$('.fbuilder_toggle_screen.fbuilder_gradient_primary').removeClass('fbuilder_gradient_primary');
			$(this).addClass('fbuilder_gradient_primary');
			if($(this).find('.icon-desktop').length > 0)
				$('#fbuilder_body_frame').css({'min-width':$(this).attr('data-width')+'px', 'max-width' :'100%', 'width' :'100%'});
			else if($(this).find('.icon-laptop').length > 0) 
				$('#fbuilder_body_frame').css({'width':'100%', 'min-width' : $(this).attr('data-width')+'px', 'max-width' : (parseInt($(this).prev().attr('data-width'))-1)+'px'});
			else
				$('#fbuilder_body_frame').css({'width':$(this).attr('data-width')+'px', 'min-width' : '0'});
		});
		if($('#fbuilder_body_frame').width() > parseInt($('.fbuilder_toggle_screen:first').attr('data-width'))) {
			$('.fbuilder_toggle_screen:first').trigger('click');
		}
		else {
			$('.fbuilder_toggle_screen').eq(1).trigger('click');
		}
		
		
		$('body').keydown(function(e) {
			var code = e.keyCode || e.which;
			if (code == '9' && $('input:focus, select:focus, textarea:focus').length <= 0) {
				e.preventDefault();
				$('.fbuilder_toggle').trigger('click');
			}
		});
		$jq('body').keydown(function(e) {
			var code = e.keyCode || e.which;
			if (code == '9' && $jq('input:focus, select:focus, textarea:focus').length <= 0) {
				e.preventDefault();
				$('.fbuilder_toggle').trigger('click');
			}
		});
		
		
		$('.fbuilder_layout').change(function(){
			var layout = $(this).val();
			if(layout != 'full-width') {
				if($jq('.fbuilder_sidebar').length <= 0) {
					var html = '<div class="fbuilder_sidebar fbuilder_'+layout+' fbuilder_row" data-rowid="sidebar">'+
					'<div class="fbuilder_row_controls"><span class="fbuilder_sidebar_label">Sidebar</span></div>'+
					'<div class="fbuilder_column">'+
						'<div class="fbuilder_droppable">';
					
						
					html += '</div>'+
						'<div class="fbuilder_drop_borders"></div>'+
					'</div></div>';
					$jq('#fbuilder_wrapper').prepend(html);
					
					
					if(typeof fbuilder_items['sidebar'] == 'undefined') {
						fbuilder_items['sidebar'] = {active:true, type:layout, items:[]};
					}
					else {
						fbuilder_items['sidebar']['active'] = true;
						for(var s in fbuilder_items['sidebar']['items']) {
							var sid = fbuilder_items['sidebar']['items'][s];
							if(typeof sid != 'undefined') {
								shortcode_slug = fbuilder_items['items'][sid]['slug'];
								var moduleInterface = '<div class="fbuilder_module_controls fbuilder_gradient"><span class="fbuilder_module_name">'+fbuilder_shortcodes[shortcode_slug]['text']+'</span> <img class="fbuilder_module_loader" src="'+fbuilder_url+'images/save-loader.gif" /><a href="#" class="fbuilder_edit" title="Edit"></a><a href="#" class="fbuilder_clone" title="Clone"></a><a href="#" class="fbuilder_delete" title="delete"></a></div>';
								$jq('.fbuilder_sidebar .fbuilder_droppable').append('<div class="fbuilder_module" data-modid="'+sid+'" data-shortcode="'+shortcode_slug+'">'+  moduleInterface + '<div class="fbuilder_module_content"></div></div>');
								fbuilderGetShortcode(fbuilder_items['items'][sid]['f'], $jq('.fbuilder_sidebar').find('.fbuilder_module_content:last'), fbuilder_items['items'][sid]['options']);
							}
						}
					}
					fbuilderSortableInit($jq('.fbuilder_sidebar .fbuilder_column'));
					fbuilderRefreshDragg($jq);
				}
				else {
					fbuilder_items['sidebar']['type'] = layout;
					$jq('.fbuilder_sidebar').attr('class', 'fbuilder_sidebar fbuilder_'+layout);
				}
			}
			else {
				fbuilder_items['sidebar']['active'] = false;
				$jq('.fbuilder_sidebar').remove();
			}
			$jq('#fbuilder_wrapper').removeClass('fbuilder_wrapper_full-width fbuilder_wrapper_one-third-right-sidebar fbuilder_wrapper_one-third-left-sidebar fbuilder_wrapper_one-fourth-left-sidebar fbuilder_wrapper_one-fourth-right-sidebar').addClass('fbuilder_wrapper_'+layout+' fbuilder_row');
		});
		
		function jsonMod(key, value) {
				if (typeof(value) == "string") {
					return value.replace(/"/g,'&quot;');
				}
				if (typeof(value) == "array") {
					for(var x in value) {
						if (typeof(value[x]) == "string") {
							value[x] = value[x].replace(/"/g,'&quot;');
						}
					}
				} 
					return value;
			}
		
		$('.fbuilder_save').click(function(e){
			e.preventDefault();
			var codedJSON = JSON.stringify(fbuilder_items,jsonMod);
			var data = {
				action : 'fbuilder_save',
				id: post_id,
				json : codedJSON
			}
			if(typeof window.fbuilder_saveajax != 'undefined') window.fbuilder_saveajax.abort();
			var $this = $(this);
			$this.stop(true).animate({paddingRight : 26, paddingLeft:10},200);
			$this.next().stop(true).fadeIn(200);
			window.fbuilder_saveajax = $.post(ajaxurl, data, function(response) {
				$this.stop(true).animate({paddingRight : 18, paddingLeft:18},200);
				$this.next().stop(true).fadeOut(200);
			});
		});
		$('.fbuilder_false_save').click(function(e){
			alert('You can\'t save here!');
		});
		
		$('.fbuilder_save_template').click(function(e){
			e.preventDefault();
			var html = '<div class="fbuilder_popup fbuilder_popup_template fbuilder_controls_wrapper"><div class="fbuilder_module_controls fbuilder_gradient"><span class="fbuilder_module_name">Save template</span> <a href="#" class="fbuilder_close" title="close"></a></div><div class="fbuilder_popup_content">';
			html += '<table><tr><td><p>';
			html += 'Template name';
			html += '</p></td><td>';
			var shJson = {
				type : 'input',
				label : ''
			}
			var ctrl = new fbuilderControl('template_name',shJson);
			html += ctrl.html(); 
			html += '</td></tr></table>';
			html += '<a href="#" class="fbuilder_gradient fbuilder_button fbuilder_popup_close right">Close</a><img class="fbuilder_popup_button_loader right" alt="" src="'+fbuilder_url+'images/save-loader.gif"></img><a href="#" class="fbuilder_gradient_primary fbuilder_button fbuilder_popup_save right">Save</a>';
			html +='</div></div><div class="fbuilder_popup_shadow"></div>';
			$('#fbuilder_body').prepend(html);
		});
		$('.fbuilder_load').click(function(e){
			e.preventDefault();
			var html = '<div class="fbuilder_popup fbuilder_popup_load fbuilder_controls_wrapper"><div class="fbuilder_module_controls fbuilder_gradient"><span class="fbuilder_module_name">Load</span> <a href="#" class="fbuilder_close" title="close"></a></div>';
			html +='<div class="fbuilder_popup_content"><img class="fbuilder_popup_loader" src="'+fbuilder_url+'images/popup-loader.gif" /></div>';		
			html +='</div><div class="fbuilder_popup_shadow"></div>';
			$('#fbuilder_body').prepend(html);
			
			var data = {
				action : 'fbuilder_pages',
			}
			window.fbuilder_popupajax = $.get(ajaxurl, data, function(response) {
				response = JSON.parse(response);
				var rHtml = '';
				
				rHtml += '<div class="fbuilder_popup_tabs"><ul><li><a href="#pages_popup_tab_content">Load page</a></li><li><a href="#templates_popup_tab_content">Load template</a></li></ul>';
				
				rHtml += '<div id="pages_popup_tab_content"><table><tr><td><p>';
				rHtml += 'Select the post you want to load';
				rHtml += '</p></td><td>';
				var shJson = {
					type : 'select',
					label : '',
					options : [],
					search: 'true'
				}
				for (var x in response['pages']) {
					shJson['options'][x] = response['pages'][x]['title'];
				}
				select = new fbuilderControl('loaded_pages',shJson);
				rHtml += select.html();
				rHtml += '</td></tr></table></div>';
				
				
				rHtml += '<div id="templates_popup_tab_content">';
				if(!$.isEmptyObject(response['templates'])) {
					rHtml += '<table><tr><td><p>Select the template you want to load';
					rHtml += '</p></td><td>';
					shJson = {
						type : 'select',
						label : '',
						options : [],
						search: 'true'
					}
					for (var x in response['templates']) {
						shJson['options'][x] = response['templates'][x];
					}
					select = new fbuilderControl('loaded_templates',shJson);
					rHtml += select.html();
					rHtml += '</td></tr></table></div>';
				}
				else {
					rHtml += '<p>You don\'t have any templates yet.</p>';
				}
				
				
				rHtml += '</div><a href="#" class="fbuilder_gradient fbuilder_button fbuilder_popup_close right">Close</a><img class="fbuilder_popup_button_loader right" alt="" src="'+fbuilder_url+'images/save-loader.gif"></img><a href="#" class="fbuilder_gradient_primary fbuilder_button fbuilder_popup_load right">Load</a>';
				$('.fbuilder_popup_content').html(rHtml);
				
				$(".fbuilder_popup_tabs > ul a:first").addClass("active");
				$(".fbuilder_popup_tabs > div").hide();
				$(".fbuilder_popup_tabs > div:first").show();
				$(".fbuilder_popup_tabs > ul a").click(function(e){
					e.preventDefault();
					if(!$(this).hasClass('active')) {
						$(this).closest('ul').find('a').removeClass("active");
						$(this).addClass('active');
						
						var tabId = $(this).attr('href');
							
						$(this).closest('.fbuilder_popup_tabs').children('div').stop(true, true).hide();
						$(tabId).fadeIn();
					}
				});
				$(".tabs").each(function(){
					$(this).find("a:first").trigger("click");
				});
	
				fbuilderRefreshControls($jq, $('.fbuilder_popup_content'));
			});
		});
		$(document).on('click', '.fbuilder_popup .fbuilder_close, .fbuilder_popup .fbuilder_popup_close', function(e){
			$('.fbuilder_popup, .fbuilder_popup_shadow').remove();
		});
		$(document).on('click', '.fbuilder_popup .fbuilder_popup_load', function(e){
			e.preventDefault();
			$(this).animate({paddingRight:30, marginRight:-10}, 200).prev('.fbuilder_popup_button_loader').animate({opacity:1, marginRight:10},200);
			
			var $popC = $(this).closest('.fbuilder_popup_content');
			var loadIndex = $popC.find('.fbuilder_control:visible #fbuilder_select_loaded_pages, .fbuilder_control:visible #fbuilder_select_loaded_templates').val();
			var data = {
				action : 'fbuilder_page_content',
				id : loadIndex
			}
			$.get(ajaxurl, data, function(response) {
				response = response.split('|+break+response+|');
				var loadJson = JSON.parse(response[0].replace(/\\(.)/mg, "$1"));
				var loadHtml = response[1];
				fbuilder_items = loadJson;
				$jq('#fbuilder_wrapper').replaceWith(loadHtml);
				fbuilderFrameControls($('#fbuilder_body_frame').contents());
				fbuilderSortableInit($jq( '#fbuilder_content .fbuilder_row'));
				$jq('.fbuilder_module').trigger('refresh');
				if($('.fbuilder_shortcode_menu').length > 0) {
					$('.fbuilder_shortcode_menu').remove();
					$('#fbuilder_body').css({borderRightWidth:0});
				}
				$jq('#fbuilder_wrapper').trigger('refresh');
				$('.fbuilder_popup, .fbuilder_popup_shadow').remove();
			});
		});
		$(document).on('click', '.fbuilder_popup .fbuilder_popup_save', function(e){
			e.preventDefault();
			$(this).animate({paddingRight:30, marginRight:-10}, 200).prev('.fbuilder_popup_button_loader').animate({opacity:1, marginRight:10},200);
			
			var $popC = $(this).closest('.fbuilder_popup_content');
			var tmplName = $popC.find('#fbuilder_input_template_name').val();
			var itemsString = JSON.stringify(fbuilder_items, jsonMod);
			var data = {
				action : 'fbuilder_template_save',
				name : tmplName,
				items : itemsString
			}
			$.post(ajaxurl, data, function(response) {
				$('.fbuilder_popup, .fbuilder_popup_shadow').remove();
			});
		});
		
		
		/* Add new row button */
		
		$jq('.fbuilder_new_row').click(function(e){
			e.preventDefault();
			var $holder = $jq(this).parent();
			var buttonHeight = $holder.children('.fbuilder_new_row').height() + parseInt($holder.children('.fbuilder_new_row').css('padding-top')) + parseInt($holder.children('.fbuilder_new_row').css('padding-bottom'));
			var innerHeight = $holder.children('.fbuilder_row_holder_inner').height() + parseInt($holder.children('.fbuilder_row_holder_inner').css('padding-top')) + parseInt($holder.children('.fbuilder_row_holder_inner').css('padding-bottom'));
			
			if(!$jq(this).hasClass('active')) {
				$jq(this).addClass('active fbuilder_gradient_primary').removeClass('fbuilder_gradient');
				$holder.stop(true).animate({height: (buttonHeight + innerHeight + 2)+'px'}, 300);
			}
			else {
				$jq(this).removeClass('active').addClass('fbuilder_gradient').removeClass('fbuilder_gradient_primary');
				$holder.stop(true).animate({height: (buttonHeight + 2)+'px'}, 300, function(){
					$jq(this).trigger('refresh');
				});
			}
		});
		
		/* Row button click */
		
		$jq('.fbuilder_row_button').click(function(e){
			e.preventDefault();
			var value = parseInt($jq(this).attr('href').substr(1));
			var html = fbuilder_rows[value]['html'];
			
			var id=0;
			while($jq('#fbuilder_content .fbuilder_row[data-rowid='+id+']').length > 0) id++;
			html = html.replace('%1$s', id+'');
			
			
			var rowInterface = '<div class="fbuilder_row_controls"><a href="#" class="fbuilder_drag_handle" title="Move"></a><a href="#" class="fbuilder_edit" title="Edit"><a href="#" class="fbuilder_clone" title="Clone"></a><a href="#" class="fbuilder_delete" title="delete"></a></div>';
			html = html.replace('%2$s', rowInterface);
			
			var columnInterface = '<div class="fbuilder_droppable"></div><div class="fbuilder_drop_borders"></div>';
			html = html.replace(/%[0-9]+\$s/g, columnInterface);
			
			if(typeof fbuilder_items.rows == 'undefined') {
				fbuilder_items.rows = new Array();
				fbuilder_items.rowCount = 0;
				fbuilder_items.rowOrder = new Array();
				fbuilder_items.items = new Array();
			}
			var columns = new Array();
			var count = html.match(/fbuilder_column /g);
			for(var x=0; x<count.length; x++) {
				columns[x]=new Array();
			}
			fbuilder_items['rows'][id] = {type : value, columns : columns};
			
			if($jq('#fbuilder_wrapper').hasClass('empty')) {
				$jq('#fbuilder_wrapper').removeClass('empty');
			}
			$jq('.fbuilder_new_row').trigger('click');
			$jq('#fbuilder_content').append(html);
			
			
			fbuilder_items['rowOrder'] = [];
			$jq('#fbuilder_content .fbuilder_row').each(function(index){
				fbuilder_items['rowOrder'][index] = parseInt($jq(this).attr('data-rowid'));
			});
			fbuilder_items.rowCount = $jq('#fbuilder_content .fbuilder_row').length;
			
			fbuilderSortableInit($jq( '#fbuilder_content .fbuilder_row:last'));
			fbuilderRefreshDragg($jq);
			$jq('#fbuilder_wrapper').trigger('refresh');
		});
		
		
		/* Row controls */
		$jq(iDocument).on('click','.fbuilder_row_controls .fbuilder_drag_handle', function(e) {
			e.preventDefault();	
		});
		$jq(iDocument).on('click','.fbuilder_row_controls .fbuilder_delete', function(e){
			e.preventDefault();
			var $parent = $jq(this).closest('.fbuilder_row');
			var id = parseInt($parent.attr('data-rowid'));
			var found = false;
			
			if($('.fbuilder_shortcode_menu').hasClass('fbuilder_rowedit_menu') && $('.fbuilder_shortcode_menu').attr('data-modid') == id) {
				$('.fbuilder_shortcode_menu').animate({right:-300}, 300, function(){
					$(this).remove();
					fbuilder_shortcode_sw = false;
				});
				$('#fbuilder_body').stop(true).animate({borderRightWidth:0},300);
			}
			
			$parent.find('.fbuilder_module .fbuilder_delete').trigger('click');
			$parent.remove();
			fbuilder_items['rowOrder'] = [];
			$jq('#fbuilder_content .fbuilder_row').each(function(index){
				fbuilder_items['rowOrder'][index] = parseInt($jq(this).attr('data-rowid'));
			});
			fbuilder_items.rowCount = $jq('#fbuilder_content .fbuilder_row').length;
			$jq('#fbuilder_wrapper').trigger('refresh');
		});
		
		$jq(iDocument).on('click', '.fbuilder_row_controls .fbuilder_clone', function(e){
			e.preventDefault();
			var $parent = $jq(this).closest('[data-rowid]');
			var id = parseInt($parent.attr('data-rowid'));
			var newId = 0;
			while($jq('.fbuilder_row[data-rowid="'+newId+'"]').length > 0) {
				newId++;
			}
			var found = false;
			var i=fbuilder_items.rowCount;
			var idReplace = {};
			while(!found) {
				if(fbuilder_items['rowOrder'][i] == id) {
					found = true;
					fbuilder_items['rowOrder'][i+1] = newId;
					fbuilder_items['rows'][newId] = $.extend(true, {},fbuilder_items['rows'][id]);
					fbuilder_items['rows'][newId]['columns'] = [];
					
					var ind = 0;
					for(var x in fbuilder_items['rows'][id]['columns']) {
						fbuilder_items['rows'][newId]['columns'][x] = [];
						for(var y in fbuilder_items['rows'][id]['columns'][x] ) {
							var itemId = fbuilder_items['rows'][id]['columns'][x][y];
							if(typeof itemId != 'undefined') {
								while(typeof fbuilder_items['items'][ind] != 'undefined') {
									ind++;
								}
								fbuilder_items['items'][ind] = {};
								fbuilder_items['items'][ind]['f'] = fbuilder_items['items'][itemId]['f'];
								fbuilder_items['items'][ind]['slug'] = fbuilder_items['items'][itemId]['slug'];
								fbuilder_items['items'][ind]['options'] = $.extend(true, {},fbuilder_items['items'][itemId]['options']);
								fbuilder_items['rows'][newId]['columns'][x][y] = ind;
								idReplace[itemId] = ind;
							}
						}
					}
				} else {
					fbuilder_items['rowOrder'][i] = fbuilder_items['rowOrder'][i-1];
				}
				i--;
			}
			$parent.clone().insertAfter($parent);
			$parent.next().attr('data-rowid',newId);
			$parent.next().find('.fbuilder_module').each(function(){
				$jq(this).attr('data-modid',idReplace[parseInt($jq(this).attr('data-modid'))])
			});
			$parent.next().find('.fbuilder_gradient_primary').removeClass('fbuilder_gradient_primary');
			$parent.next().find('.fbuilder_row_controls.selected').removeClass('selected');
			fbuilderSortableInit($parent.next());
			fbuilder_items.rowCount++;
		});
		
		$jq(iDocument).on('click', '.fbuilder_row_controls .fbuilder_edit', function(e){
			e.preventDefault()
			$controls = $jq(this).closest('.fbuilder_row_controls');
			$row = $controls.closest('.fbuilder_row');
			
			var id = parseInt($row.attr('data-rowid'));
			
			if(fbuilder_shortcode_sw) {
				var $menu = $('.fbuilder_shortcode_menu');
				if(!$menu.hasClass('fbuilder_rowedit_menu') || parseInt($menu.attr('data-modid')) != id) {
					$menu.addClass('fbuilder_rowedit_menu');
					$menu.attr('data-modid',id);
					if($menu.css('right') != '0px') {
						$menu.stop(true).animate({right:0},300);
						$('#fbuilder_body').stop(true).animate({borderRightWidth:260},300);
					}
					$jq('.fbuilder_module_controls.fbuilder_gradient_primary').removeClass('fbuilder_gradient_primary');
					$jq('.fbuilder_row_controls.selected').removeClass('selected');
					$controls.addClass('selected');
					$menu.find('.fbuilder_menu_inner').stop(true).animate({opacity:0},200,function(){
						var shHtml = fbuilderCreateRowMenu(id, $row);
						$(this).html(shHtml).animate({opacity:1},300);
						fbuilderHideControls($('false'), true);
						fbuilderRefreshControls($jq, $menu);
					});
				}
			}
			else {
				fbuilder_shortcode_sw = true;
				$controls.addClass('selected');
				var html = '<div style="left:auto; right:-250px;" class="fbuilder_shortcode_menu fbuilder_rowedit_menu fbuilder_controls_wrapper" data-modid="'+id+'"><formautocomplete="off"><div class="fbuilder_menu_inner">';
				html += fbuilderCreateRowMenu(id, $row);
				html += '</div></form></div>';
				$('body').append(html);
				var $menu = $('.fbuilder_shortcode_menu');
				fbuilderHideControls($('false'), true);
				fbuilderRefreshControls($jq, $menu);
				$menu.stop(true).animate({right:0},300);
				$('#fbuilder_body').stop(true).animate({borderRightWidth:260},300);
			}
			
		});
		
		
		/* Module controls */
		var moduleDeleteFlag = false;
		$jq(iDocument).on('click', '.fbuilder_module_controls', function(){
			$controls = $jq(this);
			$module = $controls.closest('.fbuilder_module');
			
			if(!moduleDeleteFlag) {
				var id = parseInt($module.attr('data-modid'));
				var shortcode = $module.attr('data-shortcode');
				if(fbuilder_shortcode_sw) {
					var $menu = $('.fbuilder_shortcode_menu');
					if($menu.hasClass('fbuilder_rowedit_menu') || parseInt($menu.attr('data-modid')) != id) {
						$menu.removeClass('fbuilder_rowedit_menu');
						$jq('.fbuilder_row_controls.selected').removeClass('selected');
						$menu.attr('data-modid',id).attr('data-shortcode',shortcode);
						if($menu.css('right') != '0px') {
							$menu.stop(true).animate({right:0},300);
							$('#fbuilder_body').stop(true).animate({borderRightWidth:260},300);
						}
						$jq('.fbuilder_module_controls.fbuilder_gradient_primary').removeClass('fbuilder_gradient_primary');
						$controls.addClass('fbuilder_gradient_primary');
						$menu.find('.fbuilder_menu_inner').stop(true).animate({opacity:0},200,function(){
							var shHtml = fbuilderCreateShortcodeMenu(id, $module);
							$(this).html(shHtml).animate({opacity:1},300);
							fbuilderHideControls($('false'), true);
							fbuilderRefreshControls($jq, $menu);
						});
					}
				}
				else {
					fbuilder_shortcode_sw = true;
					$controls.addClass('fbuilder_gradient_primary');
					var html = '<div style="left:auto; right:-250px;" class="fbuilder_shortcode_menu fbuilder_controls_wrapper" data-modid="'+id+'" data-shortcode="'+shortcode+'"><formautocomplete="off"><div class="fbuilder_menu_inner">';
					html += fbuilderCreateShortcodeMenu(id, $module);
					html += '</div></form></div>';
					$('body').append(html);
					var $menu = $('.fbuilder_shortcode_menu');
					fbuilderHideControls($('false'), true);
					fbuilderRefreshControls($jq, $menu);
					$menu.stop(true).animate({right:0},300);
					$('#fbuilder_body').stop(true).animate({borderRightWidth:260},300);
				}
			}
			else {
				moduleDeleteFlag = false;
			}
		});
		
		$jq(iDocument).on('click', '.fbuilder_module_controls .fbuilder_edit', function(e){
			e.preventDefault();
		});
		
		$jq(iDocument).on('click','.fbuilder_module_controls .fbuilder_delete',function(e){
			e.preventDefault();
			moduleDeleteFlag = true;
			var $module = $jq(this).parent().parent();
			var modid = parseInt($module.attr('data-modid'));
			var $column = $module.parent().parent();
			var rowid = $column.closest('[data-rowid]').attr('data-rowid');
			
			$module.remove();
			if($('.fbuilder_shortcode_menu').attr('data-modid') == modid) {
				$('.fbuilder_shortcode_menu').animate({right:-300}, 300, function(){
					$(this).remove();
					fbuilder_shortcode_sw = false;
				});
				$('#fbuilder_body').stop(true).animate({borderRightWidth:0},300);
			}
			
			if(rowid != 'sidebar') {
				rowid = parseInt(rowid);
				var colnum = parseInt($column.attr('data-colnumber'));
				fbuilder_items['rows'][rowid]['columns'][colnum] = [];
				$column.find('.fbuilder_module').each(function(index){
					fbuilder_items['rows'][rowid]['columns'][colnum][index] = parseInt($jq(this).attr('data-modid'));	
				});
				delete fbuilder_items['items'][modid];
			}
			else {
				fbuilder_items['sidebar']['items'] = [];
				$column.find('.fbuilder_module').each(function(index){
					fbuilder_items['sidebar']['items'][index] = parseInt($jq(this).attr('data-modid'));	
				});
				delete fbuilder_items['items'][modid];
			}
			$jq('#fbuilder_wrapper').trigger('refresh');
		});
		
		$jq(iDocument).on('click', '.fbuilder_module_controls .fbuilder_clone', function(e){
			e.preventDefault();
			var $module = $jq(this).parent().parent();
			var $clone = $module.clone();
			var modid = parseInt($module.attr('data-modid'));
			var $column = $module.parent().parent();
			var colnum = parseInt($column.attr('data-colnumber'));
			var rowid = $column.closest('[data-rowid]').attr('data-rowid');
			
			var newid = 0;
			while(typeof fbuilder_items['items'][newid] != 'undefined') newid++;
			fbuilder_items['items'][newid] = {};
			fbuilder_items['items'][newid]['f'] = fbuilder_items['items'][modid]['f'];
			fbuilder_items['items'][newid]['slug'] = fbuilder_items['items'][modid]['slug'];
			fbuilder_items['items'][newid]['options'] = $.extend(true, {},fbuilder_items['items'][modid]['options']);
			
			$clone.insertAfter($module);
			$module.next().attr('data-modid', newid);
			setTimeout(function(){$module.next().find('.fbuilder_module_controls').trigger('click');}, 1);
			
			if(rowid != 'sidebar') {
				rowid = parseInt(rowid);
				fbuilder_items['rows'][rowid]['columns'][colnum] = [];
				$column.find('.fbuilder_module').each(function(index){
					fbuilder_items['rows'][rowid]['columns'][colnum][index] = parseInt($jq(this).attr('data-modid'));	
				});
			}
			else {
				fbuilder_items['sidebar']['items'] = [];
				$column.find('.fbuilder_module').each(function(index){
					fbuilder_items['sidebar']['items'][index] = parseInt($jq(this).attr('data-modid'));	
				});
			}
		});
		
		
		/* Shortcode select control */
		
		$(document).on('mouseenter', '.fbuilder_select', function(){
				$(this).data('hover',true);
			});
		$(document).on('mouseleave', '.fbuilder_select',function(){
				$(this).data('hover', false);
			});
			
		$(document).on('click', '.fbuilder_select span, .fbuilder_select .drop_button', function(e){
			e.preventDefault();
			$parent = $(this).parent();
			if(!$parent.hasClass('active')) {
				$parent.addClass('active').find('ul, input').show();
			}
			else {
				$parent.removeClass('active').find('ul, input').hide();
			}
			fbuilderRefreshControls($jq,$(this).closest('.fbuilder_control'));
		});
		$(document).on('click', '.fbuilder_select ul a', function(e){
			e.preventDefault();
			var $parent = $(this).closest('.fbuilder_select');
			var multi = $parent.hasClass('fbuilder_select_multi');
			var $select = $('[name='+$parent.attr('data-name')+']');
			if(!multi || typeof window.shiftKey == 'undefined' || window.shiftKey == false) {
				$select.val($(this).attr('data-value'));
				$parent.find('span').html($(this).html());
				$parent.removeClass('active').find('ul, input').hide();
				$parent.find('ul a.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			else {	
				var multiVal = $select.val();
				var multiHtml = $parent.find('span').html();
				
				if(!$(this).hasClass('selected')) {
					$(this).addClass('selected');
					if(multiVal != '') {
						multiVal += ',';
						multiHtml += ',';
					}
					multiVal +=	$(this).attr('data-value');
					multiHtml += $(this).html();
				}
				else {
					$(this).removeClass('selected');
					
					var multiSplitHtml = multiHtml.split(',');
					var multiSplitVal = multiVal.split(',');
					multiHtml = '';
					multiVal = '';
					var flag = 0;
					for(var x in multiSplitVal) {
						if(multiSplitVal[x] != $(this).attr('data-value')) {
							if(x != 0 && flag != 1) {
								multiVal += ',';
								multiHtml += ',';
							}
							multiVal += multiSplitVal[x];
							multiHtml += multiSplitHtml[x];
							flag = 0;
						}
						else if(x == 0) {
							flag = 1;
						}
					}
					
					//multiVal +=	$(this).attr('data-value');
					//multiHtml += $(this).html();
				}
			
				$select.val(multiVal);
				$parent.find('span').html(multiHtml);
			}
			$select.trigger('change');
			fbuilderContolChange($jq, $select);
		});
		$('body').keydown(function(e) {
			var code = e.keyCode || e.which;
			if (e.ctrlKey) {
				window.shiftKey = true;
			}
		});
		$('body').keyup(function(e) {
			var code = e.keyCode || e.which;
			if (code == 17) {
				window.shiftKey = false;
			}
		});
		$('body').click(function(){
			$('.fbuilder_select.active').each(function(){
				if(!$(this).data('hover')) {
					$(this).removeClass('active').find('ul, input').hide();
				}
			});
		});
		
		$(document).on('keyup', '.fbuilder_select input', function(){
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
		
		
		/* Shortcode input/textarea control */
		$(document).on('click', '.fbuilder_input_wrapper label', function(){
			var $input = $(this).parent().find('input');
			var val = $input.val();
			$input.trigger('focus').val('').val(val);
		})
		$(document).on('keyup', '.fbuilder_shortcode_menu input, .fbuilder_shortcode_menu textarea', function(){
			fbuilderContolChange($jq, $(this));
		});
		var $fbuilder_editor_textarea;
		$(document).on('click', '.fbuilder_wp_editor_button', function(e){
			e.preventDefault();
			$fbuilder_editor_textarea = $(this).prev();
			$('#fbuilder_editor_popup, #fbuilder_editor_popup_shadow').show();
			tinymce.get('fbuilder_editor').setContent($fbuilder_editor_textarea.val());
		});
		
		$(document).on('click', '#fbuilder_editor_popup .fbuilder_close, .fbuilder_popup_close', function(e){
			e.preventDefault();
			$('#fbuilder_editor_popup, #fbuilder_editor_popup_shadow').hide();
		});
		
		$(document).on('click', '.fbuilder_popup_edit_submit', function(e){
			e.preventDefault();
			$('#fbuilder_editor_popup, #fbuilder_editor_popup_shadow').hide();
			$fbuilder_editor_textarea.val(tinymce.activeEditor.getContent()).trigger('keyup');
		});
		
		
		/* Shortcode checkbox control */
		$(document).on('click','.fbuilder_checkbox', function(){
			var $input = $(this).parent().find('.fbuilder_checkbox_input');
			if($(this).hasClass('active')) {
				$input.val('false');
				$(this).removeClass('active');
			}
			else {
				$input.val('true');
				$(this).addClass('active');
			}
			fbuilderContolChange($jq, $input);
			
		});
		
		/* Shortcode icon control */
		
		$(document).on('click', '.fbuilder_icon_left', function(e){
			e.preventDefault();
			var $input = $(this).parent().find('input');
			var val = parseInt($input.attr('data-current'));
			if (val == parseInt($input.attr('data-min'))) val = fbuilder_icons.length - 1;
			else val--;
			$input.val(fbuilder_icons[val]).attr('data-current', val);
			$(this).parent().find('.fbuilder_icon_holder i').attr('class',fbuilder_icons[val] + ' fawesome');
			fbuilderContolChange($jq, $input, true);
		});
		
		$(document).on('click','.fbuilder_icon_right', function(e){
			e.preventDefault();
			var $input = $(this).parent().find('input');
			var val = parseInt($input.attr('data-current'));
			if (val == fbuilder_icons.length-1) val = parseInt($input.attr('data-min'));
			else val++;
			$input.val(fbuilder_icons[val]).attr('data-current', val);
			$(this).parent().find('.fbuilder_icon_holder i').attr('class',fbuilder_icons[val] + ' fawesome');
			fbuilderContolChange($jq, $input, true);
		});
		
		$(document).on('click', '.fbuilder_icon_pick', function(e){
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
			fbuilderRefreshControls($jq, $(this).closest('.fbuilder_control'));
		});
		$(document).on('click', '.fbuilder_icon_dropdown a', function(e){
			e.preventDefault();
			var $parent = $(this).parent();
			while(!$parent.hasClass('fbuilder_control')) {
				$parent = $parent.parent();
			}
			var $input = $parent.find('input');
			var val = parseInt($(this).attr('href'));
			$input.val(fbuilder_icons[val]).attr('data-current',val);
			$parent.find('.fbuilder_icon_holder i').attr('class',fbuilder_icons[val] + ' fawesome');
			fbuilderContolChange($jq, $input);
		});
		
		
		$(document).on('mouseenter', '.fbuilder_icon_dropdown, .fbuilder_icon_pick', function(){
				$(this).data('hover',true);
			});
		$(document).on('mouseleave', '.fbuilder_icon_dropdown, .fbuilder_icon_pick', function(){
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
		$(document).on('click','.fbuilder_image_button', function(e) {
			e.preventDefault();
			thickboxId = '#'+ $(this).attr('data-input') + '_holder';
			formfield = $(this).attr('data-input');
			var mediaurl = ajaxurl.substr(0,ajaxurl.indexOf('admin-ajax'))+'media-upload.php';
			tb_show('', mediaurl+ '?type=image&amp;width=620&amp;height=420&amp;TB_iframe=true');
			return false;
		});
		
		$(document).on('click', '.fbuilder_image_input span', function(){
			$(this).hide();
			$(this).parent().find('input').focus();
		});
		
		$(document).on('focusout','.fbuilder_image_input input', function(){
			if($(this).val() == '') {
				$(this).parent().find('span').show();
			}
		});
		$(document).on('keyup', '.fbuilder_image_input input', function(){
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
			fbuilderContolChange($jq, $(this));
		});
		
		window.send_to_editor = function(html) {
			if(typeof formfield != 'undefined') {
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
				fbuilderContolChange($jq, $('#' + formfield));
			}
			else {
				tinymce.get('fbuilder_editor').execCommand('mceInsertContent', false, html);
			}
		}
		
		
		/* Shortcode sortable control */
		
		$(document).on('click', '.fbuilder_sortable_add', function(e){
			e.preventDefault();
			var html = '';
			var name = $(this).closest('.fbuilder_sortable_holder').attr('data-name');
			var item_name = $(this).closest('.fbuilder_sortable_holder').attr('data-iname');
			var $smenu = $(this).parent().parent();
			while(!$smenu.hasClass('fbuilder_shortcode_menu'))
				$smenu = $smenu.parent();
			var itemId = parseInt($smenu.attr('data-modid'));
			var itemSh = $smenu.attr('data-shortcode');
			
			var shortcodeJSON = $.extend(true, {},fbuilder_shortcodes[itemSh]['options'][name]);
			if(typeof fbuilder_items['items'][itemId]['options'][name]['items'] == 'undefined') {
				fbuilder_items['items'][itemId]['options'][name]['items'] = {};
				fbuilder_items['items'][itemId]['options'][name]['order'] = {};
			}
			var count = 0;
			while(typeof fbuilder_items['items'][itemId]['options'][name]['items'][count] != 'undefined' && fbuilder_items['items'][itemId]['options'][name]['items'][count] != '')
				count++;
				
			var pos = 0;
			while(typeof fbuilder_items['items'][itemId]['options'][name]['order'][pos] != 'undefined')
				pos++;
			fbuilder_items['items'][itemId]['options'][name]['order'][pos] = count;
			
			html += '<div class="fbuilder_sortable_item fbuilder_collapsible" data-sortid="'+count+'" data-sortname="'+name+'"><div class="fbuilder_gradient fbuilder_sortable_handle fbuilder_collapsible_header">'+item_name+' '+count+' - <span class="fbuilder_sortable_delete">delete</span><span class="fbuilder_collapse_trigger">+</span></div><div class="fbuilder_collapsible_content">';
			fbuilder_items['items'][itemId]['options'][name]['items'][count] = {};
			for (var x in shortcodeJSON['options']) {
				var newControl = new fbuilderControl('fsort-'+count+'-'+x,shortcodeJSON['options'][x]);
				html += newControl.html();
				
				fbuilder_items['items'][itemId]['options'][name]['items'][count][x] = (typeof shortcodeJSON['options'][x]['std'] != 'undefined' ? shortcodeJSON['options'][x]['std'] : '');
			}
			html +='</div></div>';
			$(this).parent().find('.fbuilder_sortable').append(html);
			fbuilderRefreshControls($jq, $(this));
			fbuilderHideControls($('false'), true, $(this).parent().find('.fbuilder_sortable_item'));
			$('.fbuilder_shortcode_menu').trigger('fchange');
		});
		
		$(document).on('click', '.fbuilder_sortable_delete', function(){
			var $sortitem = $(this).parent().parent();
			var id = parseInt($sortitem.attr('data-sortid'));
			var name = $sortitem.attr('data-sortname');
			var itemId = parseInt($('.fbuilder_shortcode_menu').attr('data-modid'));
			var $sortable = $sortitem.parent();
			$sortitem.remove();
			delete fbuilder_items['items'][itemId]['options'][name]['items'][id];
			delete fbuilder_items['items'][itemId]['options'][name]['order'];
			fbuilder_items['items'][itemId]['options'][name]['order'] = {};
			$sortable.children('.fbuilder_sortable_item').each(function(index){
				fbuilder_items['items'][itemId]['options'][name]['order'][index] = parseInt($(this).attr('data-sortid'));
			});
			$('.fbuilder_shortcode_menu').trigger('fchange');
		});
		
		
		/* Shortcode collapsible control */
		
		$(document).on('click','.fbuilder_collapse_trigger', function(){
			var $content = $(this).parent().parent().children('.fbuilder_collapsible_content');
			if(!$(this).hasClass('active')) {
				$(this).html('-').addClass('active');
				$content.show();
			}
			else {
				$(this).html('+').removeClass('active');
				$content.hide();
			}
			fbuilderRefreshControls($jq, $(this));
			
		});
		
		/* Shortcode colorpicker control */
		
		$(document).on('focus', '.fbuilder_color', function(){
			$(this).parent().find('.fbuilder_colorpicker').addClass('active').show();
			setTimeout(function(){fbuilderRefreshControls($jq, $(this))},10);
		});
		$(document).on('mouseenter', '.fbuilder_color', function(){
			$(this).parent().find('.fbuilder_colorpicker').data('hover', true);
		});
		$(document).on('mouseleave', '.fbuilder_color', function(){
			$(this).parent().find('.fbuilder_colorpicker').data('hover', false);
		});
		
		$(document).on('mouseenter', '.fbuilder_colorpicker', function(){
			$(this).data('hover', true);
		});
		$(document).on('mouseleave', '.fbuilder_colorpicker', function(){
			$(this).data('hover', false);
		});
		
		$('body').click(function(){
			$('.fbuilder_colorpicker.active').each(function(){
				if(!$(this).data('hover')) {
					$(this).removeClass('active').hide();
					fbuilderRefreshControls($jq, $('false'));
				}
			});
		});
		$jq('body').on('mouseup', function(){
			$('body').trigger('mouseup');
		});
		
		/* Shortcode number control */
		$(document).on('keyup', '.fbuilder_number_amount', function(){
			var $this = $(this);
			$this.closest('.fbuilder_control').find('.fbuilder_number_bar').slider('value',parseInt($this.val()));
		});
		
		
		/* Shortcode change */
		
		$(document).on('fchange', '.fbuilder_shortcode_menu', function(){
			if(!$('.fbuilder_shortcode_menu:first').hasClass('fbuilder_rowedit_menu')) {
				var id = parseInt($(this).attr('data-modid'));
				var $module = $jq('.fbuilder_module[data-modid='+id+']:first');
				var f = fbuilder_items['items'][id]['f'];
				var holder = $module.find('.fbuilder_module_content:first');
				var options = fbuilder_items['items'][id]['options'];
				fbuilderGetShortcode(f, holder, options);
			}
			else {
				var id = parseInt($(this).attr('data-modid'));
				var $row = $jq('.fbuilder_row[data-rowid='+id+']:first');
				var options = fbuilder_items['rows'][id]['options'];
				fbuilderRowChange($row, options);
			}
		});
		
		$(document).on('click', '.ui-draggable', function(e){
			e.preventDefault();
		});
		
	}
	
})(jQuery);