<?php
$tabsArray = array();

$tabsArray[] = array('tabId' => 'tabset03-02', 'tabName' => 'REžISSÖÖR',
	'tabContent' => $product['producer_description'] ? $product['producer_description'] : ''
);

$tabsArray[] = array('tabId' => 'tabset03-03', 'tabName' => 'NOOR KRIITIK',
	'tabContent' => $product['critics'] ? $product['critics'] : ''
);

?>
 <div class="tabbed_film">
              <div class="tabs">
                <div class="tab selected">
                  <div class="block_left"></div>
                  <div class="block_content"><h3><?php echo __('Sünopsis') ?></h3></div>

                  <div class="block_right"></div>
                </div>
                <div class="tab">
                  <div class="block_left"></div>
                  <div class="block_content"><h3><?php echo __('Rezisöör') ?></h3></div>

                  <div class="block_right"></div>
                </div>
         <?php foreach($tabsArray as $tab): ?>
			<?php if(!$tab['tabContent'])continue; ?>
			    <div class="tab">
                  <div class="block_left"></div>
                  <div class="block_content"><h3><?php echo __($tab['tabName']) ?></h3></div>
                  <div class="block_right"></div>
                </div>
		<?php endforeach; ?>

                <div class="separator"></div>

              </div>
              <div style="clear: both;"></div>
              <div class="filmlist">
                <div class="filmitem">
                  	  <div style="width: 560px;"><?php echo $product['synopsis'] ?></div>
		              <div style="clear: both;"></div>
                </div>
                 <div class="filmitem hidden">

                      <div style="float: left; width: 120px;"><?php foreach($product['ProductPictures'] as $pro) {
 if($pro['parameter']=="director") { $pictures = $pro['file']; break; }
                      }?><img src="<?php echo @myPicture::getInstance($pictures)->thumbnail(102,134,'center')->url() ?>" alt=""></div>
                  	  <div style="float: left; width: 440px;"> <h3><?php echo $product['director_name']; ?></h3><br>
		                  <p><?php echo $product['director_bio']; ?></p> <br>
							<?php if (!empty($product['director_filmography'])): ?>
							<h3>Filmograafia</h3><br>
							<?php echo $product['director_filmography']; ?>
							<?php endif; ?>
		              </div>

		              <div style="clear: both;"></div>
                </div>

    <?php foreach($tabsArray as $tab): ?>
		<?php if(!$tab['tabContent'])continue; ?>
		       <div class="filmitem hidden">
                  	  <div style="width: 560px;"><?php echo $tab['tabContent'] ?></div>
		              <div style="clear: both;"></div>
                </div>
	<?php endforeach; ?>
              </div>
            </div>

            <div class="boxseparator"></div>