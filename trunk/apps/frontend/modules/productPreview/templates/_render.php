<?php slot('article') ?>
	<?php include_partial('productPreview/alphabet', array('chars' => $chars, 'node' => $node)) ?>
	<?php include_partial('productPreview/filters', array('form' => $form, 'node' => $node)) ?>

	<?php
	$links = LinkGen::getInstance(LinkGen::PRODUCT)->collectionLinks($products);

	?>
   <table class="table-films">
         	<tbody>
         	 <?php $i = 0; ?>
	<?php foreach($products as $index => $product): ?>
	<?php $link = $links[$product['id']] ?>
	<?php if (is_integer($i/3)) echo '<tr>'; ?>

	              	<td>
         			<div class="filmbox"><?php foreach($product['ProductGroups'] as $groupConn): ?><?php $groupslug = $groupConn['ProductGroup']['slug']; ?><?php endforeach; ?>

         				<a href="<?php echo parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);?>/programmid.p/<?php echo $groupslug ?>/<?php echo $product['slug'] ?>"><img src="<?php echo @myPicture::getInstance($product['ProductPictures'][0]['file'])->thumbnail(187,125,'center')->url() ?>" alt=""></a>
         				<div>
         					<h3><a href="<?php echo parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);?>/programmid.p/<?php echo $groupslug ?>/<?php echo $product['slug'] ?>"><?php echo $product['name'] ?></a></h3>
         					<?php echo $product['original_title'] ?><br>
							<?php $all_countries = explode(',', $product['country']); ?> <?php foreach ($all_countries as $one_country) {  echo __($one_country) . ', ' ; } ?>
							<?php echo $product['year'] ?><br>
							<?php if($product['director_name']): ?><?php echo __('Režissöör') ?>: <?php echo $product['director_name'] ?><?php endif; ?>
							<h4><?php foreach($product['ProductGroups'] as $groupConn): ?>
					<br><a href="<?php echo parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);?>/programmid.c/<?php echo $groupConn['ProductGroup']['slug'] ?>"><?php echo $groupConn['ProductGroup']['name'] ?></a>
					<?php endforeach; ?></h4>

         				</div>
         			</div>
         		</td>
    <?php $i++; ?>
	<?php if (is_integer($i/3)) echo '</tr>'; ?>
	<?php endforeach; ?>
	        </tbody></table>

            <br><br>
<?php end_slot() ?>