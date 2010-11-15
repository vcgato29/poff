<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $sf_user->getCulture() ?>" lang="<?php echo $sf_user->getCulture() ?>">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
table{
		width: 100%;
		
}

td{
	padding: 10px;
	border: 1px solid gray;
}


</style>
</head>
	
<h2><?php echo __('Contact info') ?></h2>
<table >
	<?php foreach($contact as $var => $val): ?>
	<?php if($var == 'send_copy')continue; ?>
	<tr>
		<td><?php echo __($var) ?></td>
		<td><?php echo $val ?></td>
	</tr>
	<?php endforeach; ?>
</table>

<?php if($dimensions): ?>
<h2><?php echo __('Mõõdud') ?></h2>

<table>
	<?php foreach($dimensions as $var => $val): ?>
		<?php if($var == 'katuse mõõdistamine')$val = $val == 1 ? __('Jah') : __('Ei') ?>
		<?php if($var == 'katuse skeema')$val = '<img width="200px" src="'.$val.'" />' ?>
		<?php if($var == 'katuse tüüp')continue ?>
	<tr>
		<td><?php echo __($var) ?></td>
		<td><?php echo $val ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>


<?php if($profiles): ?>

<?php
$info = $configuration->getProfilesInfo();
$profileInfo = $info['profiles'][$profiles['katuse profiil']];
$colorInfo = $info['colors'][$profiles['värvus']];
$coverInfo = $info['covers'][$profiles['pinnakate']];
?>

<h2><?php echo __('Profiil') ?></h2>

<table>
	
	<tr>
		<td><?php echo __('Profiil') ?></td>
		<td><img src="<?php echo 'http://' . $sf_request->getHost() . $profileInfo['img'] ?>" /><br /><?php echo $profileInfo['txt'] ?></td>
	</tr>
	<tr>
		<td><?php echo __('Värv') ?></td>
		<td><img src="<?php echo 'http://' . $sf_request->getHost() . $colorInfo['img'] ?>" /><br /><?php echo $colorInfo['txt'] ?></td>
	</tr>
	<tr>
		<td><?php echo __('Pinnakate') ?></td>
		<td><?php echo $coverInfo['name'] ?></td>
	</tr>
</table>
<?php endif; ?>



<?php if($products['savedValues']): ?>
<h2><?php echo __('Lisatooted') ?></h2>


<table>
<?php foreach($products['products'] as $prod): ?>
	<tr>
		<td><?php echo $prod['name'] ?> (<?php echo $products['savedValues']['toodete kogused']['prod_' . $prod['id']] ?>)</td>
	</tr>
<?php endforeach; ?>

</table>
<?php endif; ?>


<?php if($attachments): ?>
<h2><?php echo __('Kasutaja pildid') ?></h2>
<table>
<?php foreach($attachments as $attachment): ?>
	<tr>
		<td><img alt="" width="300px" src="<?php echo $attachment ?>" /></td>
	</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</html>