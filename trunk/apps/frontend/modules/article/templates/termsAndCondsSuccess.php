<?php echo $node['content']?>
<input onclick="uh_oh(); return false;" type="submit" id="agree"  value="I agree"/>

<script type="text/javascript">
function uh_oh(){
	parent.$('#terms_and_conditions').trigger('click');
	parent.$.fancybox.close();
};
</script>