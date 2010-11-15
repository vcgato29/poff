
<form action="<?php if($form->isNew()): ?>
<?php echo url_for('@admin_page?module=product_group&action=create&parent_id=' . $parent_id);?>
<?php else: ?>
<?php echo url_for('@admin_page?module=product_group&action=update&id=' . $id);?>
<?php endif;?>" method="post" enctype="multipart/form-data">
    <?php echo $form['_csrf_token'] ?>
    <?php echo $form['id'] ?>
	  <table id="job_form">
		    <tbody>
			<tr>
			  <td colspan="1"><?php echo $form['title']->renderLabel('Title',array('class'=>'formLabel')); ?></td>
			  <td>
			    <?php echo $form['title']->renderError() ?>
			    <?php echo $form['title'] ?>
			  </td>
			</tr>
			<tr>
			  <td colspan="1"><?php echo $form['parameter']->renderLabel('Additional Group Parameters',array('class'=>'formLabel')); ?></td>
			  <td>
			    <?php echo $form['parameter']->renderError() ?>
			    <?php echo $form['parameter'] ?>
			  </td>
			</tr>
			<tr>
			  <td colspan="1"><?php echo $form['connections']->renderLabel('Parameter Groups',array('class'=>'formLabel')); ?></td>
			  <td>
			    <?php echo $form['connections']->renderError() ?>
			    <?php echo $form['connections'] ?>
			  </td>
			</tr>
			<tr>
				<td><?php echo $form['structure_connections']->renderLabel('', array( 'class' => 'formLabel' ))?></td>
				<td><?php echo $form['structure_connections']->render( array( 'class' => 'formInput' ) )?></td>
				<td><?php echo $form['structure_connections']->renderError() ?></td>
			</tr>
			</tbody>
			</table><br />
			<table>

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
					    <?php foreach( ProductGroupForm::$multiLangFields as $field => $fieldInfo ):?>
					    	<tr>
					    		<td align="right" height="<?php echo $fieldInfo['height'] ?>">
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
					    <?php foreach( ProductGroupForm::$multiLangFields as $field => $fieldInfo ):?>
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
					  <td colspan="1"><?php echo $form['picture']->renderLabel('Picture',array('class'=>'formLabel')); ?></td>
					  <td>
					    <?php echo $form['picture']->renderError() ?>
					    <?php echo $form['picture'] ?>
					  </td>
					</tr>
				</tbody>
			</table>			

</form>