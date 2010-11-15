<?php 
/*
 * @product -> current Product object
 * @category -> active category of @product
 * @commentsForm -> instance of CommentsForm
 * @showCommentsForm -> force comment form showing
 */
?>
<!-- sharelinkactive -->
<?php if($comments->count()): // if there is no comments -> do not show "User Reviews" link?>
<div class="userrew">
	<div class="arrow"><img height="7" width="4" alt="" src="/faye/img/arrow.png"></div>
	<div class="sharelink<?php if( $comments && !$showCommentsForm ):?>active<?php endif;?>"><a href="<?php include_component('linker', 'product', array('product'=>$product, 'category' => $category))?>#comments"><?php echo __('User Reviews')?> (<?php echo $comments->count()?>)</a></div>
</div>
<?php endif;?>
<div class="writerew">
	<div class="arrow"><img height="7" width="4" alt="" src="/faye/img/arrow.png"></div>
	<div class="sharelink<?php if(!$product->Comments || $showCommentsForm ):?>active<?php endif;?>"><a href="<?php include_component('linker', 'product', array('product'=>$product, 'category' => $category, 'write' => 1 ))?>#comments"><?php echo __('Write Review')?></a></div>
</div>

<div class="clear"></div>
<a name="comments"> </a> <!-- anchor used to scroll down, after page reload -->
<?php if(0 === $comments->count() || $showCommentsForm ):?>
	<?php include_partial('productPage/commentsForm', array( 'commentsForm' => $commentsForm, 'submitLink' => get_component('linker', 'product', array('action' => 'submitComment','product' => $product, 'category' => $category ) ) ) )?>
<?php else:?>
	<?php include_partial('productPage/commentsList', array( 'comments' => $comments ) )?>
<?php endif;?>