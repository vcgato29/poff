<?php slot('archiveLink') ?>
<?php if($archive && $archive instanceof Structure): ?>
<div class="wp_season active">
	<a href="<?php include_component('linker', 'articleLinkBuilder', array('node' => $archive)) ?>">
		<?php echo $archive['title'] ?>
	</a>
</div>

<?php endif; ?>
<?php end_slot() ?>
