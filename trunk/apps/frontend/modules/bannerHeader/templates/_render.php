<?php slot('bannerHeader')?>
<?php foreach($logos as $index => $logo): ?>
    <?php echo @myPicture::getInstance( $logo->getPicture() )->thumbnail(952,135,'center')->url()?>
<?php endforeach; ?>

<?php end_slot()?>