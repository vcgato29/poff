<?php slot('searchResults')?>
<div class="content opennews">
				<h2><?php echo __('Otsingu tulemused') ?>: "<?php echo $keyword ?>"</h2><br /><br />

				<?php if(count($news) > 0 || count($nodes) > 0): ?>
					<?php foreach($news as $newItem): ?>
						<b><a href="<?php include_component('linker', 'newsItem', array('newsItem' => $newItem))?>"><?php echo $newItem['name'] ?></a></b><br />
						<?php echo $newItem['description'] ?><br /><br />
					<?php endforeach; ?>
					<?php foreach($nodes as $node): ?>
						<b><a href="<?php include_component('linker', 'articleLinkBuilder', array('node' => $node))?>"><?php echo $node['title'] ?></a></b><br />
						<?php echo $node['description'] ?><br /><br />
					<?php endforeach; ?>
				<?php else: ?>
					<?php echo __('artikle / uudiseid ei leitud') ?>
				<?php endif; ?>


</div>
<?php end_slot()?>