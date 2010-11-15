<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php get_component('layoutBuilder', 'buildLayout')?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $sf_user->getCulture() ?>" lang="<?php echo $sf_user->getCulture() ?>">
<?php include_partial('global/head')?>
    <body>
	    <div class="mainbox">
			<?php include_partial('global/topbox')?>
			
			<?php include_partial('global/centerbox')?>
			
			<?php include_component('bottomArticlesWidget', 'render')?>
			<?php include_partial('global/footer')?>
		</div>
	</body>
</html>
