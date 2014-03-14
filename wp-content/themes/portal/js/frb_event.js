(function($){

var swiperInitTimeout;
var swiperSliderClone = new Array();

$(document).on('refresh','#fbuilder_wrapper', function(){
	$('#wrapper').scrollBro('refresh');
});


$(document).on('refresh','.fbuilder_module', function(){

	$('#wrapper').scrollBro('refresh');

	$(this).find('.focused_swipe_slider').each(function(ind){
		$(this).addClass('focused_swiper_slider_'+ind);
		swiperSliderClone[ind] = $(this).clone();
		swiperInit($(this), ind);
		
		$('.js_swipe_slider_image').each(function(){
			var $this = $(this);
			$this.css({'left' : -($this.width() - $this.parent().width())/2, 'top' : -($this.height() - $this.parent().height())/2});
		});

	});

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