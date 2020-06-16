jQuery(document).ready(function($){

	$(".social-media-popup").click(function(){

		window.open( $(this).attr("href"), "Share", "width=600,height=400" );
		return false;

	});
	
})