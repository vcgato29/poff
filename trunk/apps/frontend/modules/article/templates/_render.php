<?php slot('article')?>
            <div class="page_title">
              <div class="box-590">
                <div class="block_top"></div>
                <div class="block_content">
                  <h1><?php echo $node['pageTitle'] ?></h1>
                </div>
                <div class="block_bottom"></div>
              </div>

              <div class="boxarrow"></div>
            </div>

            <div class="content">


                  <?php echo $node['content'] ?>

                  <div class="content_separator"></div>
            </div>


            <div class="boxseparator"></div>
<?php end_slot()?>