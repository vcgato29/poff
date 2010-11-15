<style>
.lang_select{
	margin:0px;
	margin-bottom:3px;
	padding:5px;
	display:block;
	border: 1px solid gray;
}
.lang_select li{
	display:inline;
	margin:0px;
	padding-right:10px;
}
</style>


<ul class="lang_select">
		<li><?php echo __('Languages')?></li>
	<?php foreach($langs as $lang):?>
		<li><?php echo $lang?><input value="<?php echo $lang?>" <?php if(in_array($lang, $activeLangs)):?>checked<?php endif;?> name="selected_langs[]" type="checkbox"></li>
	<?php endforeach;?>
</ul>