<?php if($product['instock']): ?>
<p class=""><?php echo __('Toode on laos') ?></p>
<?php else: ?>
<p class="red"><?php echo __('Toode on laost otsas') ?></p>
<p><?php echo __('Saatke email, kui toode tuleb lattu') ?>:</p>
<div class="mailbox">
	<div class="mailboxleft">
		<form method="post" action="">
			<div class="formleft"><img src="/enermaatik/img/formleft.png" alt="" width="10" height="30"></div>
			<div class="formcenter"><input class="mail" onblur="if(this.value=='')this.value='Email'" onfocus="if(this.value=='Email')this.value=''" value="Email" name="mail" maxlength="20" type="text"></div>
			<div class="formright"><img src="/enermaatik/img/formright.png" alt="" width="10" height="30"></div>
		</form>
		<div class="clear"></div>
	</div>
	<div class="mailboxright">
		<div class="button">
			<div class="buttonleft"><img src="/enermaatik/img/rbleft.png" alt="" width="8" height="26"></div>
			<div class="buttoncenter">
				<a href="#"><?php echo __('Sisesta') ?></a>
			</div>
			<div class="buttonright"><img src="/enermaatik/img/rbr.png" alt="" width="8" height="26"></div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php endif; ?>