(function($){	

var mySwiper, swAjaxArray = new Array(), swAjaxSel = 0;

$(document).ready(function(){
	var slidNumb = 1;
	var slidClone;
	var slicedInitTimeout;
	
	if ($('.swiper-slide').length <= 5) {
		slidNumb = $('.swiper-slide').length;
	}
	
	if (Math.floor($(window).width()/280) < $('.swiper-slide').length) {
		slidNumb =  Math.floor($(window).width()/280);
	}

	if(slidNumb > 5){slidNumb = 5;}
	if(slidNumb <= 0){slidNumb = 1;}
	
	
		slidClone = $('.sliced_preview_container').clone();

	  
$(window).load(function(){
	  var contaner_width = $('.sliced_preview_image_wrap:first').outerWidth();
	  var container_height = $(window).height() - $('.header_placeholder').height();
	
	  
		$(".sliced_preview_image").each(function(){
			$this = $(this);
			if(Math.abs($this.height() - container_height) < Math.abs($this.width() - contaner_width)){
				$this.css({height: container_height, 'width' : 'auto'}).css({left : -($this.width() - contaner_width)/2});
			} else {
				$this.css({height: 'auto', 'width' : contaner_width}).css({top : -($this.height() - container_height)/2});
			}
			
			$this.closest('.portal-swiper-container').css('height', container_height);
			$this.parent().parent().parent().css('height', container_height);
			$this.parent().parent().css('height', container_height);
			$this.animate({opacity : 0.8}, 500);
		});
});	 
	
	
$(window).resize(function(){
	$('.sliced_preview_container').find('.portal-swiper-container').css({opacity : 0});
	clearTimeout(slicedInitTimeout);
	slicedInitTimeout = setTimeout(function(){
		
		if ($('.swiper-slide').length < 5) {
			slidNumb = $('.swiper-slide').length;
		}
		
		if (Math.floor($(window).width()/280) < $('.swiper-slide').length) {
			slidNumb =  Math.floor($(window).width()/280);
		}
		if(slidNumb > 5){slidNumb = 5;}
		if(slidNumb <= 0){slidNumb = 1;}
		
		$('.sliced_preview_container').html(slidClone.html());
		$('.sliced_preview_image').animate({opacity :0.8}, 1000);
		
		swiperInitFn(slidNumb);
		 
		
	  var contaner_width = $('.sliced_preview_image_wrap:first').outerWidth();
	  var container_height = $(window).height() - $('.header_placeholder').height();
		
		$(".sliced_preview_image").load(function(){
			$this = $(this);
			if(Math.abs($this.height() - container_height) < Math.abs($this.width() - contaner_width)){
				$this.css({height: container_height, 'width' : 'auto'}).css({left : -($this.width() - contaner_width)/2});
			} else {
				$this.css({height: 'auto', 'width' : contaner_width}).css({top : -($this.height() - container_height)/2});
			}
			$this.closest('.portal-swiper-container').css('height', container_height);
			$this.parent().parent().parent().css('height', container_height);
			$this.parent().parent().css('height', container_height);
			$this.animate({opacity : 0.8}, 500);
		});
		$('.sliced_preview_container').find('.portal-swiper-container').css({opacity : 1});
	}, 300);
});  
	  
	
	 
  swiperInitFn(slidNumb);
	
  
});	

function swiperInitFn(slidNumb) {
	mySwiper = [];
	mySwiper = new Swiper('.portal-swiper-container',{
	    slidesPerView: slidNumb,
	    resizeReInit: true,
		

	    //Enable Scrollbar
	    scrollbar: {
	      container: '.swiper-scrollbar',
	      hide: false,
	      snapOnRelease: true,
	    }
	  });  
}



})(jQuery);