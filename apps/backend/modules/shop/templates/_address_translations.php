<div class="clear"></div>

<table class="shop_translations">
<?php foreach( $form->getLanguages() as $lang ):?>
			<tr>
				<td>
					<?php echo $form[$lang]['address']->renderLabel() ?> (<?php echo $lang?>)
				</td>
				<td>
					<?php echo $form[$lang]['address']->render(array('id' => $lang, 'width' => 250, 'height' => 250)) ?>
				</td>
			</tr>
<?php endforeach;?>
</table>


<?php foreach( $form->getLanguages() as $lang ):?>
<script type="text/javascript">
			//<![CDATA[

				// This call can be placed at any point after the
				// <textarea>, or inside a <head><script> in a
				// window.onload event handler.

				// Replace the <textarea id="editor"> with an CKEditor
				// instance, using default configurations.
				
				CKEDITOR.replace( '<?php echo $lang?>',

						{
					// Defines a simpler toolbar to be used in this sample.
					// Note that we have added out "MyButton" button here.
					         toolbar :
					        [
								['Styles','Format','FontSize'],
					            ['Bold', 'Italic', 'Underline','-', 'NumberedList', 'BulletedList','Blockquote', '-', 'Link', '-'],
					            ['Image','Table'],
					            ['TextColor','BGColor'],
					            
					            
					        ],

				height:"71", width:"550"
																											
				}


						 );
				// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
				// The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
				
				// It is also possible to pass an object with selected CKFinder properties as a second argument.
				// CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;

			//]]>
</script>
<?php endforeach;?>