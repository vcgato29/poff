<fieldset>
<legend class="formLabel"><?php echo $parameter['title']?></legend>
	<table>
		<tr>
			<td>
				<?php echo $form[$index]['parameter_options_list']->render(array('class' => 'formInput'))?>
			</td>
		</tr>
		<tr>
		    <td>
				<?php if($parameter['multilang']): ?>
					<?php foreach($form->getLangsAbr() as $lang): ?>
						<div class="formLabel"><?php echo __('new option') ?> (<?php echo $lang ?>):</div><?php echo $form[$index]['new_option'][$lang]['name']->render(array('class' => 'formInput'))?>
					<?php endforeach; ?>
				<?php else: ?>
					<div class="formLabel"><?php echo __('new option') ?>:</div>
					<?php echo $form[$index]['new_option']['title']->render(array('class' => 'formInput'))?>
				<?php endif; ?>
			
		    </td>
		</tr>
	</table>
</fieldset>

