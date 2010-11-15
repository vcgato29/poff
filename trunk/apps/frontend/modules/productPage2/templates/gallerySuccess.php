<?php get_component('categoriesLeftMenuWidget', 'render') ?>
<?php get_component('bottomArticlesWidget', 'render') ?>


<?php slot('tabbox') ?>
    <div class="tabbox">
        <div class="tabpealkiri"><h2><?php echo __('Toode galerii') ?></h2></div>
        
            <?php foreach($pictures as $index => $pic): ?>
            <?php if($index % 3 == 0): ?>
            <div class="tabgallery">
            <?php endif; ?>
            

                <?php
                switch($index % 3){
                    case '0':
                        $class = 'left';
                        break;
                    case '1':
                        $class = 'center';
                        break;
                    case '2':
                        $class = 'right';
                        break;
                }

                ?>
                <div class="tg<?php echo $class ?>">
                    <a rel="pic_group" href="<?php echo @myPicture::getInstance($pic['file'])->url() ?>" title="<?php echo $pic['name'] ?>"><img width="178" height="136" alt="" src="<?php echo @myPicture::getInstance($pic['file'])->thumbnail(178,136,'center')->url() ?>"></a>
                </div>


                <?php if($index % 3 == 2 || $index + 1 == count($pictures)): ?>
                <div class="clear"></div>
                </div>
                <?php endif?>
                        
            <?php endforeach; ?>

    </div>



<script type="text/javascript">
	$("a[rel=pic_group]").fancybox({
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

</script>
<?php end_slot() ?>


<?php include_component('productPage', 'pageLayout') ?>