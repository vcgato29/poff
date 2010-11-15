<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <?php include_partial('global/head')?>

  <body>
  
  <div id="container">
  
	<?php include_component('sfGuardAuth','header')?>
	
	    <div id="contentbox">
	    	<div class="clear"></div>
	    	<?php include_component('structure', 'leftmenu') ?>
	    	
	    	<div id="rightbox">
	    		<?php echo $sf_content ?>
	    	</div>
	    	
	    </div>
    </div>
    
	<?php include_component('translation', 'changeLanguageForm')?>
  </body>
</html>