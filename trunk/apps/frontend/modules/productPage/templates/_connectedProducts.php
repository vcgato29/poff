<?php if(isset($connectedProducts) && !empty($connectedProducts)): ?>
<?php slot('connected_products') ?>
<div class="thumbbox">
	<div class="thumbboxtop">
		<div class="thumbboxtopleft"><img src="/enermaatik/img/saleleft2.png" width="9" height="34" alt=""/></div>
			<div class="thumbboxtopright">
				<div class="tboxleft">
					<p class="lmenu"><?php echo __('Seotud tooted') ?></p>
				</div>
				<!--
				<div class="tboxright">
					<div class="pluss">
						<img src="/enermaatik/img/pluss.png" width="19" height="18" alt=""/>
					</div>
					<div class="showall">
						<a href="#">Näita kõiki</a>
					</div>
				</div>
				-->
			</div>
	</div>
	<div class="clear"></div>
	<div class="thumbboxmain">
		<?php
			$links = LinkGen::getInstance(LinkGen::PRODUCT)->collectionLinks($connectedProducts);
		
		?>

		<?php foreach($connectedProducts as $index => $product): ?>
		<?php if($index == 5)break; ?>
		<div class="toodebig<?php echo $index == 4 ? 'last' : '' ?>">
			<div class="toodebigtop">
				<a href="<?php echo $links[$product['id']] ?>"><img src="<?php echo @myPicture::getInstance($product['ProductPictures'][0]['file'])->thumbnail(70,100)->url() ?>" width="70" height="100" alt=""/></a>
			</div>
			<div class="toodebigmain">
				<p><a href="<?php echo $links[$product['id']] ?>"><?php echo $product->getName() ?></a></p>
				<h1><a href="<?php echo $links[$product['id']] ?>"><?php echo price_format($product->getPriceActual()) ?></a></h1>
			</div>
			<div class="toodebigbottom">
				<a href="#"><img src="/enermaatik/img/bl.png" width="31" height="33" alt=""/></a>
				<a href="#"><img src="/enermaatik/img/korvsmall.png" width="31" height="33" alt=""/></a>
			</div>
		</div>
		<?php endforeach; ?>
		<div class="clear"></div>
	</div>
	<div class="thumbboxbottom">
		<img src="/enermaatik/img/thumbbottom.png" width="541" height="8" alt=""/>
	</div>
</div>
<?php end_slot() ?>
<?php endif; ?>