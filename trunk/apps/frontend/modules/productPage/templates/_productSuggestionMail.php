<?php 
/*
 * @product
 * @category
 * @sender_name
 * @receiver_name
 */
?>

<?php echo __('Dear Friend !')?>

<?php echo __("Your friend %1% suggested you a product %2%", array('%1%' => $sender_name, '%2%' => get_component('linker', 'product', array('product' => $product, 'category' => $category, 'full' => true))))?>

<?php echo $message?>

<?php echo __('FAYE')?>
