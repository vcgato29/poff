
<?php
$keyword = $sf_request->hasParameter('search') ? $sf_request->getParameter('search') : __('Otsingu sõna');
?>
	<form method="get" action="<?php include_component('linker', 'searchLink') ?>">

	   <div class="input">
              <div class="input_left"></div>
              <div class="input_content">
                	<input class="searchin" id="search" type="text" onblur="if(this.value=='')this.value='<?php echo $keyword ?>'" onfocus="if(this.value=='<?php echo $keyword ?>')this.value=''" value="<?php echo $keyword ?>" name="search" maxlength="30" />
              </div>
              <div class="input_right"></div>
            </div>

            <div class="submit">
              <div class="submit_left"></div>
              <div class="submit_content">
              	<div class="searchbutton" id="searchbutton"><?php echo __('Otsi') ?></div>
              </div>
              <div class="submit_right"></div>

            </div>
	</form>
<script type="text/javascript">
	jQuery('#searchbutton').click(function(e){
		e.preventDefault();
			$(this).parents('form').submit();
		return false;
	});
</script>