<?php if( $sf_user->isAuthenticated() ):?>
	<?php include_partial('headerMenu/signedUserHeaderMenu', array('myOrders' => $myOrders, 'mySettings' => $mySettings))?>
<?php else:?>
	<?php include_partial('headerMenu/signInForm', array('form' => $form, 'reminderForm' => $reminderForm))?>	
<?php endif;?>