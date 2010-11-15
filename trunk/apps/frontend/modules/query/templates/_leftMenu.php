<div class="pakkumineleft">
    <?php if(!$helper->useExtendedMenu($sf_request) && ($sf_request->getParameter('action') == 'simple' )): ?>
        <?php include_partial('query/leftMenuTab', array('name' => 'Kontakt', 'active' => true, 'link' => '#')) ?>
    <?php elseif($helper->useExtendedMenu($sf_request) && in_array($sf_request->getParameter('action'), array('simple'))): ?>

		<?php include_partial('query/leftMenuItems', array(
							'helper' => $helper,
							'items' => array(
								'Kontakt' => 'simple',
								'Mõõdud' => 'dimensions',
								'Katuse profiil, värvus ja pinnakate' => 'profile',
								'Vihmaveesüsteem, turvatooted ja paigaldus' => 'products',
								) ) ) ?>

	<?php elseif($helper->useExtendedMenu($sf_request) && !in_array($sf_request->getParameter('action'), array('simple'))): ?>

		<?php include_partial('query/leftMenuItems', array(
							'helper' => $helper,
							'items' => array(
								'Mõõdud' => 'dimensions',
								'Katuse profiil, värvus ja pinnakate' => 'profile',
								'Vihmaveesüsteem, turvatooted ja paigaldus' => 'products',
								'Kontakt' => 'simple',
								) ) ) ?>

    <?php endif; ?>
</div>