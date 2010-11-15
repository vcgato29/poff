<?php foreach($items as $name => $action): ?>

	<?php include_partial('query/leftMenuTab', array(
			'name' => $name,
			'active' => $sf_request->getParameter('action') == $action,
			'link' => $helper->link($action))) ?>

<?php endforeach; ?>