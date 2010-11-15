<div class="menu">
      <div class="menu_up"></div>
      <div class="menu_list">
      <div class="menu_body_item">
        <a class="menu_link menu_head menu_attitude" href="#"  id="settings_box"><?php echo __("Settings")?></a>
      </div>  
      
      <div class="menu_body" id="settings_box_menu" style="display:<?php if( array_key_exists( $curModule, $toggledModules ) )echo "block"; else echo "none"?>;">
	      <div class="blockline3"></div>
	 		<div class="menu_body_item">
	 			<?php foreach( $toggledModules as $module => $moduleInfo ):?>
	 			<?php if($user->hasCredential( $moduleInfo['credential'] )):?>
	 				<a class="menu_link menu_language" href="<?php echo url_for( $moduleInfo['route'], true )?>" id="structure_et_menu_item">
	 				<?php if( $curModule == $module ): ?> 
	 				<b><?php echo $moduleInfo['name']?></b>
	 				<?php else:?>
	 				<?php echo $moduleInfo['name']?>
	 				<?php endif;?>
	 				</a>
	 			<?php endif;?>
	 			<?php endforeach;?>

	       	</div>
      </div>
      </div>
      <div class="menu_down"></div>
     
</div>
<script type="text/javascript">

$(document).ready(function() {
  $('a#settings_box').click(function() {
 $('#settings_box_menu').toggle(400);
 	return false;
  });

  $('.uber-puper').click(function() {
	  $('#' + this.href.split('#')[1]).toggle(400);
		return false;
	   });
});
</script>