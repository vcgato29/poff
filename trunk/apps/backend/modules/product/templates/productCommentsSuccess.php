<?php include_component( 'product', 'popuptabs' )?>
<table class="formLabel" cellspacing="0" cellpadding="10" border="1" width="100%" style="border: 1px solid rgb(223, 223, 223); border-collapse: collapse;">
	<tr>
		<th><?php echo __('Name')?></th>
		<th><?php echo __('Message')?></th>
		<th><?php echo __('IP')?></th>
		<th><?php echo __('Created')?></th>
		<th><?php echo __('Delete')?></th>
	</tr>
	<?php foreach($comments as $comment):?>
	<tr>
		<td align="center"><?php echo $comment->getName()?></td>
		<td align="center"><?php echo $comment->getMessage()?></td>
		<td align="center"><?php echo $comment->getIp()?></td>
		<td align="center"><?php echo $comment->getCreatedAt()?></td>
		<td align="center">
		<a href="<?php echo url_for('@admin_page?module=product&action=productCommentDelete&commID='.$comment->getId() )?>">
		X
		</a>
		</td>
	</tr>
	<?php endforeach;?>

</table>