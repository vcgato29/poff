<div class="hind">
	<h1><?php echo __('Kulud') ?></h1>
	<div class="hindleft">
		<ul>
			<li>
				<div class="pinnakatehind">
					<div class="textradio"><img height="15" width="15" alt="" src="/olly/img/textradio.png"></div>
					<div class="hindtext"><?php echo __('Profiili hind') ?></div>
					<div class="hindnumber"><?php echo price_format($helper->getProfilePrice($values)) ?></div>
					<div class="clear"></div>
				</div>
			</li>
			<li>
				<div class="pinnakatehind">
					<div class="textradio"><img height="15" width="15" alt="" src="/olly/img/textradio.png"></div>
					<div class="hindtext"><?php echo __('Lisaplekid, aluskate, kruuvid') ?></div>
					<div class="hindnumber"><?php echo price_format($helper->getAdditionalStuffPrice($values)) ?></div>
					<div class="clear"></div>
				</div>
			</li>
			<li>
				<div class="pinnakatehind">
					<div class="textradio"><img height="15" width="15" alt="" src="/olly/img/textradio.png"></div>
					<div class="hindtext"><?php echo __('Vihmaveesüsteem') ?></div>
					<div class="hindnumber"><?php echo price_format($helper->waterSystemPrice($values)) ?></div>
					<div class="clear"></div>
				</div>
			</li>
			<li>
				<div class="pinnakatehind">
					<div class="textradio"><img height="15" width="15" alt="" src="/olly/img/textradio.png"></div>
					<div class="hindtext"><?php echo __('Vana katuse eemaldus') ?></div>
					<div class="hindnumber"><?php echo price_format($helper->getOldRoofRemovingPrice($values)) ?></div>
					<div class="clear"></div>
				</div>
			</li>
			<li>
				<div class="pinnakatehind">
					<div class="textradio"><img height="15" width="15" alt="" src="/olly/img/textradio.png"></div>
					<div class="hindtext"><b><?php echo __('Kulud kokku') ?></b></div>
					<div class="hindnumber"><?php echo price_format($helper->getTotalPrice($values)) ?></div>
					<div class="clear"></div>
				</div>
			</li>
		</ul>
	</div>

	<div class="clear"></div>
</div>