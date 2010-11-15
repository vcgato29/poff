<?php get_component('categoriesLeftMenuWidget', 'render') ?>
<?php get_component('bottomArticlesWidget', 'render') ?>


<?php slot('tabbox') ?>
        <div class="tabbox">
            <!-- <div class="tabpealkiri"><h2>Laine pehmus ja terase tugevus ühinevad terasplaadis</h2></div> -->
             <?php echo $param['value'] ?>
        </div>
<?php end_slot() ?>


<?php include_component('productPage', 'pageLayout') ?>