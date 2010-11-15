<?php if($checkProduct!=1): ?>
<?php slot('article') ?>
<?php if(count($activeProductGroup)==0): ?>

            <div class="page_title">
              <div class="box-590">

                <div class="block_top"></div>
                <div class="block_content">
                  <h1><?php echo __('Programmid') ?></h1>
                </div>
                <div class="block_bottom"></div>
              </div>
              <div class="boxarrow"></div>
            </div>

           <br>
           <table class="table-films">
	           <tbody>
	           <?php $i = 0; ?>
	    <?php foreach($productGroups as $group): ?>
	    <?php $i++; ?>
	    <?php if($i%2) echo '<tr>'; ?>

	    <td>
	           			<div class="gallery">
			              <div class="halfbox2-287">
			                <div class="block_top"></div>
			                <div class="block_content">
			                   <h3><a href="<?php echo $_SERVER['REQUEST_URI']; ?>.c/<?php echo $group['slug']; ?>"><?php echo $group['name']; ?></a></h3>

			                </div>
			                <div class="block_bottom"></div>
			              </div>
			              <div class="halfbox-287-content">
                            <?php if($group['picture']): ?><a href="<?php echo $_SERVER['REQUEST_URI']; ?>.c/<?php echo $group['slug']; ?>"><img src="<?php echo @myPicture::getInstance($group['picture'])->thumbnail(277,182,'center')->url() ?>" alt=""></a><?php endif; ?>
			                <div style="clear: both;"></div>
			              </div>
			            </div>
	           		</td>
		<?php if(!$i%2) echo '</tr>'; ?>
		<?php endforeach; ?>
           </tbody></table>
<?php else: ?>
<div class="page_title">
              <div class="box-590">

                <div class="block_top"></div>
                <div class="block_content">
                  <h1><?php echo $activeProductGroup['name'] ?></h1>
                </div>
                <div class="block_bottom"></div>
              </div>
              <div class="boxarrow"></div>
            </div>

           <br />
            <div class="content">
          <?php echo $activeProductGroup['description'] ?>
</div>
 <br /><br />
 	<?php

		$products = $pager->getResults();
		$links = LinkGen::getInstance(LinkGen::PRODUCT)->collectionLinks($products);

	?>
     <table class="table-films">
         	<tbody>
         	 <?php $i = 0; ?>
         	<?php foreach($products as $product): ?>

         	<?php if (is_integer($i/3)) echo '<tr>'; ?>
         	<td>     <?php $link = str_replace('.c', '.p', $_SERVER['REQUEST_URI']); ?>
         			<div class="filmbox">
         				<a href="<?php echo $link.'/'.$product['slug'] ?>"><img src="<?php echo @myPicture::getInstance($product['ProductPictures'][0]['file'])->thumbnail(187,125,'center')->url() ?>" alt=""></a>
         				<div class="filmbox_category">
         					<h3><a href="<?php echo $link.'/'.$product['slug'] ?>"><?php echo $product['name'] ?></a></h3>
         					<?php echo $product['original_title'] ?><br>
							<?php $all_countries = explode(',', $product['country']); ?> <?php foreach ($all_countries as $one_country) {  echo __($one_country) . ', ' ; } ?>
							<?php echo $product['year'] ?><br>

							<?php echo __('Režissöör') ?>: <?php echo $product['director_name']; ?>
							<br>
         				</div>
         			</div>
         		</td>
        <?php $i++; ?>
        <?php if (is_integer($i/3)) echo '</tr>'; ?>
		<?php endforeach; ?>
         </tbody></table>

            <br><br>
<?php endif; ?>
<?php end_slot() ?>
<?php endif; ?>
