(function($){

$(document).ready(function(){

	if ( $('#video').length > 0 ) {
		var video = $('#video').delay(500).get(0).play();
	}

	$('.admin-bar .header_wrapper, .admin-bar .responsive_menu_button').css({'top' : $('#wpadminbar').height()});

});

var adminTimeout;
$(window).resize(function(){
	clearTimeout(adminTimeout);
	adminTimeout = setTimeout(function(){$('.admin-bar .header_wrapper, .admin-bar .responsive_menu_button').css({'top' : $('#wpadminbar').height()});}, 200);
});

})(jQuery);