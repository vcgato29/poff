<form action="<?php if($form->isNew()): ?>
<?php echo url_for('@admin_page?module=parameter_group&action=create&parent_id=' . $parent_id);?>
<?php else: ?>
<?php echo url_for('@admin_page?module=parameter_group&action=update&id=' . $id);?>
<?php endif;?>" method="post">
  <fieldset>
    <legend class="formLabel"><?php echo __('Parameter group information')?></legend>
  
    <?php echo $form['_csrf_token'] ?>
    <?php echo $form['id'] ?>
    		
    		<table>
    			<tbody>
    				<tr>
    					<td>
    						<?php echo $form['title']->renderLabel('Title', array( 'class' => 'formLabel' ))?>
    					</td>
    					<td>
    						<?php echo $form['title']->render( array( 'class' => 'formInput' ))?>
    					</td>
    					<td><?php echo $form['title']->renderError()?></td>
    				</tr>
    			</tbody>
    		</table>
    		<br />
    		
			<table>
			    <tfoot>
			      <tr>
			        <td colspan="2">
			          <input type="submit" class="formSubmit" value="<?php echo __('Save')?>" />
			        </td>
			      </tr>
			    </tfoot>
				<tbody>
					<tr>
					<th class="formLabel"><?php echo __('Variables')?></th>
					<?php foreach( $languages as $lang ):?>
					  <th class="formLabel" align="center">
					    <?php echo $lang['title_est'] ?>
					  </th>
					<?php endforeach;?>
					</tr>
					<tr>
					<td>
						<table>
					    <?php foreach( ParameterGroupForm::$multiLangFields as $field => $fieldInfo ):?>
					    	<tr>
					    		<td align="right">
					    			<?php echo $form[$lang['abr']][$field]->renderLabel($fieldInfo['title'],array('class'=>'formLabel'));?>
					    		</td>
					    	</tr>
					    <?php endforeach;?>
						</table>						
					</td>					
					<?php foreach( $languages as $lang ):?>
						
						<?php if( isset( $form[$lang['abr']]['id'] ) ):?>
							<?php echo $form[$lang['abr']]['id']?>
							<?php echo $form[$lang['abr']]['lang']?>
						<?php endif;?>
						
					  <td>
						<table>
					    <?php foreach( ParameterGroupForm::$multiLangFields as $field => $fieldInfo ):?>
					    	<tr>
					    		<td>
									<?php echo $form[$lang['abr']][$field]->renderError()?>					    		
					    			<?php echo $form[$lang['abr']][$field]?>
					    		</td>
					    	</tr>
					    <?php endforeach;?>
						</table>
					  </td>
					<?php endforeach;?>
					</tr>
		    	</tbody>
			</table>
	</fieldset>
</form>

<?php if( !$form->isNew() ):?>
<fieldset>
	<legend class="formLabel"><?php echo __('Parameters')?></legend>
	<table class="formLabel" cellpadding="10" cellspacind="5">
		<thead>
			<tr>
				<th><?php echo __('No.')?></th>
				<th><?php echo __('Title')?></th>
				<th><?php echo __('Priority')?></th>			
			</tr>
		</thead>
		<tbody>
			
			<?php foreach( $form->getObject()->getParameters() as $index => $param ):?>
			<tr>
				<td><?php echo $index+1?>.</td>
				<td><?php echo $param['title']?></td>
				<td align="center">
					<?php if( $index != 0 ):?>
						<a href="<?php echo url_for( '@admin_page?module=parameter_group&action=parameterPriority&order=up&id='.$param['id'] )?>"><img border="0" alt="Up" style="padding: 5px;" src="/img/admin/sort_up.gif"></a>
					<?php endif;?>
					<?php if( $index != $form->getObject()->getParameters()->count() - 1 ):?>
						<a href="<?php echo url_for( '@admin_page?module=parameter_group&action=parameterPriority&order=down&id='.$param['id'] )?>"><img border="0" alt="Down" style="padding: 5px;" src="/img/admin/sort_down.gif"></a>
					<?php endif;?>
				</td>
			</tr> 
			<?php endforeach;?>		
			
		</tbody>

	</table>
	
	
</fieldset>
<?php endif;?>