(function($){
	
var headerHeight, 
	resizeTimer, 
	indexStorage = new Array(), 
	animSpeed = 250, 
	ourTeamResponsive, 
	tContPosStart, 
	tContPosEnd, 
	tContDefVal, 
	tContDownFlag = false, 
	dragPos,
	$mouseMoveItemSel,
	trigCtrl = true,
	trigBlock = false,
	trigBlock2 = false,
	tm,
	tm2
	;


$(document).ready(function(){
	if ($('.our_team_slider_wrapper').width() < 510) {ourTeamResponsive = true;} else {ourTeamResponsive = false;}
	headerHeight = $('.header_placeholder').height();
	$('.our_team_slider_wrapper').each(function(){
		if (ourTeamResponsive) {
			$(this).css({'height' : ($(window).height()-headerHeight)*1.5});
		} else {
			$(this).css({'height' : $(window).height()-headerHeight});			
		}
		var $imgSel;
		$(this).find('.our_team_slide').each(function(){
			$('<img src="'+portal.directory+'/images/our_team/loader.gif" alt="" class="our_team_preloader block" />').insertAfter($(this).children('.member_img_big'));
		});
	});

	
	$('.our_team_slider_wrapper .member_img_big').each(function(){
		if(typeof $(this).attr('src') !== 'undefined'){
				var $imgSel = $(this);
				$(this).load(function(){
					imagePositioning($imgSel);
					$imgSel.animate({opacity : 1}, 300);
					$imgSel.siblings('.our_team_preloader').remove();
				});	
		}
	});
	
	$('.our_team_slider_wrapper').each(function(ind){
		$(this).data('slidecount', $(this).find('.our_team_slide').length);
		$(this).find('.ots_prev').addClass('disabled');
		if($(this).find('.our_team_slide').length < 1) {
			$(this).find('.ots_next').addClass('disabled');
		} else {
			$(this).find('.ots_next').removeClass('disabled');
		}
		$(this).find('.our_team_slide').each(function(ind2){
			$(this).addClass('ots-'+ind+'_sl-'+ind2).data('parindex', ind).data('index', ind2).css({'left' : $(this).closest('.our_team_slider_wrapper').width()*ind2});	
		});
		
		indexStorage[ind] = $(this).find('.ots_current').data('index');
		var $currSel = $(this).find('.ots_current');
		$(this).find('.our_team_controls_wrap .ots_prev').data('target', indexStorage[$currSel.data('parindex')]-1);
		$(this).find('.our_team_controls_wrap .ots_next').data('target', indexStorage[$currSel.data('parindex')]+1);
	});
	
	$(document).on('click', '.our_team_controls_wrap a', function(e){
		e.preventDefault();
		slideAnimation($(this));
		ctrlManipulation($(this));
	});
	
	$(document).on('mousedown touchstart', '.our_team_slider_wrapper', function(e){
		e.preventDefault();
		tContDownFlag = true;
		tContPosStart = pointerEventToXY(e).x;
		tContDefVal = -$(this).find('.ots_current').data('index')*$(this).closest('.our_team_slider_wrapper').width();
		dragPos = parseInt(tContDefVal) - tContPosStart;
		$(this).addClass('mousedown');
	});
	
	$(document).on('mousemove touchmove', '.our_team_slider_wrapper', function(e){
		if (tContDownFlag) {
			dragPosFin = dragPos + pointerEventToXY(e).x;
			if($mouseMoveItemSel == undefined){
				$mouseMoveItemSel = $(this).find('.our_team_slide_container');	
			}
			$mouseMoveItemSel.css({'left' : dragPosFin});
			
		}
		
	});
	
	$(document).on('mouseup touchend', '.our_team_slider_wrapper', function(e){
		tContDownFlag = false;
		tContPosEnd = pointerEventToXY(e).x;
		sliderSwipeTrigger($(this));
		$(this).removeClass('mousedown');	
	});
	
});	

$(window).load(function(){
	$('.our_team_slider_wrapper').each(function(ind){
		$(this).find('.our_team_slide').each(function(ind2){
			imagePositioning($(this).children('.member_img_big'));
			$(this).children('.member_img_big').animate({opacity : 1}, 300);
			$(this).children('.our_team_preloader').remove();
			$(this).css({'left' : $(this).closest('.our_team_slider_wrapper').width()*ind2});
			
		});
	});
});

$(window).resize(function(){
	if ($('.our_team_slider_wrapper').width() < 510) {ourTeamResponsive = true;} else {ourTeamResponsive = false;}
	clearTimeout(resizeTimer);
	resizeTimer = setTimeout(function(){
		headerHeight = $('.header_placeholder').height();
		$('.our_team_slider_wrapper').each(function(){
			if (ourTeamResponsive) {
				$(this).find('.ots_slide_content').css({'left':0});
				$(this).css({'height' : ($(window).height()-headerHeight)*1.5});
			} else {
				$(this).css({'height' : $(window).height()-headerHeight});
			}
			$(this).children('.our_team_slide').each(function(ind){
				imagePositioning($(this).children('.member_img_big'));
			});
		});
		$('.our_team_slider_wrapper').each(function(ind){
			$(this).find('.our_team_slide').each(function(ind2){
				$(this).css({'left' : $(this).closest('.our_team_slider_wrapper').width()*ind2});	
			});
			$(this).find('.our_team_slide_container').css({'left' : -$(this).find('.ots_current').data('index')*$(this).width()});
		});
	}, 200);
});	
	
function slideAnimation($sThis) {
	if(($sThis.hasClass('ots_next') || $sThis.hasClass('ots_prev')) && !$sThis.hasClass('disabled')) {
		$sThis.closest('.our_team_slider_wrapper').find('.ots_current').removeClass('ots_current');
		$sThis.closest('.our_team_slider_wrapper').find('.our_team_slide .ots_slide_content').animate({'left' : '100%', opacity:0}, animSpeed);
		$sThis.closest('.our_team_slider_wrapper').find('.our_team_slide').eq($sThis.data('target')).addClass('ots_current');	
		$sThis.closest('.our_team_slider_wrapper').find('.our_team_slide_container').animate({'left' : -$sThis.closest('.our_team_slider_wrapper').find('.ots_current').data('index')*$sThis.closest('.our_team_slider_wrapper').width()}, animSpeed*1.4, function(){
			if(ourTeamResponsive) {
				contentPosition = 0;
			} else {
				contentPosition = '90px';
			}
			
			$sThis.closest('.our_team_slider_wrapper').find('.ots_current .ots_slide_content').animate({'left' : contentPosition, opacity:1}, animSpeed);
		});
	}
}

function ctrlManipulation($cThis) {
	var controlDisabler = new Array();
	var $currSel = $cThis.closest('.our_team_slider_wrapper').find('.ots_current');
	indexStorage[$currSel.data('parindex')] = $currSel.data('index');
		controlDisabler = [indexStorage[$currSel.data('parindex')]-1, indexStorage[$currSel.data('parindex')]+1];
		$cThis.closest('.our_team_slider_wrapper').find('.our_team_controls_wrap .ots_prev').data('target', indexStorage[$currSel.data('parindex')]-1);
		$cThis.closest('.our_team_slider_wrapper').find('.our_team_controls_wrap .ots_next').data('target', indexStorage[$currSel.data('parindex')]+1);
		if (controlDisabler[0] < 0) {
			$cThis.closest('.our_team_slider_wrapper').find('.our_team_controls_wrap .ots_prev').addClass('disabled');
		} else {
			$cThis.closest('.our_team_slider_wrapper').find('.our_team_controls_wrap .ots_prev').removeClass('disabled');
		}
		
		if (controlDisabler[1] >= $cThis.closest('.our_team_slider_wrapper').data('slidecount')) {
			$cThis.closest('.our_team_slider_wrapper').find('.our_team_controls_wrap .ots_next').addClass('disabled');
		} else {
			$cThis.closest('.our_team_slider_wrapper').find('.our_team_controls_wrap .ots_next').removeClass('disabled');
		}
}
function imagePositioning($imgSel) {
	if (ourTeamResponsive) {
		$imgSel.css({'top' :  -($imgSel.height() - ($(window).height()*1.5-headerHeight))/2});
	} else {
		$imgSel.css({'top' :  -($imgSel.height() - ($(window).height()-headerHeight))/2});
	}
}	

var pointerEventToXY = function(e){
  var out = {x:0, y:0};
  if(e.type == 'touchstart' || e.type == 'touchmove' || e.type == 'touchend' || e.type == 'touchcancel'){
    var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
    out.x = touch.pageX;
    out.y = touch.pageY;
  } else if (e.type == 'mousedown' || e.type == 'mouseup' || e.type == 'mousemove' || e.type == 'mouseover'|| e.type=='mouseout' || e.type=='mouseenter' || e.type=='mouseleave') {
    out.x = e.pageX;
    out.y = e.pageY;
  }
  return out;
};

function sliderSwipeTrigger($cThis) {
		if (tContPosStart - tContPosEnd < -150 && !trigBlock) {
			trigCtrl = false;
			trigBlock = true;
			if ($cThis.find('.our_team_controls_wrap .ots_prev').hasClass('disabled')) {
				$cThis.closest('.our_team_slider_wrapper').find('.our_team_slide_container').animate({'left' : tContDefVal}, 150);
			}
			$cThis.find('.our_team_controls_wrap .ots_prev').trigger('click');	
			tm = setTimeout(function(){
				trigBlock = false;
			}, 500);
			
		} else {
			trigCtrl = true;
		}
	
		if ((tContPosStart - tContPosEnd > 150) && !trigBlock2) {
			trigCtrl = false;
			trigBlock2 = true;
			if ($cThis.find('.our_team_controls_wrap .ots_next').hasClass('disabled')) {
				$cThis.closest('.our_team_slider_wrapper').find('.our_team_slide_container').animate({'left' : tContDefVal}, 150);
			}
			$cThis.find('.our_team_controls_wrap .ots_next').trigger('click');
			tm2 = setTimeout(function(){
				trigBlock2 = false;
			}, 500);
			
		} else {
			trigCtrl = true;
		}
		tContDefVal = -$cThis.find('.ots_current').data('index')*$cThis.width();
		if (trigCtrl) {
			$cThis.closest('.our_team_slider_wrapper').find('.our_team_slide_container').animate({'left' : tContDefVal}, 150);
		}
}

addEvent(document, "mouseout", function(e) {
    e = e ? e : window.event;
    var from = e.relatedTarget || e.toElement;
    if (!from || from.nodeName == "HTML") {
    $('.our_team_slider_wrapper').trigger('mouseup');
    }
});

function addEvent(obj, evt, fn) {
    if (obj.addEventListener) {
        obj.addEventListener(evt, fn, false);
    }
    else if (obj.attachEvent) {
        obj.attachEvent("on" + evt, fn);
    }
}
	
})(jQuery);