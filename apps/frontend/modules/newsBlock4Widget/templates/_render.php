<?php slot('newsBlock4') ?>
<div class="news_block_columns">
              <?php $i = 0; ?>
              <?php foreach($news as $index => $new): ?>
                <?php $i++; ?>

              <div class="newscontainer <?php if($i==2): ?>second<?php endif; ?>" <?php if($i==1): ?>style="margin-right: 18px;"<?php endif; ?>>
                <div class="picture">
                  <a href="<?php if( isset($new['source']) and  !empty($new['source']) ):?><?php echo $new['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $new) ) ?><?php endif;?>"><img src="<?php echo @myPicture::getInstance( $new->getPicture() )->thumbnail(235,100,'center')->url()?>" alt="" title="" /></a>
                  <div class="title"><a href="<?php if( isset($new['source']) and  !empty($new['source']) ):?><?php echo $new['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $new) ) ?><?php endif;?>"><?php echo $new['name'] ?></a></div>
                </div>
                <div class="nav"><a href="<?php if( isset($new['source']) and  !empty($new['source']) ):?><?php echo $new['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $new) ) ?><?php endif;?>"><img src="/img/yellowarrowright.png" alt="" title="" /></a></div>
                <div class="curve"></div>
              </div>
               <?php endforeach; ?>

            </div>

            <div class="boxseparator"></div>
<?php end_slot() ?>