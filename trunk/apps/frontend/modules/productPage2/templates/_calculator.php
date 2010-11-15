<form action="<?php include_component('linker', 'productActions', array('module' => 'productPage', 'action' => 'calcSubmit')) ?>" method="post">
	<?php echo $form->renderHiddenFields(true) ?>
<div class="calccontentmain">
	<div class="calcrow">
		<div class="rowleft">
			<div onmouseover="showinfo('pindala')" class="icon">
				<div id="pindala" class="rowinfo"><?php echo __('pindala abi tekst') ?></div>
			</div>
			<div class="rowname firstrow"><?php echo __('Pindala') ?></div>
		</div>
		<div class="rowcontent">
			<div class="size">
				<?php echo $form['laius']->render(array('class' => 'sizekatus')) ?>
			</div>
			<div class="valem">x</div>
			<div class="size">
				<?php echo $form['pikkus']->render(array('class' => 'sizekatus')) ?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<div class="lisainfo">(<?php echo __('katuse laius x pikkus meetrites') ?>)</div>
	</div>
	<div class="calcrow">
		<div class="rowleft">
			<div onmouseover="showinfo('height')" class="icon">
				<div id="height" class="rowinfo" style="display: none;"><?php echo __('kõrguse abi tekst') ?></div>
			</div>
			<div class="rowname"><?php echo __('Kõrgus') ?></div>
		</div>
		<div class="rowcontent">
			<?php include_partial('productPage/dropdown', array('field' => $form['kõrgus'], 'values' => $configuration->dropdownValues('k6rgus'), 'default' => __('Valik') )) ?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="calcrow">
		<div class="rowleft">
			<div onmouseover="showinfo('liigendus')" class="icon">
				<div id="liigendus" class="rowinfo"><?php echo __('liigenduse abi tekst') ?></div>
			</div>
			<div class="rowname"><?php echo __('Liigendus') ?></div>
		</div>
		<div class="rowcontent">
			<?php include_partial('productPage/dropdown', array('field' => $form['liigendus'], 'values' => $configuration->dropdownValues('liigendus'), 'default' => __('Valik') )) ?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="calcrow">
		<div class="rowleft">
			<div onmouseover="showinfo('materjal')" class="icon">
				<div id="materjal" class="rowinfo"><?php echo __('materjali abi tekst') ?></div>
			</div>
			<div class="rowname"><?php echo __('Materjal') ?></div>
		</div>
		<div class="rowcontent">
			<?php include_partial('productPage/dropdown', array('field' => $form['materjal'], 'values' => $configuration->dropdownValues('materjal'), 'default' => __('Valik') )) ?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="calcrow">
		<div class="rowleft">
			<div class="icon" onmouseover="showinfo('vana')">
				<div id="vana" class="rowinfo"><?php echo __('vana katuse eemaldamise abi tekst') ?></div>
			</div>
			<div class="rowname lastrow"><?php echo __('Vana katuse eemaldus') ?></div>
		</div>
		<div class="clear"></div>
		<div class="rbuttonsbox">
			<div class="radiobuttons">
				<?php include_partial('global/radiobutton', array(
					'field' => $form['vana katuse eemaldamine'],
					'active' => $form['vana katuse eemaldamine']->getValue() == '1',
					'defaultValue' => '1'
					))
				?>
				<div class="rbtext"><?php echo __('Jah') ?></div>
			</div>
			<div class="radiobuttons">
				<?php include_partial('global/radiobutton', array(
					'field' => $form['vana katuse eemaldamine'],
					'active' => $form['vana katuse eemaldamine']->getValue() == '0',
					'defaultValue' => '0'
					))
				?>
				<div class="rbtext"><?php echo __('Ei') ?></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="buttonbox">
		<div class="button">
			<div class="buttontext arvutabutton"><a href=""><?php echo __('Arvuta') ?></a></div>
		</div>
	</div>
	<div class="clear"></div>
</div>
</form>


<?php use_javascript('/olly/js/blockUI/script.js') ?>

<script type="text/javascript">
	$('.arvutabutton').click(function(e){
		e.preventDefault();
		
		$.blockUI({ message: '<h1><?php echo __('Oota...') ?></h1>' });

		var form = $(this).parents('form');
		var requestData = form.serialize();
		

		$.post(form.attr('action'), requestData, function(responseData){

			$('#calculatorResponse').html(responseData);
			$.unblockUI();

		});


		return false;
	});
</script>

<script type="text/javascript">
$('.dropdown .hiddendrop li').click(function(e){
	e.preventDefault();

	var dropDown = $(this).parents('.dropdown');
	dropDown.find('input').val($('a',this).attr('href'));
	dropDown.find('.droptext').html($('a',this).html());

	$(this).parents('.hiddendrop').hide();

	return false;
});
</script>
