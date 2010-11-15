<?php slot('article')?>
 <div class="page_title">
              <div class="box-590">
                <div class="block_top"></div>
                <div class="block_content">
                  <h1><?php echo __('Uudised') ?></h1>
                </div>

                <div class="block_bottom"></div>
              </div>
              <div class="boxarrow"></div>
            </div>

  <div class="content opennews">
        <h2><?php echo $new['name'] ?></h2>

         <?php echo $new['content'] ?>

              <br /><div class="readmore"><?php echo __('Loe veel') ?></div>
              <div class="content_separator"></div>
 </div>
<?php end_slot()?>