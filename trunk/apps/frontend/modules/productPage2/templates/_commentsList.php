<?php foreach($comments as $comment):?>
<div class="comment">
    <div class="user">
	    <p><?php echo __('name')?>:</p>
		<p><a style="cursor:default" href="#"><?php echo $comment['name']?></a></p>
	</div>
	<div class="commentbox">
	    <h1><?php echo __('Message')?>:</h1>
		<div class="clear"></div>
	    <p><?php echo $comment['message']?></p>
		
	</div>
	<div class="clear"></div>
</div>
<?php endforeach;?>