<?php if($pictures): ?>
<?php
use_stylesheet('/js/fancybox/jquery.fancybox-1.3.1.css');
use_javascript('/js/fancybox/jquery.fancybox-1.3.1.pack.js');
use_javascript('/js/fancybox/jquery.easing-1.3.pack.js');
use_javascript('/js/fancybox/jquery.mousewheel-3.0.2.pack.js');
?>
<div class="ccontentleft">
	<div class="bigimg">
		<a rel="product_pictures" href="<?php echo @myPicture::getInstance($pictures[0]['file'])->url() ?>">
			<img src="<?php echo @myPicture::getInstance($pictures[0]['file'])->thumbnail(243, 243)->url() ?>" alt="" width="243" height="243">
		</a>
	</div>
	<div class="imgbottom">
		<?php for($i = 1; $i < count($pictures) && $i <= 3; ++$i): ?>
		<div class="imgbottom<?php echo $i % 2 == 0 ? 'center' : 'thumb' ?>">
			<a rel="product_pictures" href="<?php echo @myPicture::getInstance($pictures[$i]['file'])->url() ?>">
				<img src="<?php echo @myPicture::getInstance($pictures[$i]['file'])->thumbnail(74, 80)->url() ?>" alt="" width="74" height="80">
			</a>
		</div>
		<?php endfor; ?>
		<div class="clear"></div>
	</div>
</div>
<?php endif; ?>
<script type="text/javascript">
$(document).ready(function() {


$("a[rel=product_pictures]").fancybox({
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
});
</script>