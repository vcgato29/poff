<?php use_javascript('/js/radiobutton.js') ?>

<div class="rbutton<?php if($active): ?>active<?php endif; ?>">
	<input type="radio" <?php if($active): ?>checked<?php endif; ?> name="<?php echo $field->renderName() ?>" value="<?php echo $defaultValue ?>" style="display:none" />
</div>