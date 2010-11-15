<div class="productbottom">
	<?php echo $pagingHTML?>
	
	<div class="backto">
	    <div class="linkname">
		    <p><?php echo __("Back to Top")?></p>
		</div>
	    <div class="nonactivebutton"></div>
	</div>

</div>

<script type="text/javascript">
$('.backto').click(function(){
scroll(0,0);
return false;
});
</script>