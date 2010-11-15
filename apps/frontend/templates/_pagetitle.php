<?php $pageTitle = get_slot('page_title')?>
<?php echo $addTitle?>
<?php slot( 'page_title' )?>			
	<?php echo $addTitle?> <?php if( !empty( $pageTitle ) && $addTitle ):?> - <?php endif;?>  <?php echo $pageTitle?> 
<?php end_slot()?>