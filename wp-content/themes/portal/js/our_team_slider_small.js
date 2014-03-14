(function($){
	
	var animSpeed = 300, refHeight, sliderWidthFactor, tm, controlDisabler = new Array(false,false), currentFirstElPos = 0, tContPosStart, tContPosEnd, tContDefVal, tContDownFlag = false, dragPos, tInBlockFlag = false, recalcVar, calcVar;
	
$(document).ready(function(){
	$('.ots_small_slider').data('current-first', 0);
	measurementCalculation();
	controlDisablerLogic();
	$('.ots_small_wrapper').hover(function(){tInBlockFlag = true;}, function(){tInBlockFlag = false;});
	
	$(document).on('click', '.ots_next-small', function(e){
		e.preventDefault();
		controlNext();
	});
	
	$(document).on('click', '.ots_prev-small', function(e){
		e.preventDefault();
		controlPrev();
	});
	
	$(document).on('mousedown touchstart', '.ots_small_wrapper', function(e){
		e.preventDefault();
		tContDownFlag = true;
		tContPosStart =  pointerEventToXY(e).x;
		tContDefVal =  parseInt($('.ots_small_inner_wrap').css('left'));
		dragPos = parseInt(tContDefVal) - tContPosStart;
		$('.ots_small_inner_wrap').parent().addClass('mousedown');
	});
	
	$(document).on('mousemove touchmove', '.ots_small_wrapper', function(e){
		if (tContDownFlag && tInBlockFlag) {
			dragPosFin = dragPos + pointerEventToXY(e).x;
			$('.ots_small_inner_wrap').css({'left' : dragPosFin});	
		}	
	});
	
	$(document).on('mouseup touchend', '.ots_small_wrapper', function(e){
		tContDownFlag = false;
		tContPosEnd = parseInt($('.ots_small_inner_wrap').css('left')) +pointerEventToXY(e).x;
		
		if (tContPosEnd-pointerEventToXY(e).x > 0) {
			sliderMovement(0);
		} else if (tContPosEnd-pointerEventToXY(e).x < -$('.ots_small_inner_wrap').width() + $('.ots_small_slider').width()){
			sliderMovement($('.ots_small_item').length-$('.ots_small_slider').data('factor'));
		}
		
		calcVar = parseInt($('.ots_small_inner_wrap').css('left'))/itemWidth;
		
		if(calcVar < 0) {
			if (Math.abs(calcVar) - Math.floor(Math.abs(calcVar)) > 0.5) {
				recalcVar = Math.ceil(Math.abs(calcVar));
			} else {
				recalcVar = Math.floor(Math.abs(calcVar));
			}
			if(recalcVar <= $('.ots_small_item').length-$('.ots_small_slider').data('factor')) {
				sliderMovement(recalcVar);
			}
		}
		$('.ots_small_inner_wrap').parent().removeClass('mousedown');	
	});
	
	$(document).on('mouseleave', '.ots_small_wrapper', function(e){
		if(typeof e.originalEvent !== 'undefined') {
			$(this).trigger('mouseup');
		}
	});
});

$(window).resize(function(){
	clearTimeout(tm);
	tm = setTimeout(function(){
			measurementCalculation();
			resizeRecalculate();
			controlDisablerLogic();
		},100);
	
});

$(window).load(function(){
	measurementCalculation();
	resizeRecalculate();
	controlDisablerLogic();
});
	
function sliderMovement(newPos) {
	itemWidth = $('.ots_small_item').eq(0).outerWidth(true);
	$('.ots_small_inner_wrap').stop(true).animate({'left' : -newPos*itemWidth}, animSpeed);
	$('.ots_small_slider').data('current-first', newPos);	
	controlDisablerLogic();
}

function controlNext() {
	if (!controlDisabler[1]) {
		sliderMovement($('.ots_small_slider').data('current-first')+1);	
	}
}

function controlPrev() {
	if(!controlDisabler[0]){
		sliderMovement($('.ots_small_slider').data('current-first')-1);	
	}
}
	
function controlDisablerLogic() {
	currentFirstElPos = $('.ots_small_slider').data('current-first');
	if (currentFirstElPos == 0) {controlDisabler[0] = true;} else {controlDisabler[0] = false;}
	if (currentFirstElPos + $('.ots_small_slider').data('factor')-1 >=  $('.ots_small_item').length-1){controlDisabler[1] = true;} else {controlDisabler[1] = false;}
	for (i=0; i < 2; i++) {
		if(controlDisabler[i]){$('.our_team_controls_wrap-small > a').eq(i).addClass('disabled');}
		else{$('.our_team_controls_wrap-small > a').eq(i).removeClass('disabled');}
	}
}

function measurementCalculation(){	
	refHeight = $('.ots_small_item').eq(0).height();
	$('.ots_small_item').each(function(ind){
		if($(this).height() > refHeight) {
			refHeight = $(this).height();
		}
	});
	
	itemWidth = $('.ots_small_item').eq(0).outerWidth(true);
	sliderWidthFactor = Math.floor(($(window).width()-40)/itemWidth);
	if (sliderWidthFactor > 4) {sliderWidthFactor = 4;} else if (sliderWidthFactor < 1) {sliderWidthFactor = 1;}
	
	$('.ots_small_slider').css({'height' : refHeight, 'width' : sliderWidthFactor*itemWidth+1}).data('factor', sliderWidthFactor);
	$('.ots_small_inner_wrap').css({'height' : refHeight, 'width' : $('.ots_small_item').length*itemWidth+1});
	$('.ots_small_wrapper').css({'height' :$(window).height()-$('.header_placeholder').height(), 'min-height' : refHeight + 200});
}

function resizeRecalculate() {
	if($('.ots_small_slider').data('current-first') >= $('.ots_small_item').length-$('.ots_small_slider').data('factor')+1) {
		sliderMovement($('.ots_small_item').length-$('.ots_small_slider').data('factor'));
	} else {
		sliderMovement($('.ots_small_slider').data('current-first'));
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
	
addEvent(document, "mouseout", function(e) {
    e = e ? e : window.event;
    var from = e.relatedTarget || e.toElement;
    if (!from || from.nodeName == "HTML") {
    $('.ots_small_wrapper').trigger('mouseup');
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