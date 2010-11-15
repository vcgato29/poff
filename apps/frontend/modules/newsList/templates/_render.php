<?php slot('newsArchivePage') ?>
 <!-- SAMPLE PAGE TITLE -->
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
       <?php include_partial('newsList/newsBox', array('pager' => $pager)) ?>
       </div>

<?php end_slot() ?>