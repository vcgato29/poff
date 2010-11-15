
<?php include_partial('global/pagetitle', array( 'addTitle' => $groupTitle ))?>


<?php slot('product_catalog')?>

<script type="text/javascript">
$(document).ready(function(){
	
	$(".product_slot_1").hover(
	  function () {
		 $('.product_slot_1').removeClass('active');
		 $(this).addClass('active');
		 
		$("#pic_slot_1").attr('src', $("#product_pic_" + this.id ).attr('src') );
		$("#pic_slot_link_1").attr('title', $("#product_pic_" + this.id ).attr('title') );
		$("#pic_slot_link_1").attr('alt', $("#product_pic_" + this.id ).attr('alt') );
	  }, 
	  function () {}
	);

	$(".product_slot_2").hover(
			  function () {
				 $('.product_slot_2').removeClass('active');
				 $(this).addClass('active');
				 
				$("#pic_slot_2").attr('src', $("#product_pic_" + this.id ).attr('src') );
				$("#pic_slot_link_2").attr('title', $("#product_pic_" + this.id ).attr('title') );
				$("#pic_slot_link_2").attr('alt', $("#product_pic_" + this.id ).attr('alt') );
			  }, 
			  function () {}
			);
});

</script>


			<div class="sub-info02">

			<ul class="animals clear">
				<?php foreach( $productGroups as $index => $pGroup ):?>
					<li class="item<?php echo $pGroup['id'] ?> <?php if( $index == 0 ):?>first<?php endif;?>">
						<a class="<?php if( $activeFirstLevelProductGroup['id'] == $pGroup['id'] ):?>active<?php endif;?>" href="<?php echo $pGroup->buildLink( $lang ) ?>">
							<span><?php echo $pGroup['name']?></span>
						</a>
					</li>
				<?php endforeach;?>
			</ul>
			

			<?php if( isset( $subgroups[0] ) && !empty( $subgroups[0] ) && $products[$subgroups[0]['id']]->toArray() ):?>
			
			<div class="clear">
				<div class="col col03">
					<p id="scrolltome" class="heading"><?php echo $subgroups[0]['name']?></p>
					<div class="menu02 clear">
						<div class="col col04">
							<ul class="clear">
								
								<?php foreach( $products[$subgroups[0]['id']] as $index => $product ):?>
								<li><a href="#1"  name="modal"  title="<?php echo $product['id']?>" id="<?php echo $product['id']?>" class="product_slot_1 <?php if( $activeProducts[$subgroups[0]['id']]['id'] == $product['id'] ):?>active<?php endif;?>" ><?php echo $product['name']?></a></li>
								<?php endforeach;?>

							</ul>
						</div>
						<div class="col col05">
						
								<a href="#1" name="modal" id="pic_slot_link_1" title="<?php echo $activeProducts[$subgroups[0]['id']]['id']?>">
									<img id="pic_slot_1"   title="<?php echo $activeProducts[$subgroups[0]['id']]['id']?>" alt="<?php echo $productPictures[$activeProducts[$subgroups[0]['id']]['id']]['name']?>" src="<?php echo Picture::getInstance( '', $productPictures[$activeProducts[$subgroups[0]['id']]['id']]['file'], '', 308, 281, true )->getRawLink('thumbnail')?>" />
								</a>
						
						</div> <!-- IMG SIZE 308x281 MAX!!! -->
					</div>
				</div>
			<?php endif;?>
				
				
		<!-- onclick="window.scrollTo(0,0); return false" -->		
				
				<?php if( isset( $subgroups[1] ) && !empty( $subgroups[1] ) && $products[$subgroups[1]['id']]->toArray() ):?>
				
				<div class="col col03">
					<p class="heading"><?php echo $subgroups[1]['name']?></p>

					<div class="menu02 clear">
						<div class="col col04">
							<ul class="clear">
								<?php foreach( $products[$subgroups[1]['id']] as $index => $product ):?>
								<li><a href="#2"  name="modal"  title="<?php echo $product['id']?>" id="<?php echo $product['id']?>" class="product_slot_2 <?php if( $activeProducts[$subgroups[1]['id']]['id'] == $product['id'] ):?>active<?php endif;?>" ><?php echo $product['name']?></a></li>
								<?php endforeach;?>
							</ul>
						</div>
						<div class="col col05">
						<a href="#2" id="pic_slot_link_2" name="modal" title="<?php echo $activeProducts[$subgroups[1]['id']]['id']?>">
								<img id="pic_slot_2" title="<?php echo $activeProducts[$subgroups[1]['id']]['id']?>" alt="<?php echo $productPictures[$activeProducts[$subgroups[1]['id']]['id']]['name']?>" src="<?php echo Picture::getInstance( '', $productPictures[$activeProducts[$subgroups[1]['id']]['id']]['file'], '', 308, 281, true )->getRawLink('thumbnail')?>" />
						</a>
						</div> <!-- IMG SIZE 308x281 MAX!!! -->
					</div>
				</div>
				<?php endif;?>
			</div>
			
		</div>
	
	
<div style="display:none">
	<?php foreach( $productPictures as $productId => $productPic ):?>
	<img alt="<?php echo $productPic['name']?>" id="product_pic_<?php echo $productId?>" title="<?php echo $productId?>" src="<?php echo Picture::getInstance( '', $productPic['file'], '', 308, 281 )->getRawLink('thumbnail')?>" />
	<?php endforeach;?>
</div>

<div style="display:none">
	<?php foreach( $productMessages as $productId => $productMessage ):?>
		<span id="prduct_message_<?php echo $productId?>"><?php echo $productMessage?></span>
	<?php endforeach;?>
</div>



<?php end_slot()?>

<?php slot('product_catalog_css')?>
	<style>
		<?php foreach( $productGroups as $index => $pGroup ):?>
			UL.animals LI.item<?php echo $pGroup['id']?> A { background: url(<?php echo Picture::getInstance( '', $pGroup['picture_inactive'], '', 36, 36, true )->getRawLink('resize')?>) 50% 0 no-repeat; }
			UL.animals LI.item<?php echo $pGroup['id']?> A:hover,
			UL.animals LI.item<?php echo $pGroup['id']?> A.active { background: url(<?php echo Picture::getInstance( '', $pGroup['picture'], '', 36, 36, true )->getRawLink('resize')?>) 50% 0 no-repeat; }
		<?php endforeach;?>
	</style>	
<?php end_slot()?>


<?php slot('product_catalog_overlay')?>
<!-- Modal Overlay -->
<div id="boxes">

	<div id="dialog" class="window">
		<a href="#" class="close"><span></span></a>
		<p class="heading"><?php echo __('Contact us')?></p>

		<div class="modal-content">
			<form action="<?php echo url_for('@product_form')?>">
				<?php echo $form->renderHiddenFields()?>
				<img id="product_loader" src="/img/loader.gif" style="vertical-align: middle; display:none" />
				<div id="msges_product"></div>
				<table class="form nomargin">
						<tr>
							<th><?php echo $form['name']->renderLabel('Name')?></th>
	
							<td><?php echo $form['name']->render(array('class'=>'default' ))?></td>
						</tr>
						<tr>
							<th><?php echo $form['phone']->renderLabel('Phone')?></th>
	
							<td><?php echo $form['phone']->render(array('class'=>'default' ))?></td>
						</tr>
						<tr>
							<th><?php echo $form['email']->renderLabel('E-mail')?></th>
	
							<td><?php echo $form['email']->render(array('class'=>'default' ))?></td>
						</tr>
						<tr>
							<th><?php echo $form['message']->renderLabel('Message')?></th>
	
							<td><?php echo $form['message']->render(array('class'=>'default' ))?></td>
						</tr>
						<tr>
							<th></th>
	
							<td><span class="btn"><input id="product" class="contact_submit" type="submit" value="<?php echo __('Send')?>" /></span></td>
						</tr>
				</table>

			</form>
		</div>
	</div>
	
	<!-- Do not remove div#mask, because you'll need it to fill the whole screen -->     
	
<div id="mask" style=""></div>  
</div>

<!-- / Modal Overlay -->
<?php end_slot()?>
