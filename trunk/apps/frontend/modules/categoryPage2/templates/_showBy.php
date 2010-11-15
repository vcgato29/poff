<div class="listby">
	<div class="linkname">
		<p><?php echo __('Show by')?> <?php echo $perPage?></p>
		<div class="hiddenbox" id="listby" style="display: none;">
			<div class="listcontentboxby">
				<div class="listtext" id="listcontentby">
			    	<?php foreach($perPageAr as $num):?>
						<a href="<?php include_component('linker', 'plainActions', array('action' => 'showby', 'val' => $num) )?>"><?php echo __('Show by')?> <?php echo $num?></a>
			    	<?php endforeach;?>
				</div>
			</div>
		</div>	
	</div>
	<div onclick="showBlocks('listby','listcontentby','a6');" class="nonactivebutton" id="a6"></div>
</div>