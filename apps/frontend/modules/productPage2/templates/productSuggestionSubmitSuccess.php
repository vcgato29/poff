<style>
#content {	
		position:absolute; 
		top:50%; 
		height:240px; 
		margin-top:-120px;/* negative half of the height */
		left:50%;
		width:330px;
		margin-left: -150px;
		}
</style>


<div id="content">
	<div style="float:left; height:50%; margin-bottom:-120px;">
<div style="clear:both; height:240px; position:relative;">

<div class="write" style="background-color:white;width:330px;margin:auto;padding:5px 0 5px;">
	<p><?php echo $sf_user->getFlash('mail.form.success')?></p>
	<div class="clear"></div>
</div>

</div>

</div>

</div>

<script type="text/javascript">
setTimeout(function(){
	parent.$.fancybox.close();
}, 2000);
</script>


