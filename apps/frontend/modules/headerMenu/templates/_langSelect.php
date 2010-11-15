<div class="langbox">
<ul>    
	<?php foreach( $langs as $index => $lang ):?>
		<?php if( $lang['lang'] == $currentNode['lang'] ):?>
		<li><a class="active" href="<?php include_component('linker', 'localizedHomepage', array('lang' => $lang['lang'] ) ) ?>"><?php echo $lang['pageTitle'] ?></a></li>
		<?php else:?>
		<li><a href="<?php include_component('linker', 'localizedHomepage', array('lang' => $lang['lang'] ) ) ?>"><?php echo $lang['pageTitle'] ?></a></li>
		<?php endif;?>
	<?php endforeach;?>
</ul>
</div>
<div class="clear"></div>