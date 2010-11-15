<?php slot('newsBlock2') ?>
 <div class="tabbed_news">
              <div class="tabs">
              <?php $i = 0; ?>
              <?php foreach($news as $index => $new): ?>
                <?php $i++; ?>
                <div class="tab <?php if($i==1): ?>selected<?php endif; ?>">
                  <div class="block_left"></div>
                  <div class="block_content"><h3><?php echo $new['name'] ?></h3></div>
                  <div class="block_right"></div>
                </div>
               <?php endforeach; ?>
                <div class="separator"></div>
              </div>
              <div class="news">
               <?php $i = 0; ?>
               <?php foreach($news as $index => $new): ?>
                <?php $i++; ?>
                <div class="newsitem <?php if($i!=1): ?>hidden<?php endif; ?>">
                  <h2><a href="<?php if( isset($new['source']) and  !empty($new['source']) ):?><?php echo $new['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $new) ) ?><?php endif;?>"><?php echo $new['name'] ?> <img src="/img/yellowarrowright.png" alt="" title="" /></a></h2>
                  <p><?php echo $new['description'] ?></p>
                </div>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="boxseparator"></div>
<?php end_slot() ?>