<?php slot('bannerCycleWidget')?>
<?php use_javascript('/olly/js/jquery.jcarousel.min.js') ?>
<?php use_javascript('/olly/js/jquery.jcarousel.js') ?>

<div id="mycarousel" class="jcarousel-skin-tango">
<div class="maingallery">
    <ul>
        <?php foreach($banners as $banner): ?>
		<li><a href="<?php echo $banner['link'] ?>"><img width="573" height="382" src="<?php echo @myPicture::getInstance( $banner->getPicture() )->thumbnail(573,382,'center')->url()?>" alt="" /></a></li>
        <?php endforeach;?>
    </ul>
    <div class="jcarousel-control">
        <div class="pagebox" style="margin-left:-<?php echo 20 * count($banners)?>px">
            <div class="pageboxleft"><img src="/olly/img/pageboxleft.png" width="1" height="22" alt=""/></div>
            <div class="pageboxcenter">
                    <div class="numbers">
                        <?php foreach($banners as $index => $banner): ?>
                            <div id="number<?php echo $index+1 ?>" class="number <?php if($index == 0): ?>activenumb<?php endif; ?>"><a href="#"><?php echo $index + 1?></a></div>
                            <?php if($index + 1 != count($banners)): ?>
                            <div class="line"><img src="/olly/img/line.png" width="1" height="22" alt=""/></div>
                            <?php endif;?>
                        <?php endforeach;?>

                    </div>
                <div class="clear"></div>
            </div>
            <div class="pageboxright"><img src="/olly/img/pageboxright.png" width="2" height="22" alt=""/></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
</div>
<div class="gallerybottom"><img src="/olly/img/gallshadowbottom.jpg" width="574" height="10" alt=""/></div>

<!-- additional banners -->
<?php foreach($logos as $index => $logo): ?>
    <?php if($index % 2 == 0): ?><div class="banners"><?php endif; ?>

        <div class="<?php if($index % 2 == 0): ?>leftbanner<?php else: ?>rightbanner<?php endif; ?>">
                <a href="<?php echo $logo['link'] ?>"><img src="<?php echo @myPicture::getInstance( $logo->getPicture() )->thumbnail(267,215,'center')->url()?>" width="267" height="215" alt=""/></a>
        </div>
    <?php if($index % 2  == 1 || $index == count($logos) - 1): ?></div> <div class="clear"></div><?php endif; ?>
<?php endforeach; ?>
<div class="clear"></div>



<script type="text/javascript">
var slider_scroll_timeout = 3500;
var slider_current_index = 1;
var slider_user_interacted = false;
var slider_loaded_instance;

function mycarousel_initCallback(carousel) {

    slider_loaded_instance = carousel;
    

    jQuery('.number').bind('click', function() {

        if(slider_loaded_instance.animating) return false;

        carousel.options.auto = 0;
        
        

        var clickedIndex  = jQuery.jcarousel.intval(jQuery('a',this).text());

        var currentActualIndex = getActualIndex(slider_current_index);

        var dif = clickedIndex - currentActualIndex;
        slider_loaded_instance.scroll(slider_current_index + dif);

        
        return false;
    });


    jQuery('.jcarousel-scroll select').bind('change', function() {
        carousel.options.scroll = jQuery.jcarousel.intval(this.options[this.selectedIndex].value);
        return false;
    });

    jQuery('#mycarousel-next').bind('click', function() {
        carousel.next();
        return false;
    });

    jQuery('#mycarousel-prev').bind('click', function() {
        carousel.prev();
        return false;
    });
};


function mycarousel_newItemVisible(carousel, obj, index, state){
    slider_current_index = index;
    showgallery('number' + getActualIndex(index));
}

function getActualIndex(ind){
    var itemsTotal = $('.number').size();

    return ((ind - 1) % (itemsTotal) + 1);
}

function showgallery (id1)
{
       $('.number').removeClass("activenumb");
	   $('#'+id1).addClass("activenumb");
}


// Ride the carousel...
jQuery(document).ready(function() {
    jQuery("#mycarousel").jcarousel({
        scroll: 1,
        auto: 2,
        wrap: 'circular',
        initCallback: mycarousel_initCallback,
        buttonNextHTML: null,
        buttonPrevHTML: null,
        itemVisibleInCallback: {
            onAfterAnimation: mycarousel_newItemVisible
        }
    });



});
</script>

<?php end_slot()?>