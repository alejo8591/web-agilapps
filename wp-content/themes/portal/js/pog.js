(function($){	

var preloaderURL = portal.directory+'/images/loader.gif';

var $mainWrap, $mainWrap2, $innerWrap, $initWrap, $window = $(window), fullHeight, $pogColumn, tContDownFlag = false, tContPosStart, tContPosEnd = 0, dragPos, dragPosFin, itemList = new Array(), itemSelector = 0, leastWidth, leastIndex, pogTimeout, mousedownTime = 0; mouseupTime = 0, timeDifference = 0, timeoutFlag = false, inertiaStartPosition = 0; inertiaEndPosition = 0, inertiaVal = 0, inertiaDifference = 0, clickFlag = false;

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

$(document).ready(function(){
	contReady();
});

$(window).load(function(){
	contLoad();
});	 
	
$(window).resize(function(){
	clearTimeout(pogTimeout);
	
		pogTimeout = setTimeout(function(){
			fullHeight = $window.height() - $('.header_placeholder').height();
			$mainWrap = $('.portal_gallery_wrapper');
			$mainWrap2 = $('.pog_inner_wrapper');
			mainWrap = '.portal_gallery_wrapper';
			$innerWrap = $('.portal_gallery_tube');
			$initWrap = $('.portal_gallery_init');
			innerWrap = '.portal_gallery_tube';
			$pogColumn = $('.pog_column');
			
		if ($(window).width()> 700) {
			controlV = true;
			if ($('.portal_gallery_init').length > 0) {
				contReady();
				contLoad();
			} 
			$mainWrap.removeClass('responsive').find('.pog_overlay_content, .portal_gallery_background').css({'height' : $(window).height()-$('.header_placeholder').height()});
			$innerWrap = $('.portal_gallery_tube');
			fullHeight = $window.height() - $('.header_placeholder').height();
			
			$mainWrap.css({'height' : fullHeight});
			$mainWrap2.css({'height' : fullHeight+50});
			$innerWrap.css({'height' : fullHeight, 'border-left-width' : $window.width()*2/5});
			
				var setHeight = $pogColumn.height();
				$mainWrap.find('.pog_column:first').css({'padding-top' : 0});
	
			
				$('.pog_image_wrapper').each(function(){
					$(this).find('img, video').css({'height' : $pogColumn.height()});
					$(this).css({'height' : $pogColumn.height(), 'width' : $(this).find('img, video').width()-1});
				});	
			
			itemMeasurement($innerWrap);
		}
		
		if ($(window).width()<= 700) {
			controlV = false;
			$mainWrap.addClass('responsive').css({'height' : 'auto'}).find('.pog_overlay_content, .portal_gallery_background').css({'height' : $(window).height()-$('.header_placeholder').height()});
			$mainWrap.find('.portal_gallery_init').css({'margin-top' : $(window).height() - $('.header_placeholder').height()});
			if($('.pog_column:first').children().length > 0){
				$mainWrap.find('.pog_column:first').css({'padding-top' : $(window).height() - $('.header_placeholder').height()});
			}
			
			$('.portal_gallery_wrapper.responsive .pog_image_wrapper').css({'width' : 'auto', 'height' : 'auto'}).children('img, video').css('height', 'auto');
			
			
		
		}
		
		if ($(window).width()> 700 && $('.portal_gallery_init').length <= 0) {
			$mainWrap.find('.pog_column:first').css({'padding-top' : 0});
		}

		}, 200);
});  


function itemStorage($storeThis) {
	$storeThis.find('.pog_image_wrapper').each(function(ind){
		itemList[ind] = $(this).clone();
	});	
	$storeThis.remove();
}

function itemSorter($sortThis) {
	var delayFactor = 0;
	var $rows = $sortThis.find('.pog_column');
	for (var i=0; i<$('.pog_column').length; i++) {
		$rows.eq(i).append(itemList[itemSelector]).data('width', $rows.eq(i).find('.pog_image_wrapper:last').width()+1);
		itemSelector++;
		delayFactor++;
	}
	
	while(typeof itemList[itemSelector] != 'undefined') {
		var indexVal = rowIndex($rows);
		var currentRow = $rows.eq(indexVal);
		currentRow.append(itemList[itemSelector]).find('.pog_image_wrapper').delay(delayFactor*100).animate({opacity : 1}, 400);
		currentRow.data({'width' : currentRow.data('width') + currentRow.find('.pog_image_wrapper:last').width()+1});
		if(currentRow.data('width') > $innerWrap.width()) {
			$innerWrap.width(currentRow.data('width')+10);
			$mainWrap.find('.portal_gallery_background .pog_parallax_obj').delay(500).animate({opacity : 1}, 400);
		} 
		itemSelector++;
		delayFactor++;
	}
}

function itemMeasurement($mThis) {
	$mThis.find('.pog_column').each(function(){
		var sum = 0;
		$(this).find('.pog_image_wrapper').each(function(){
			sum += $(this).width();
		});
		$(this).data('sum', sum);
	});
	
	var largest = $mThis.find('.pog_column').eq(0).data('sum');
	for (i=0;i < $mThis.find('.pog_column').length; i++) {
		var currentSum = $mThis.find('.pog_column').eq(i).data('sum');
		if (largest < currentSum) {
			largest = currentSum;
		}
	}
	
	$innerWrap.css({'width' : largest});	
}

function rowIndex($mThis) {
	leastWidth = $mThis.eq(0).data('width');
	leastIndex = 0;
	$mThis.each(function(ind){
		if($(this).data('width') < leastWidth) {
			leastWidth = $(this).data('width');
			leastIndex = ind;
		}
	});
	return leastIndex;
}

function contReady() {
		fullHeight = $window.height() - $('.header_placeholder').height();
		$mainWrap = $('.portal_gallery_wrapper');
		$mainWrap2 = $('.pog_inner_wrapper');
		mainWrap = '.portal_gallery_wrapper';
		$innerWrap = $('.portal_gallery_tube');
		if ($('.pog_column').length <= 0){
			$innerWrap.prepend('<div class="pog_column"></div><div class="pog_column"></div><div class="pog_column"></div>');
		}
		$initWrap = $('.portal_gallery_init');
		innerWrap = '.portal_gallery_tube';
		$pogColumn = $('.pog_column');
	if ($(window).width()> 700) {	
		
		$mainWrap.removeClass('responsive').find('.pog_overlay_content, .portal_gallery_background').css({'height' : $(window).height()-$('.header_placeholder').height()});
		$mainWrap.css({'height' : fullHeight}).prepend('<img src="'+preloaderURL+'" class="pog_preloader" />');
		$mainWrap2.css({'height' : fullHeight+50});
		$innerWrap.css({'height' : fullHeight, 'border-left-width' : $window.width()*2/5});
		
		$('.pog_image_wrapper').each(function(){
			$(this).css({'height' : $pogColumn.height()});
		});
	
	}
	if($mainWrap.find('.pog_overlay_content .centering_system').length <=0){
		$mainWrap.find('.pog_overlay_content').wrapInner('<div />').wrapInner('<div />').wrapInner('<div class="centering_system" />');
	}
	var touchFlag = false, touchstartRecord = 0, touchstartPosition = 0, touchstartPositionY = 0, galEnable = false, scrlRestrict;
	
	
	if (navigator.platform.indexOf("iPad") != -1 || navigator.platform.indexOf("iPhone") != -1) {
		$('video.pog_parallax_obj').hide();
	}
	
	$($innerWrap).on('mousedown', function(e) {	
		e.preventDefault();
		mousedownTime = e.timeStamp;
		touchstartRecord = $mainWrap2.scrollLeft();
		
		touchstartPosition = pointerEventToXY(e).x;
		touchstartPositionY = pointerEventToXY(e).y;
		touchFlag = true;
		clickFlag= true;
		scrlRestrict = true;
		galEnable = false;
	});
	
	$(document).on('mousemove', function(e) {
		
		if (Math.abs(touchstartPosition-pointerEventToXY(e).x) > Math.abs(touchstartPositionY-pointerEventToXY(e).y)) {
			if(scrlRestrict) {
				$('#wrapper').scrollBro('disable'); 
				scrlRestrict=false;
				galEnable = true;
			}
		} else {
			if(scrlRestrict) {$('#wrapper').scrollBro('enable'); scrlRestrict=false;}
		}
		
		if (!timeoutFlag) {
			inertiaStartPosition = pointerEventToXY(e).x;
			timeoutFlag = true;
			setTimeout(function(){
				inertiaEndPosition = pointerEventToXY(e).x;
				timeoutFlag = false;
			}, 30);
		}
		
		if(touchFlag && galEnable){
			currentLocPar =touchstartPosition - pointerEventToXY(e).x;
			$mainWrap2.scrollLeft(touchstartRecord+currentLocPar);
			clickFlag = Math.abs(touchstartRecord+currentLocPar) < 20 ? true : false;	
		}
		
				
	});
		
	$($innerWrap).on('mouseup', function(e){
		mouseupTime = e.timeStamp;
		timeDifference = mouseupTime - mousedownTime;
		if (timeDifference > 30) {timeDifference = 30;}
		if (typeof inertiaEndPosition === 'undefined') {
			inertiaEndPosition = pointerEventToXY(e).x; 
			timeoutFlag = false;
		}
		e.preventDefault();
		inertia();
		
		touchFlag = false;
		
		
	});
	
	
	$($innerWrap).on('touchstart', function(e) {	
		mousedownTime = e.timeStamp;
		touchstartRecord = $mainWrap2.scrollLeft();
		
		touchstartPosition = pointerEventToXY(e).x;
		touchstartPositionY = pointerEventToXY(e).y;
		touchFlag = true;
		clickFlag= true;
		scrlRestrict = true;
		galEnable = false;
	});
	
	$(document).on('touchmove', function(e) {
		
		if (Math.abs(touchstartPosition-pointerEventToXY(e).x) > Math.abs(touchstartPositionY-pointerEventToXY(e).y)) {
			if(scrlRestrict) {
				$('#wrapper').scrollBro('disable'); 
				scrlRestrict=false;
				galEnable = true;
			}
		} else {
			if(scrlRestrict) {$('#wrapper').scrollBro('enable'); scrlRestrict=false;}
		}
		
		if (!timeoutFlag) {
			inertiaStartPosition = pointerEventToXY(e).x;
			timeoutFlag = true;
			setTimeout(function(){
				inertiaEndPosition = pointerEventToXY(e).x;
				timeoutFlag = false;
			}, 30);
		}
		
	});
		
	$($innerWrap).on('touchend', function(e){
		mouseupTime = e.timeStamp;
		timeDifference = mouseupTime - mousedownTime;
		if (timeDifference > 30) {timeDifference = 30;}
		if (typeof inertiaEndPosition === 'undefined') {
			inertiaEndPosition = pointerEventToXY(e).x; 
			timeoutFlag = false;
		}

		touchFlag = false;
		
		
	});
	
	
	
	$(document).on('click', '.pog_image_wrapper', function(e){
		if (clickFlag && e.which === 1) {
			$(this).find('.integrated_gallery > a').eq(0).trigger('click');
		}
	});
	
		if ($(window).width()<= 700) {
			$mainWrap.addClass('responsive').css({'height' : 'auto'}).find('.pog_overlay_content, .portal_gallery_background').css({'height' : $(window).height()-$('.header_placeholder:first').height()});
			$mainWrap.find('.portal_gallery_init:first').css({'margin-top' : $(window).height() - $('.header_placeholder:first').height()});
			if($('.pog_column:first').children().length > 0){
				$mainWrap.find('.pog_column:first').css({'padding-top' : $(window).height() - $('.header_placeholder:first').height()});
			}
			if ($(window).width()<= 700 && $('.portal_gallery_init:first').length <= 0) {
				$($innerWrap).draggable( "disable" );
			}
			
		}	
		
	$mainWrap2.on('scroll', function(){
		if (navigator.platform.indexOf("iPad") != -1 || navigator.platform.indexOf("iPhone") != -1) {
			$('.pog_parallax_obj').css({'left' : 0});
		} else {
			$('.pog_parallax_obj').css({'left' : $(this).scrollLeft()/2});
		}
	});
}

function inertia()  {
	inertiaDifference = inertiaStartPosition - inertiaEndPosition;
	inertiaVal = $mainWrap2.scrollLeft() - timeDifference/30*(inertiaDifference);
	$mainWrap2.stop().animate({'scrollLeft' : inertiaVal}, 300, 'easeOutQuad');
}

function contLoad() {
	fullHeight = $window.height() - $('.header_placeholder').height();
	$mainWrap = $('.portal_gallery_wrapper');
	$mainWrap2 = $('.pog_inner_wrapper');
	mainWrap = '.portal_gallery_wrapper';
	$innerWrap = $('.portal_gallery_tube');
	$initWrap = $('.portal_gallery_init');
	innerWrap = '.portal_gallery_tube';
	$pogColumn = $('.pog_column');
	
	if ($(window).width()> 700)	 {
		$mainWrap.removeClass('responsive').find('.pog_overlay_content, .portal_gallery_background').css({'height' : $(window).height()-$('.header_placeholder:first').height()});
		fullHeight = $window.height() - $('.header_placeholder:first').height();
		
		$mainWrap.css({'height' : fullHeight}).find('.pog_preloader:first').remove();
		$mainWrap2.css({'height' : fullHeight+50});
		$innerWrap.css({'height' : fullHeight, 'width' : $mainWrap.width()});
		$innerWrap.find('.pog_column').each(function(){
			$(this).data('width', 0);
		});
		
		var setHeight = $pogColumn.height();
		
		$('.pog_image_wrapper').each(function(){
			$(this).find('img, video').css({'height' : setHeight});
			$(this).css({'height' : setHeight, 'width' : $(this).find('img, video').width()-1});
		});
			
		itemStorage($initWrap);
		itemSorter($innerWrap);
		
		var xLeft = $innerWrap.outerWidth(true)- $(window).width();	
	}
	
	if ($(window).width()<= 700) {
			$mainWrap.addClass('responsive').css({'height' : 'auto'}).find('.pog_overlay_content, .portal_gallery_background').css({'height' : $(window).height()-$('.header_placeholder').height()});
			$mainWrap.find('.portal_gallery_init').css({'margin-top' : $(window).height() - $('.header_placeholder').height()});
			if($('.pog_column:first').children().length > 0){
				$mainWrap.find('.pog_column:first').css({'padding-top' : $(window).height() - $('.header_placeholder').height()});
			}						
			
			
		}		
}

})(jQuery);