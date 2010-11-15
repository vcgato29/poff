<link rel="stylesheet" type="text/css" media="screen" href="/backend/ui/css/ui-lightness/jquery-ui-1.8.4.custom.css" />

<script type="text/javascript" src="/backend/ui/js/jquery-ui-1.8.4.custom.min.js"></script>		<script type="text/javascript">
			$(function(){
				$('#product_exemplar_scheduled_time').datepicker({
					changeYear: true,
					dateFormat: 'yy-mm-dd 00:00',
					constrainInput: false
				});
			});
		</script>
<!-- /for datepicker -->

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form">
  <?php echo form_tag_for($form, '@product_exemplar') ?>
    <?php echo $form->renderHiddenFields(false) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

    <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
      <?php include_partial('product_exemplar/form_fieldset', array('product_exemplar' => $product_exemplar, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
    <?php endforeach; ?>

    <?php include_partial('product_exemplar/form_actions', array('product_exemplar' => $product_exemplar, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </form>
</div>
