//Pretty photo

jQuery(function($) {

	$("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'pp_default',
		allow_resize: true,
		default_width: 700,
		default_height: 393,
		autoplay: true,
		keyboard_shortcuts: true,
		social_tools: false,
		deeplinking:false,
		changepicturecallback: function(){
		},
	});
	
});