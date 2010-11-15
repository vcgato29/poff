<?php include_component( 'product', 'popuptabs' )?>
<?php if( $sf_request->getParameter('multilang') ):?>
	<?php include_partial('product/multilangparametersform', array( 'form' => $form, 'langs' => $langs, 'helper' => $helper ) )?>
<?php else:?>
	<?php include_partial('product/singlelangparametersform', array( 'form' => $form ))?>
<?php endif;?>