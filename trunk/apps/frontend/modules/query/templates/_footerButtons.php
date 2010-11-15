<div class="roofbuttons">
    <div class="roofblackbutton">
        <div class="blackbutton">
            <div class="blackbuttontext"><a href="<?php echo $helper->link('simple') ?>"><?php echo __('Katkesta') ?></a></div>
        </div>
    </div>
    <div class="roofbluebutton">
        <div class="button nextsubmit">
            <div class="buttontext"><a href="#"><?php echo __('Edasi') ?></a></div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	$('.nextsubmit').click(function(e){
		e.preventDefault();

		$(this).parents('form').submit();

		return false;
	});
});
</script>