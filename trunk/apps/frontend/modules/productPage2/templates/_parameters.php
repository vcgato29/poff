<div class="tooteinfo">
<?php if($txt): ?>
	<!-- tavalised parameetrid -->
	<div class="andmed">
		<?php foreach($txt as $name => $txtParam): ?>
			<?php if(!$txtParam)continue; ?>
			<div class="andmebox">
				<div class="andleft">
					<p><?php echo $name ?>:</p>
				</div>
				<div class="andright">
					<p><?php echo $txtParam ?></p>
				</div>
				<div class="clear"></div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<?php if($pic): ?>
    <!-- pildid parameetrid -->
    <div class="tooteimg">
        <?php foreach($pic as $picParam): ?>
			<?php if(!$picParam)continue; ?>
        <div class="profiil"> <!-- skeem -->
            <img alt="" src="<?php echo @myPicture::getInstance( $picParam )->url()?>">
        </div>
        <?php endforeach; ?>
    </div>
    <div class="clear"></div>
<?php endif; ?>
</div>
<div class="part">
    <img width="574" height="10" alt="" src="/olly/img/gallshadowbottom.jpg">
</div>


<!-- HTML parameetrid -->
<?php foreach($html as $paramName => $htmlParam): ?>
    <?php echo $htmlParam ?>
<?php endforeach; ?>


