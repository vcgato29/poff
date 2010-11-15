<?php slot('popuptabs') ?>
	<table width="100%"  >
		<tr>
			<?php foreach( $tabs as $title => $tabInfo ):?>
				<td width="<?php echo 100 / count( $tabs )  ?>%" class="tab tab<?php if( $tabInfo['selected'] ):?>active<?php endif;?>" height="20" align="center" > <a href="<?php echo url_for( $tabInfo['route'] )?>"><?php echo __($title)?></a></td>
			<?php endforeach;?>
		</tr>
	</table>
<?php end_slot() ?>
