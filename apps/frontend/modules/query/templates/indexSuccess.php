<?php slot('subject') ?>
	<h1><?php echo __('Küsi pakkumist') ?></h1>
<?php end_slot() ?>


<?php get_component('bottomArticlesWidget', 'render') ?>

<?php slot('content') ?>
<form id="contactform" action="" method="post">
<div class="boxinright">
	<div class="tellijakontakt">
		<div class="kontaktleft">
			<?php include_partial('query/contactForm',
						array('form' => $form, 'helper' => $helper)) ?>
		</div>
		<div class="kontaktright">
			<?php include_partial('query/contactAdditionalFormFields',
					array('form' => $form, 'helper' => $helper, 'attachments' => $attachments)) ?>
		</div>
	<div class="clear"></div>
	</div>
	<div class="roofbuttons">
		<div class="roofbluebutton konr">
			<div class="button submitbutton">
				<div class="link" style="display:none"><?php echo $helper->link('processContactForm') ?></div>
				<div class="buttontext"><a href="#">Saada</a></div>
			</div>
			<div class="button submitbutton">
				<div class="link" style="display:none"><?php echo $helper->link('processContactFormAndNext') ?></div>
				<div class="buttontext"><a href="#">Edasi</a></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>

	<?php include_partial('query/contactSubmitScript') ?>


	
</div>
</form>
<?php end_slot() ?>