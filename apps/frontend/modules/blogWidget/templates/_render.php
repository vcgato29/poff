<?php slot('blogWidget')?>
<div id="poff_blog">
              <div class="halfbox-183">
                <div class="block_top"></div>
                <div class="block_content">
                  <h3><?php echo __('POFFI BLOGI') ?></h3>
                </div>
                <div class="block_bottom"></div>
              </div>
              <div class="halfbox-183-content">
              <ul>
            <?
                   foreach ($blog as $entry) {
                   	 echo '<li><a href="'.$entry['link'].'" target="_blank" title="'.$entry['title'].'">'.$entry['title'].' ('.$entry['date'].') <img src="/img/yellowarrowright.png" alt="" title="" /></a></li>';
                   }

             ?>
              </ul>
              </div>
            </div>

            <div class="boxseparator"></div>



<?php end_slot()?>