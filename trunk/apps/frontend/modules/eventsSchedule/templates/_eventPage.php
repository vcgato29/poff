<?php use_javascript('/js/colorbox/jquery.colorbox-min.js') ?>
<?php use_stylesheet('/anima/colorbox/colorbox.css')?>

<?php slot('article') ?>
<div class="whitepage">
		<div class="arch_element_2">
			<img height="230" width="543" alt="#3" src="<?php echo @myPicture::getInstance($cover)->thumbnail(543,230,'center')->url()?>">
			<p class="arch_desc_2"><span style="color: <?php echo CustomizationHelper::getInstance()->dark($section) ?>; font: 38px/52px Arial,Helvetica,sans-serif;" class="desc_title_smaller"><?php echo $event['name'] ?></span><span style="color: <?php echo CustomizationHelper::getInstance()->dark($section) ?>; line-height: 36px; text-decoration: none;" class="desc_title_date"><?php echo date('d.m. H:i',strtotime($event['scheduled'])) ?></span></p>
        </div>
        <div class="big_text">
		<?php if($galleryFirstBanner && $galleryFirstBanner->getFile()): ?>
          <div class="bt_box">
            <div style="background-color: <?php echo CustomizationHelper::getInstance()->dark($section) ?>;" class="bt_title"><a class="iframe" href="<?php echo $bannersHelper->linkIframe($galleryFirstBanner['banner_group_id']) ?>"><?php echo __('Vaata ürituse pildigaleriid') ?></a></div>
            <div class="bt_pic">
				<a  class="iframe" href="<?php echo $bannersHelper->linkIframe($galleryFirstBanner['banner_group_id']) ?>">
					<img height="111" width="203" alt="" src="<?php echo @myPicture::getInstance($galleryFirstBanner->getFile())->thumbnail(203,111,'center')->url()?>">
				</a>
			</div>	
          </div>
		<?php endif; ?>
		<?php echo $event['longdescription'] ?>


			
		<?php foreach($siblings as $index => $sibling): ?>
			<?php if($sibling['id'] == $event['id']): ?>
				<?php if(isset($siblings[$index-1])): ?>
					<a style="background: url(<?php echo CustomizationHelper::getInstance()->prev($section) ?>) no-repeat scroll left top <?php echo CustomizationHelper::getInstance()->dark($section) ?>; color: <?php echo CustomizationHelper::getInstance()->font($section) ?>;" class="bt_prev" href="<?php echo $siblings[$index-1]['link'] ?>"><?php echo $siblings[$index-1]['title'] ?></a>
				<?php endif; ?>

				<?php if(isset($siblings[$index+1])): ?>
					<a style="background: url(<?php echo CustomizationHelper::getInstance()->next($section) ?>) no-repeat scroll right top <?php echo CustomizationHelper::getInstance()->dark($section) ?>; color: <?php echo CustomizationHelper::getInstance()->font($section) ?>;" class="bt_next" href="<?php echo $siblings[$index+1]['link'] ?>"><?php echo $siblings[$index+1]['title'] ?></a>
				<?php endif; ?>

				<?php break; ?>
			<?php endif; ?>
		<?php endforeach; ?>
		  
		</div>
</div>

<script type="text/javascript">
	$(".iframe").colorbox({width:"819px", height:"565px", iframe:true});
</script>
<?php end_slot() ?>