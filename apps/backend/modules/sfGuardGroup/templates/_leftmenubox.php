<div class="menu">
      <div class="menu_up"></div>
      <div class="menu_list">
      <div class="menu_body_item">
        <a class="menu_link menu_head menu_attitude" href="#"  id="settings_box">Settings</a>
      </div>  
      
      <div class="menu_body" id="settings_box_menu" style="display:<?php if( in_array( $module, $toggledModules ) )echo "block"; else echo "none"?>;">
	      <div class="blockline3"></div>
	 		<div class="menu_body_item">
	            <a class="menu_link menu_language" href="<?php echo url_for( '@admin_page?module=sfGuardGroup&action=listUserGroups' )?>" id="structure_et_menu_item">User groups</a>
	            <a class="menu_link menu_language" href="" id="structure_et_menu_item">Users</a>
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
});
</script>