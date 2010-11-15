<style>
#content {	position:absolute; 
			top:50%; 
			height:240px; 
			margin-top:-120px;/* negative half of the height */
			left:50%;
			width:330px;
			margin-left: -150px;
		}
</style>


<div id="content">
	<div style="float:left; height:50%; margin-bottom:-120px;">
<div style="clear:both; height:240px; position:relative;">

<div class="write" style="background-color:white;width:330px;margin:auto;padding:5px 0 5px;">
	<div class="viga" style="padding-left:10px;" >
		<?php if($sf_user->hasFlash('mail.form.error')):?>
	    	<p style="color:red;">&nbsp; <?php if($sf_user->hasFlash('mail.form.error')):?><?php echo __($sf_user->getFlash('mail.form.error')) ?><?php endif;?></p>
	    <?php else:?>
	    	<p><?php echo __('Send your friend a suggestion')?></p>
	    <?php endif;?>
	</div>
	
    <form style="padding:10px;" id="commentsform" method="post" action="<?php include_component('linker', 'product', array('product' => $product, 'category' => $category, 'action' => 'productSuggestionSubmit')) ?>">
    <?php echo $form->renderHiddenFields()?>
    <div class="inputbox" style="padding-bottom:5px;">
    	<?php $class = $form['sender_name']->hasError() ? 'writename errinput' : 'writename'?>
    	<?php $val = $form['sender_name']->getValue() ? $form['sender_name']->getValue() : __('Your name')?>	
		<?php echo $form['sender_name']->render(array('class' => $class , 'title'=> __('Your name'), 'value' =>  $val  ) )  ?>

    	<?php $class = $form['receiver_name']->hasError() ? 'writename errinput' : 'writename'?>
    	<?php $val = $form['receiver_name']->getValue() ? $form['receiver_name']->getValue() : __('Receiver name')?>	
		<?php echo $form['receiver_name']->render(array('class' => $class , 'title'=> __('Receiver name'), 'value' =>  $val  ) )  ?>		
		
	</div>
    <div class="inputbox">
    	<?php $class = $form['sender_email']->hasError() ? 'writename errinput' : 'writename'?>
    	<?php $val = $form['sender_email']->getValue() ? $form['sender_email']->getValue() : __('Your email')?>	
		<?php echo $form['sender_email']->render(array('class' => $class , 'title'=> __('Your email'), 'value' =>  $val  ) )  ?>
		
    	<?php $class = $form['receiver_email']->hasError() ? 'writename errinput' : 'writename'?>
    	<?php $val = $form['receiver_email']->getValue() ? $form['receiver_email']->getValue() : __('Receiver email')?>	
		<?php echo $form['receiver_email']->render(array('class' => $class , 'title'=> __('Receiver email'), 'value' =>  $val  ) )  ?>
	</div>
	<div class="area">
		<?php  $form->getWidgetSchema()->setDefault('message',__('Comment')); ?>
		<?php $class = $form['message']->hasError() ? 'commentarea errinput' : 'commentarea'?>
		<?php echo $form['message']->render(array('class' => $class, 'rows' => 4, 'cols' => 5, 'title'=>__('Comment') ) )?>
	</div>
	<div class="clear"></div>
	<div class="formbottom">
	    <img height="23" width="94" alt="" src="<?php echo url_for('sf_captchagd', array('r' => time() ) ) ?>">
		<div class="inputboxbottom">
			<?php $class = $form['captcha']->hasError() ? 'code errinput' : 'code'?>
			<?php echo $form['captcha']->render(array('class' => $class, 'title'=> __('Code'), 'value' => __('Code') ) )?>
		</div>
		
		<div id="submitcomment" class="button">
	        <a href="#"><?php echo __("Send")?></a>
	        <img style="display:none;float:left" id="loader" alt="" src="/faye/ajax-loader.gif" />
	    </div>
	    
	</div>
	</form>
	<div class="clear"></div>
</div>

</div>

</div>

</div>

<script type="text/javascript">
$('input,textarea').clearInputDescription(); 

$('#submitcomment').click(function(e){
	e.preventDefault();
	$('a',this).hide();
	$(this).css('background', "url('')");
	$('#loader').show();
	
	$('#commentsform').submit();
	return false;
});
</script>
