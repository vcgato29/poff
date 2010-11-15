

	<?php foreach($pager->getResults() as $newItem): ?>
              <div class="newsitem">
                <div class="title"><h2><a href="<?php if( isset($newItem['source']) and  !empty($newItem['source']) ):?><?php echo $newItem['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $newItem) ) ?><?php endif;?>"><?php echo $newItem['name'] ?></a></h2></div>
                <div class="synopsis"><?php echo $newItem['description'] ?></div>
                <div class="readmore"><a href="<?php if( isset($newItem['source']) and  !empty($newItem['source']) ):?><?php echo $newItem['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $newItem) ) ?><?php endif;?>"><?php echo __('Loe edasi') ?> <img src="/img/yellowarrowright.png" alt="" title=""></a></div>
              </div>
              <div class="content_separator"></div>
	<?php endforeach; ?>


<div class="newsnavi">
	<?php if($pager->getPage() < $pager->getLastPage()): ?>
	<div class="leftnavi arrows">
		<div class="linkarrow grey"></div>
		<div class="navilink">
			<a href="<?php include_component('linker', 'newsArchive', array('page' => $pager->getPage() + 1 )) ?>"><?php echo __('VANEMAD') ?></a>
		</div>
		<div class="clear"></div>
	</div>
	<?php endif; ?>
	<?php if($pager->getPage() > 1): ?>
	<div class="rightnavi arrows">
		<div class="linkarrow grey"></div>
		<div class="navilink">
			<a href="<?php include_component('linker', 'newsArchive', array('page' => $pager->getPage() - 1 )) ?>"><?php echo __('UUEMAD') ?></a>
		</div>
		<div class="clear"></div>
	</div>
	<?php endif; ?>
</div>