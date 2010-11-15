

<?php foreach( $forms as $id => $form ):?>
	<form action="<?php echo url_for( '@structure_page?action=commonEdit').  urldecode( '?'. $structQuery ) ?>" method="post"  <?php if ($form->isMultipart()) echo 'enctype="multipart/form-data"; '; ?> >
	<?php include_partial('form', array('form' => $form, 'nodeID'=> $id , 'formTagStarted' => true )) ?>
<?php endforeach;?>