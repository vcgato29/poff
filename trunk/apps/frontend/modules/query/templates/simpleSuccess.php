<?php get_component('categoriesLeftMenuWidget', 'render') ?>
<?php get_component('bottomArticlesWidget', 'render') ?>


<?php slot('tabbox') ?>
<div class="tabbox">
    <div class="tabpealkiri"><h2><?php echo __('Küsi pakkumist') ?></h2></div>
    <div class="pakkumine">
        <?php include_component('query', 'leftMenu') ?>


		<form id="contactform" action="" method="post">
		<div class="pakkumineright">
        <?php include_partial('query/contactForm',
							array('form' => $form, 'helper' => $helper)) ?>

		<div class="formosa">
			<img width="333" height="14" alt="" src="/olly/img/formsraz.png">
		</div>

		<?php include_partial('query/contactAdditionalFormFields',
				array('form' => $form, 'helper' => $helper, 'attachments' => $attachments)) ?>


		<div class="blackbuttonbox">
			<div class="button submitbutton">
				<div class="link" style="display:none"><?php echo $helper->link('processContactForm') ?></div>
				<div class="buttontext"><a href="#"><?php echo __('Saada') ?></a></div>
			</div>
		</div>
		<div class="clear"></div>

		<?php if(isset($product) && $product['parameter'] == 'roof_product'): ?>
		<div class="blackbuttonbox">
			<div class="button submitbutton">
				<div class="link" style="display:none"><?php echo $helper->link('processContactFormAndNext') ?></div>
				<div class="buttontext"><a href="#"><?php echo __('Edasi') ?></a></div>
			</div>
		</div>
		<div class="clear"></div>
		<?php endif; ?>


		<?php include_partial('query/contactSubmitScript') ?>
	
		</div>
	</form>
        <div class="clear"></div>
    </div>
</div>
<?php end_slot() ?>

<?php include_component('productPage', 'pageLayout') ?>