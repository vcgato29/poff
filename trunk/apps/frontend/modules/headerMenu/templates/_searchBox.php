<div class="search">
	<div class="linkname">
		<p class="active"><?php echo __('Search')?>:</p>
	</div>
	<div class="sinput">
		<form id="searchform" method="get" action="<?php include_component('linker', 'searchLink', array('action'=>'detailed') )?>">
			<?php 
			$val = $sf_request->hasParameter('search') ? $sf_request->getParameter('search') : __('Type Keyword Here');
			?>
			<input id="searchbox" type="text" title="<?php echo __('Type Keyword Here')?>"  value="<?php echo $val?>" class="searchinput" name="search"/>
			<input style="display:none" type="submit" /> <!-- enter to work -->
		</form>
	</div>
	<div id="a3" class="searchsubmit nonactivebutton"></div>
	<div class="clear"></div>
	
	<div id="search" class="hiddenbox" style="display:block;color:white"></div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#searchbox').liveSearch({url: "<?php include_component('linker', 'searchLink', array( 'action' => 'ajax') )?>?search=", id: "search" })
		.clearInputDescription();
	
	$('.searchsubmit').click(function(e){
		e.preventDefault();
		$('#searchform').submit();

		return false;
	});	
});
</script>