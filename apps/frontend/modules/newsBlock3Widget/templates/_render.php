<?php slot('newsBlock3') ?>
  <div class="news_block_rows">
                <?php $i = 0; ?>
              <?php foreach($news as $index => $new): ?>
                <?php $i++; ?>
              <div class="newscontainer <?php if($i==1): ?>first<?php endif; ?>">
                <div class="picture"><a href="<?php if( isset($new['source']) and  !empty($new['source']) ):?><?php echo $new['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $new) ) ?><?php endif;?>"><img src="<?php echo @myPicture::getInstance( $new->getPicture() )->thumbnail(75,68,'center')->url()?>" alt="" title="" /></a></div>
                <div class="story">
                  <h4><a href="<?php if( isset($new['source']) and  !empty($new['source']) ):?><?php echo $new['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $new) ) ?><?php endif;?>"><?php echo $new['name'] ?> <img src="/img/yellowarrowright.png" alt="" title=""></a></h4>
                  <p><?php echo $new['description'] ?></p>
                </div>
              </div>
              <?php endforeach; ?>
            </div>

            <div class="boxseparator"></div>
<?php end_slot() ?>