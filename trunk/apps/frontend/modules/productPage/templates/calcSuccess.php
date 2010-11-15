<?php get_component('categoriesLeftMenuWidget', 'render') ?>
<?php get_component('bottomArticlesWidget', 'render') ?>


<?php slot('tabbox') ?>
<div class="tabbox">
	<div class="tabpealkiri"><h2>Kalkulaator</h2></div>
	<div class="kalkulaatorbox">
		<?php include_partial('productPage/calculator', array('form' => $form, 'data' => $data, 'configuration' => $configuration)) ?>
		<div id="calculatorResponse">
			<?php include_partial('productPage/calculatorResponse', array('helper' => $helper, 'values' => array())) ?>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php end_slot() ?>


<?php include_component('productPage', 'pageLayout') ?>