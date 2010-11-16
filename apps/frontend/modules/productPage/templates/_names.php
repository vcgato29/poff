<div class="page_title">
              <div class="box-590">
                <div class="block_top"></div>
                <div class="block_content">
                  <h1><?php echo $product['name'] ?></h1>
                </div>
                <div class="block_bottom"></div>

              </div>
              <div class="boxarrow"></div>
            </div>
           <br>
<?php
//$secondCulture = $sf_user->getCulture() == 'en' ? 'et' : 'en';
?>
             <div style="padding-bottom: 2px;"><?php if($product['Translation']['en']['name']): ?>
	<?php echo $product['Translation']['en']['name'] ?> |
<?php endif; ?> <?php echo $product['original_title'] ?></div> <?php  echo $product['director_name'] ? __('Režissöör') . ': ' . $product['director_name'] : '' ?><br><br>