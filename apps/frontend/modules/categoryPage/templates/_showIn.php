<div class="list">
    <div class="linkname">
	    <p><?php echo __('Show products in %view% view', array('%view%' => __($currentView)))?></p>
		<div class="hiddenbox" id="list" style="display: none;">
		    <div class="listcontentbox">
			    <div class="listtext" id="listcontent">
		    	<?php foreach($showInAr as $val => $class):?>
		    		<a href="<?php include_component('linker', 'plainActions', array('action' => 'showin', 'val' => $val) )?>"><?php echo $val?> <?php echo __('view')?></a> <br />
		    	<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
    <div onclick="showBlocks('list','listcontent','a5');" class="nonactivebutton" id="a5"></div>
</div>