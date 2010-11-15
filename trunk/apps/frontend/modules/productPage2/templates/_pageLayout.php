<?php // get_component('bannersOnRightWidget', 'render') ?>
<?php slot('productPage') ?>
<div class="maincontent">
    <div class="contentbox">
        <div class="contentboxin">
                <div class="boxintopleft">
                    <?php include_component('headerMenu', 'breadCrumbs')?>
                </div>
                <div class="boxintopright">
                    <div class="boxtoplink">
                            <img width="12" height="12" alt="" src="/olly/img/print.png">
                                <a href="<?php include_component('linker', 'product', array('product' => $product, 'category' => $category, 'action' => 'printView') )?>"><?php echo __('Print') ?></a>
                                <div class="clear"></div>
                    </div>
                    <?php include_partial('article/share') ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div class="boxinpealkiri">
                    <h1><?php echo $product['name'] ?></h1>
                </div>
                <div class="tabs">
                    <div class="tabslinks">
                        <?php include_partial('productPage/tabs', array('product' => $product,
                            'category' => $category,
                            'additionalActions' => $additionalActions,
                            'parameterArticles' => $parameterArticles ) ) ?>
                    </div>
                    <div class="clear"></div>
                    <?php include_slot('tabbox') ?>
                </div>
            </div>
        </div>
</div>
<?php end_slot() ?>