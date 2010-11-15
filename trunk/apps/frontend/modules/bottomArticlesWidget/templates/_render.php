<?php slot('bottomArticlesWidget');?>

    <?php if($bottomArticle && isset($bottomArticle['content'])):?>
    <?php echo $bottomArticle['content']?>
    <?php endif;?>

<div class="clear"></div>
<?php end_slot()?>