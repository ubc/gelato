jQuery("#navbar-choose a").click( function(e) {
	jQuery("#navbar-choose li").removeClass('active');
	var class_name = jQuery(this).attr('href');
	jQuery(this).parent().addClass('active');	
	class_name = class_name.substring(1); 
	jQuery('#gelato-shell-pad').removeClass("presentation-in-video video-in-presentation stacked").addClass( class_name );
	$
	e.preventDefault();
});