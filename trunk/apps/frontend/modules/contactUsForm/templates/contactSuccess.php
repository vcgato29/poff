<?php get_component('bottomArticlesWidget', 'render') ?>


<?php // get_component('bannersOnRightWidget', 'render') ?>
<?php slot('productPage') ?>
<div class="maincontent">
    <div class="contentbox">
        <div class="contentboxin">
                <div class="boxintopleft">
                    <?php include_component('headerMenu', 'breadCrumbs')?>
                </div>
                <div class="boxintopright">
                    <?php include_partial('article/share') ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div class="boxinpealkiri">
                    <h1><?php echo __('Kontakt') ?></h1>
                </div>

				
				<?php include_partial('contactUsForm/tabbox', array('helper' => $helper, 'form' => $form,'node' => $node)) ?>
                
            </div>
        </div>
</div>
<?php end_slot() ?>
