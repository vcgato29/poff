<?php 
/* 
 * @submitLink - send POST request
 * @commentsForm - CommentsForm instance
 * 
 */ 
?>

<div class="write">
	<div class="viga" >
	    <p style="color:red;">&nbsp; <?php if($sf_user->hasFlash('comments.form')):?><?php echo $sf_user->getFlash('comments.form') ?><?php endif;?></p>
	</div>
	
    <form id="commentsform" method="post" action="<?php echo $submitLink ?>">
    <?php echo $commentsForm->renderHiddenFields()?>
    <div class="inputbox">
    	<?php $class = $commentsForm['name']->hasError() ? 'writename errinput' : 'writename'?>
    	<?php $val = $commentsForm['name']->getValue() ? $commentsForm['name']->getValue() : __('Name')?>
		<?php echo $commentsForm['name']->render(array('class' => $class , 'title'=> __('Name'), 'value' =>  $val  ) )  ?>
	</div>
	<div class="area">
		<?php  $commentsForm->getWidgetSchema()->setDefault('message',__('Comment')); ?>
		<?php $class = $commentsForm['name']->hasError() ? 'commentarea errinput' : 'commentarea'?>
		<?php echo $commentsForm['message']->render(array('class' => $class, 'rows' => 4, 'cols' => 5, 'title'=>__('Comment') ) )?>
	</div>
	<div class="clear"></div>
	<div class="formbottom">
	    <img height="23" width="94" alt="" src="<?php echo url_for('sf_captchagd', array('r' => time() ) ) ?>">
		<div class="inputboxbottom">
			<?php $class = $commentsForm['captcha']->hasError() ? 'code errinput' : 'code'?>
			<?php echo $commentsForm['captcha']->render(array('class' => $class, 'title'=> __('Code'), 'value' => __('Code') ) )?>
		</div>
		<div id="submitcomment" class="button">
	        <a href="#"><?php echo __("Send")?></a>
	    </div>
	</div>
	</form>
	<div class="clear"></div>
</div>

<script type="text/javascript">
$('#submitcomment').click(function(e){
	e.preventDefault();
	$(this).hide();
	$('#commentsform').submit();
	return false;
});
</script>