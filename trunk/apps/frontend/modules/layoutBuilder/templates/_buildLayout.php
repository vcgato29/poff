<?php foreach( $modules as $placeHolderArr ):?>
	<?php foreach( $placeHolderArr as $index => $module ):?>
		<?php include_component($module['name'], $module['action'], array('controller' => $controller))?>
	<?php endforeach;?>
<?php endforeach;?>