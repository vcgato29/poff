<div class="login">
<div class="linkname">
    <p class="active"><?php echo __('Hello %1%', array('%1%' => $sf_user->getObject()->getName()))?></p>
	<div class="hiddenbox" id="user" style="display: none;">
	<div class="usercontentbox">
	
	<div class="langcontent" id="usercontent">
	<ul>
       <li><a href="<?php include_component('linker', 'mySettingsLinkBuilder' )?>"><?php echo $mySettings['title']?></a></li>
	   <li><a href="<?php include_component('linker', 'myOrdersLinkBuilder' )?>"><?php echo $myOrders['title']?></a></li>
	   <li><a href="<?php include_component('linker', 'logout')?>"><?php echo __('Log out')?></a></li>
	</ul>
	</div>
	
	</div>
	</div>
</div>
<div onclick="showBlocks('user','usercontent','a4');" class="nonactivebutton" id="a4"></div>
</div>