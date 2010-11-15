<div class="infobox"> <!-- wanna kill HTML-dude ? Yeah, me too.... -->
<?php
// if there is no <p> tag at all -> wrap description in it
$content = strpos($product['description'], '<p>') === false ? '<p>' . $product['description'] . '</p>' : $product['description'];

$content = preg_replace('/<p>(\W*)(&nbsp;)*<\/p>/s', '', $content);  
$content = str_replace('<p>', '<p style="padding-top:10px;"><img height="7" width="7" alt="" src="/faye/img/halfarrow.png">', $content);
?>
	<?php echo $content?>
</div>