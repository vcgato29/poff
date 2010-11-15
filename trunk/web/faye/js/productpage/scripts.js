$(document).ready(function() {
$("a[rel=example_group]").fancybox({
	'transitionIn'		: 'none',
	'transitionOut'		: 'none',
	'showCloseButton'   : 'true',
	'showNavArrows'     : 'true',
	'enableEscapeButton': 'true',
    'overlayOpacity'    : '0.8',
	'cyclic'            : 'true',
	'overlayColor'      : '#000',
	'titlePosition' 	: 'outside',
	'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
							return '<span id="fancybox-title-over">'+ (title.length ? ' &nbsp; ' + title : '') + '</span>';
						}
			});
$("a[rel=mail_link]").fancybox({
    'autoScale'     	: false,
    'transitionIn'		: 'none',
	'transitionOut'		: 'fade',
	'type'				: 'iframe'
});
});