<?php get_component('categoriesLeftMenuWidget', 'render') ?>
<?php get_component('bottomArticlesWidget', 'render') ?>


<?php slot('tabbox') ?>
<div class="tabbox">
	<div class="tabpealkiri">
		<?php echo $product['description'] ?>
	</div>
	 <?php include_partial('productPage/parameters', $parameters ) ?>
</div>
<?php end_slot() ?>


<?php include_component('productPage', 'pageLayout') ?>