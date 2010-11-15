<div class="currencyselect">
    <div class="linkname">
	    <p class="active"><?php echo __('Currency')?>:</p>
	</div>
    <div class="right">
	    <p class="active"> <?php echo $sf_user->getCurrency()->getAbbr()?> </p>
		<div id="currency" class="hiddenbox">
		    <div id="ccontent" class="langcontentbox">
			    <div class="langcontent">
			        <ul>
			        
			        	<?php foreach( $currencies as $currency ):?>
					       <li>
					       		<a <?php if( $sf_user->getCurrency()->getId() == $currency->getId() ):?>class="active"<?php endif;?> href="<?php include_component('linker', 'changeCurrency', array( 'currencyID' => $currency['id'] ) )?>">
					       			<?php echo $currency['abbr']?>
					       		</a>
					       	</li>
			        	<?php endforeach;?>
			        	
				    </ul>
				</div>
			</div>
		</div>
	</div>
    <div id="a2" class="nonactivebutton" onclick="showBlocks('currency','ccontent','a2');"></div>
</div>