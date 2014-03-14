(function($){

//				Swipe Slider

var swiperInitTimeout;
var swiperSliderClone = new Array();

$(window).load(function(){
	$('.focused_swipe_slider').each(function(ind){
		$(this).addClass('focused_swiper_slider_'+ind);
		swiperSliderClone[ind] = $(this).clone();
		swiperInit($(this), ind);
		
		$('.js_swipe_slider_image').each(function(){
			var $this = $(this);
			$this.css({'left' : -($this.width() - $this.parent().width())/2, 'top' : -($this.height() - $this.parent().height())/2});
		});
	
	});
});

$(window).resize(function(){
	clearTimeout(swiperInitTimeout);
	swiperInitTimeout = setTimeout(function(){
		$('.focused_swipe_slider').each(function(ind){
			$(this).html(swiperSliderClone[ind].html());
			swiperInit($(this), ind);
		});
		
		$('.js_swipe_slider_image').each(function(){
			var $this = $(this);
			$this.css({'left' : -($this.width() - $this.parent().width())/2, 'top' : -($this.height() - $this.parent().height())/2});
		});
	}, 200);	
});

function swiperInit($mainSel, ind) {
	if ($mainSel.width() > 1200) {
		slidNumb = 4;
	} else if ($mainSel.width() <= 1200 && $mainSel.width() > 900){
		slidNumb = 3;
	} else if ($mainSel.width() <= 900 && $mainSel.width() > 600){
		slidNumb = 2;
	} else {
		slidNumb = 1;
	}
	
	var mySwiper = new Swiper('.focused_swiper_slider_'+ind+' .portal-swiper-container',{
	    slidesPerView: slidNumb,
	    scrollbar: {
	      container: '.focused_swiper_slider_'+ind+' .swiper-scrollbar',
	      draggable: true,
	      snapOnRelease: true,
		  hide:false
	    }
	});
}
})(jQuery);