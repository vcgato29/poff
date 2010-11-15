<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form">
  <?php echo form_tag_for($form, '@'.$helper->getIndexRoute()) ?>
    <?php echo $form->renderHiddenFields(true) ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>
	
	<table width="50%" style="float:left">
		<tfoot>
			<tr>
				<td colspan="2">
					<input class="formSubmit" type="submit" name="Save" value="<?php echo __('Save')?>" />
					<?php if(!$form->isNew()): ?>
						<input class="formSubmit" type="submit" onclick="javascript:window.location='<?php echo url_for($helper->getModuleName().'/copyProduct?id=' . $product['id']) ?>'; return false;" name="Copy" value="<?php echo __('Copy')?>" />
					<?php endif; ?>
				</td>
			</tr>
		</tfoot>
		<tr>
			<td width="50%">
				<fieldset>
				<legend class="formLabel"><?php echo __('Product information')?></legend>
				<table>
					<tr>
						<td> <?php echo $form['code']->renderLabel( '', array( 'class' => 'formLabel' ) )?> </td>
						<td>  <?php echo $form['code']->render( array( 'class' => 'formInput' ) )?> </td>
						<td>  <?php echo $form['code']->renderError()?> </td>
					</tr>
					<tr>
						<td> <?php echo $form['original_title']->renderLabel( '', array( 'class' => 'formLabel' ) )?> </td>
						<td>  <?php echo $form['original_title']->render( array( 'class' => 'formInput' ) )?> </td>
						<td>  <?php echo $form['original_title']->renderError()?> </td>
					</tr>
					<tr>
						<td> <?php echo $form['year']->renderLabel( '', array( 'class' => 'formLabel' ) )?> </td>
						<td>  <?php echo $form['year']->render( array( 'class' => 'formInput' ) )?> </td>
						<td>  <?php echo $form['year']->renderError()?> </td>
					</tr>

					<tr>
						<td> <?php echo $form['producer']->renderLabel( '', array( 'class' => 'formLabel' ) )?> </td>
						<td>  <?php echo $form['producer']->render( array( 'class' => 'formInput' ) )?> </td>
						<td>  <?php echo $form['producer']->renderError()?> </td>
					</tr>
					<tr>
						<td> <?php echo $form['trailer_link']->renderLabel( '', array( 'class' => 'formLabel' ) )?> </td>
						<td>  <?php echo $form['trailer_link']->render( array( 'class' => 'formInput' ) )?> </td>
						<td>  <?php echo $form['trailer_link']->renderError()?> </td>
					</tr>
					<?php foreach( ProductForm::$multiLangFields as $field => $fieldInfo ):?>
						<?php foreach( $form->languages as $lang ):?>
						<tr>
							<td>
								<?php echo $form['et'][$field]->renderLabel( $fieldInfo['title'] . " (${lang['abr']})"  ,array(  'class' => 'formLabel' ))?>
							</td>
							<td>
								<?php echo $form[$lang['abr']][$field]->render( array(  ) )?>
							</td>

						</tr>
						<?php endforeach;?>
					<?php endforeach;?>
					<tr>
						<td> <?php echo $form['is_active']->renderLabel('',array( 'class' => 'formLabel' ))?> </td>
						<td>  <?php echo $form['is_active']->render( array( 'class' => 'formInput' ) )?> </td>
						<td>  <?php echo $form['is_active']->renderError()?> </td>
					</tr>
				</table>
				</fieldset>
			</td>
			</tr>
			</table>
<script type="text/javascript">
//<![CDATA[
 
  $('.multilang').each(function(){
	  CKEDITOR.replace(this.id,{
			         toolbar :[
						['Source','Styles','Format','FontSize','PasteText', 'PasteFromWord'],
			            ['Bold', 'Italic', 'Underline','Strike','-', 'NumberedList', 'BulletedList','Blockquote', '-', 'Link', 'Flash', '-'],
			            ['Image','Table'],
			            ['TextColor','BGColor'],
			        ],
		height:"71", width:"550"
		});
	 });

//]]>
</script>
			<table>
			<tr>
			<td width="50%" >
				<fieldset>
				<legend class="formLabel"><?php echo __('Additional information')?></legend>
					<table width="100%" height="100%">
						<tr>
							<td><?php echo $form['connections']->renderLabel( 'Product Groups', array( 'class' => 'formLabel' ) ) ?></td>
							<td>
								<?php echo $form['connections']?>
							</td>
						</tr>
						<tr>
							<td><?php echo $form['connected_products']->renderLabel( 'Connected products', array( 'class' => 'formLabel' ) )?></td>
							<td>
								<?php if( !$form->isNew() ):?>
								<ul class="formLabel">
									<?php foreach( $form->getObject()->ConnectedProducts as $connProd ):?>
										<li style="font-size:14px">
											<table>
											<tr>
												<td> <?php echo  $connProd->getName() . " (" .  $connProd->getCode() . ")" ?> </td>
												<td> <a href="<?php echo url_for( '@admin_page?module=product&action=deleteConnectedProduct&conprod=' . $connProd['id'] . '&id=' . $form->getObject()->id  )?>"> <img  border="0" width="10px" src="/img/admin/delete.png" alt=""> </a> </td>
											</tr>
											 
											
											</table>
										</li>
									<?php endforeach;?>
								</ul>								
								<?php endif;?>
								<label class="formLabel"><?php echo __('New connected product(code1, code2, ...)')?></label><br />
								<?php echo $form['connected_products']?>
							</td>
						</tr>
					</table>
				</fieldset>	
		
			</td>
		</tr>
	</table>
    

  </form>
</div>

