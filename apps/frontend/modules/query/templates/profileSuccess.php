<?php slot('subject') ?>
	<h1><?php echo __('Profiles') ?></h1>
<?php end_slot() ?>


<?php get_component('bottomArticlesWidget', 'render') ?>

<?php slot('content') ?>
	<form action="<?php echo $helper->link('profilesSubmit') ?>" method="post">
		<?php echo $form->renderHiddenFields(true) ?>

		<?php include_partial('query/profileSlider', array('profiles' => $data['profiles'], 'form'=>$form)) ?>
		<?php include_partial('query/colorSlider', array('colors' => $data['colors'], 'form'=>$form)) ?>
		<?php include_partial('query/coverSlider', array('covers' => $data['covers'], 'form'=>$form)) ?>

		<?php include_partial('query/footerButtons', array('helper' => $helper)) ?>

	</form>
<?php end_slot() ?>