<?php slot('article') ?>
	<?php include_partial('productPage/names', array('product' => $product))?>
	<?php include_partial('productPage/screen', array('product' => $product)) ?>
	<?php include_partial('productPage/tabs', array('product' => $product))?>
	<?php include_partial('productPage/linastused', array('product' => $product, 'linastused' => $linastused, 'userLinastused' => $userLinastused)) ?>
	<?php include_partial('productPage/share') ?>
<?php include_component('bottomArticlesWidget', 'render') ?>
<?php end_slot() ?>
<?php slot('rightProduct') ?>
 <div id="poff_blog">
              <div class="halfbox-183">
                <div class="block_top"></div>
                <div class="block_content">

                  <h3><?php echo __('PROGRAMM') ?></h3>
                </div>
                <div class="block_bottom"></div>
              </div>
              <div class="halfbox-183-content">
                <ul>				  
				  <?php foreach($product['ProductGroups'] as $groupConn): ?>
				  <?php $link = str_replace('.p', '.c', $_SERVER['REQUEST_URI']);
                        $link = explode($category['slug'], $link);
                   ?>
					<li><a href="<?php echo $link[0] ?><?php echo $groupConn['ProductGroup']['slug'] ?>"><?php echo $groupConn['ProductGroup']['name'] ?> <img src="/img/yellowarrowright.png" alt="" title=""></a></li>
					<?php endforeach; ?>
                </ul>

              </div>
            </div>

            <div class="boxseparator"></div>

             <div id="poff_gallery">
              <div class="halfbox2-183">
                <div class="block_top"></div>
                <div class="block_content">
                  <h3><?php echo __('FILMI INFO') ?></h3>

                </div>
                <div class="block_bottom"></div>
              </div>
              <div class="halfbox-183-content">
                <?php if (!empty($product['Translation']['en']['country'])): ?><b><?php echo __('Riik') ?></b>: <?php $all_countries = explode(',', $product['country']); ?> <?php foreach ($all_countries as $one_country) {  $clist .= __($one_country) . ', ' ; } $clist = substr($clist,0,(strLen($clist)-2)); echo $clist; ?><br><?php endif; ?>
                <?php if (!empty($product['year'])): ?><b><?php echo __('Aasta') ?></b>: <?php echo $product['year'] ?><br><?php endif; ?>
                <br>

                <!--<b><?php echo __('Kestus') ?></b>: <?php echo $product['year'] ?><br>-->
                <?php if (!empty($product['Translation']['en']['language'])): ?><b><?php echo __('Keel') ?></b>: <?php echo $product['language'] ?> <br><?php endif; ?>
                <br>

                <?php if (!empty($product['producer'])): ?><b><?php echo __('Produtsent') ?></b>: <?php echo $product['producer'] ?><br><?php endif; ?>

                <?php if (!empty($product['writer'])): ?><b><?php echo __('Stsenarist') ?></b>: <?php echo $product['writer'] ?><br><?php endif; ?>


                <!--<b><?php echo __('Operaator') ?></b>: Witold Stokk<br>-->
                <!--<b><?php echo __('Osatäitjad') ?></b>:<br>				Mingi nimi,<br>				Mingi teine nimi <br>				Dagmara Krasowska, <br>				Dominika Überzeug <br><br> <br>-->
                <br />
				<?php if (!empty($product['production'])): ?><b><?php echo __('Tootja') ?></b>: <?php echo $product['production'] ?> <br> <?php endif; ?>
                <?php if (!empty($product['distributor'])): ?><b><?php echo __('Levitaja') ?></b>: <?php echo $product['distributor'] ?><br> <?php endif; ?>
                <?php if (!empty($product['world_sales'])): ?><b><?php echo __('Maailma müük') ?></b>: <?php echo $product['world_sales'] ?> <br><?php endif; ?>
                <?php if (!empty($product['festivals'])): ?><b><?php echo __('Auhinnad ja festivalid') ?></b>: <?php echo $product['festivals'] ?><br><?php endif; ?>

                <br>
                <?php if (!empty($product['webpage'])): ?><b><a href="<?php echo $product['webpage'] ?>" class="filmweb" target="_blank"><?php echo __('Veebileht') ?></b></a><?php endif; ?>

              </div>
            </div>

            <div class="boxseparator"></div>


<?php end_slot() ?>