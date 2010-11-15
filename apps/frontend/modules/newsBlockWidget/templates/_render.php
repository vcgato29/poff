<?php slot('newsBlock') ?>
            <div id="poff_ticker">
              <div class="box-590">
                <div class="block_top"></div>
                <div class="block_content">
                  <div class="ticker">
                    <div class="viewport">
                     <?php foreach($news as $index => $new): ?>
                      <div class="panel<?php if( count($news) == 1):?>2<?php endif;?>">
                        <a href="<?php if( isset($new['source']) and  !empty($new['source']) ):?><?php echo $new['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $new) ) ?><?php endif;?>"><img src="<?php echo @myPicture::getInstance( $new->getPicture() )->thumbnail(448,260,'center')->url()?>" alt="" title="" /></a>
                        <div class="captionbox">
                          <div class="title"><a href="<?php if( isset($new['source']) and  !empty($new['source']) ):?><?php echo $new['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $new) ) ?><?php endif;?>"><?php echo $new['name'] ?></a></div>
                          <div class="desc"><?php echo $new['description'] ?></div>
                        </div>
                      </div>
                     <?php endforeach; ?>

                    </div>
                    <div class="viewport-thumbnails<?php if( count($news) == 1):?>2<?php endif;?>">
                       <?php foreach($news as $index => $new): ?>
                      <div class="thumb">
                        <img src="<?php echo @myPicture::getInstance( $new->getPicture() )->thumbnail(80,46,'center')->url()?>" alt="" title="" />
                      </div>
                      <?php endforeach; ?>


                    </div>
                  </div>
                </div>
                <div class="block_bottom"></div>
              </div>
            </div>

            <div class="boxseparator"></div>
<?php end_slot() ?>