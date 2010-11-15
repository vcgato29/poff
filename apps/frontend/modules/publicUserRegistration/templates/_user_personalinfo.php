<h1><?php echo __('My personal information')?></h1>
<div class="clear"></div>

<?php echo $form->renderHiddenFields(true)?>
<div class="formbox">
    <p class="formtext"><?php echo __('Name')?>*</p>
    <div class="form">
    	<?php echo $form['name']->render(array('class' => !$form['name']->hasError() ? 'user' : 'userred'))?>
    </div>
</div>
<div class="formbox">
    <p class="formtext"><?php echo __('Login')?>*</p>
    <div class="form">
    	<?php echo $form['login']->render(array('class' => !$form['login']->hasError() ? 'user' : 'userred'))?>
    </div>
</div>
<div class="formbox">
    <p class="formtext"><?php echo __('Password')?>*</p>
    <div class="form">
    	<?php echo $form['password']->render(array('type' => 'password','class' => !$form['password']->hasError() ? 'user' : 'userred'))?>
    </div>
</div>
<div class="formbox">
    <p class="formtext"><?php echo __('Email')?>*</p>
    <div class="form">
           <?php echo $form['email']->render(array('class' => !$form['email']->hasError() ? 'user' : 'userred'))?>
    </div>
</div>
<div class="formbox">
    <p class="formtext"><?php echo __('Address')?></p>
    <div class="form">
           <?php echo $form['address1']->render(array('class' => !$form['address1']->hasError() ? 'user' : 'userred'))?>
    </div>
</div>
<div class="formbox">
    <p class="formtext"><?php echo __('City')?></p>
    <div class="form">
           <?php echo $form['city']->render(array('class' => !$form['city']->hasError() ? 'user' : 'userred'))?>
    </div>
</div>
<div class="formbox">
    <p class="formtext"><?php echo __('State')?></p>
    <div class="form">
           <?php echo $form['state']->render(array('class' => !$form['state']->hasError() ? 'user' : 'userred'))?>
    </div>
</div>
<div class="formbox">
    <p class="formtext"><?php echo __('Country')?></p>
    <div class="form">
           <?php echo $form['country']->render(array('class' => !$form['country']->hasError() ? 'user' : 'userred'))?>
    </div>
</div>
<div class="formbox">
    <p class="formtext"><?php echo __('Postal code')?></p>
    <div class="form">
           <?php echo $form['zip']->render(array('class' => !$form['zip']->hasError() ? 'user' : 'userred'))?>
    </div>
</div>

<div class="formbox">
    <p class="formtext"><?php echo __('Your currency')?></p>
    <div class="form">
		<div class="dropdown" title="1">
			<?php 
				$val = $form['currency']->getValue() ? $form['currency']->getValue() : $sf_user->getCurrency()->getAbbr();
			?>
		    <p><?php echo $val?></p>
			<img height="16" width="17" alt="" src="/faye/img/droparrow.png">
			
			<div class="clear"></div>
			<div class="hiddendrop">
			    <div class="hiddendropbox">
			    	<?php foreach($form->getCurrencies() as $cur):?>
					<a href="#" class="currencyselection"><?php echo $cur['abbr']?></a>
					<?php endforeach;?>
				</div>
			</div>
			<div id="selected_currency"><?php echo $form['currency']->render(array('type' => 'hidden', 'value' => $val))?></div>
		</div>
    </div>
</div>
<div class="clear"></div>

<script type="text/javascript">
$('.currencyselection').click(function(e){
	e.preventDefault();
	$('#selected_currency input').val($(this).html());
	return false;
});
</script>
