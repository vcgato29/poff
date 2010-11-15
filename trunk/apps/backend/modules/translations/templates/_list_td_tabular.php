<td class="sf_admin_text sf_admin_list_td_source">
  <?php echo link_to($trans_unit->getSource(), 'trans_unit_edit', $trans_unit) ?>
</td>



<?php foreach($activeLangs as $lang):?>
	<?php if(isset($quickForm[$quickForm->getEmbedFieldName($trans_unit->getSource(), $lang)])):?>
	<td class="sf_admin_text sf_admin_list_td_source" style="width:150px;">
		<?php echo $quickForm[$quickForm->getEmbedFieldName($trans_unit->getSource(), $lang)]['target']->render(array('style' => "background-color:#EFEFEF;border:1px solid #777777;text-align: center; ", 'size' => 25))?>
		<input type="hidden" name="curtransunit[]" value="<?php echo $trans_unit['source']?>" />
	</td>
	<?php endif;?>
<?php endforeach;?>



