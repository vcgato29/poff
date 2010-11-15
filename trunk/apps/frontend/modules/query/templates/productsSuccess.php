<?php slot('subject') ?>
	<h1><?php echo __('Lisa tooted') ?></h1>
<?php end_slot() ?>


<?php get_component('bottomArticlesWidget', 'render') ?>


<?php slot('content') ?>

<form action="<?php echo $helper->link('productsSubmit') ?>" method="post">

<?php echo $form->renderHiddenFields(true) ?>

	<?php include_partial('query/productsList', array('productGroups' => $productGroups, 'form' => $form, 'data' => $data)) ?>

	<?php include_partial('query/footerButtons', array('helper' => $helper)) ?>

</form>



<?php end_slot() ?>