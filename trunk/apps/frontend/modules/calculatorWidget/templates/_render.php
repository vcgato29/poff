<?php slot('calculator') ?>
<div class="calculator">
	<div class="calctop">
		<div class="pealkiri">
			<h1><?php echo __('Katuse kalkulaator') ?></h1>
		</div>
	</div>
<div class="clear"></div>

	<?php include_partial('productPage/calculator', array('form' => $form, 'data' => $data, 'configuration' => $configuration)) ?>

	<?php use_stylesheet('/olly/homepage_fix.css') ?>

	<div id="calculatorResponse" ></div>
</div>


<script type="text/javascript">

</script>
<?php end_slot() ?>