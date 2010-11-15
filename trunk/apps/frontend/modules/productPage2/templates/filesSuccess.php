<?php get_component('categoriesLeftMenuWidget', 'render') ?>
<?php get_component('bottomArticlesWidget', 'render') ?>


<?php slot('tabbox') ?>
    <div class="tabbox">
        <div class="tabpealkiri"><h2><?php echo __('Toode failid') ?></h2></div>

        <div class="files">
            <?php foreach($files as $file): ?>
                <div class="filelinkbox">
                    <div class="pdf"><img width="16" height="16" alt="" src="<?php echo $file->renderIconSrc() ?>"></div>
                    <div class="filelink">
                        <a href="<?php echo $file->renderDownloadLink() ?>"><?php echo $file['name'] ?></a>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php end_slot() ?>


<?php include_component('productPage', 'pageLayout') ?>