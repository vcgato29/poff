<?php if( $form->getObject()->type == 'lang' ):?>
<?php include_partial( 'formLanguageEdit', array( 'form' => $form ) ) ?>
<?php else:?>
<?php include_partial('form', array('form' => $form, 'nodeID'=> $nodeID)) ?>
<?php endif;?>
