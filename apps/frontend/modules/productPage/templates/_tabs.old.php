
<ul>
    <?php foreach($additionalActions as $act): ?>
		<?php if(!$act['use'])continue; ?>
        <?php
            $active = $sf_request->getParameter('action') == $act['action'];
        ?>
        <li class="<?php if($active)echo 'active' ?>"><div class="tabslinkcontent<?php if($active)echo 'active' ?>"><a href="<?php include_component('linker', 'product', array('product' => $product, 'category' => $category, 'action' => $act['action'] ) ) ?>"><?php echo __($act['title']) ?></a></div></li>
    <?php endforeach; ?>

    <?php foreach($parameterArticles as $act): ?>
        <?php

        $active = $sf_request->getParameter('action') == 'paramArticle' && $sf_request->getParameter('id') == $act['id'];

        ?>
        <li class="<?php if($active)echo 'active' ?>"><div class="tabslinkcontent<?php if($active)echo 'active' ?>"><a href="<?php include_component('linker', 'product', array('product' => $product, 'category' => $category, 'action' => $act['action'], 'id' => $act['id'] ) ) ?>"><?php echo __($act['title']) ?></a></div></li>
    <?php endforeach; ?>




        <li><div class="tabslinkcontentlast"><a href="<?php echo include_component('linker', 'product', array('product' => $product, 'category' => $category, 'module' => 'query', 'action' => 'pureIndex')) ?>"><?php echo __('Küsi pakkumist') ?></a></div></li>
    <div class="clear"></div>
</ul>