<div class="formbox">
    <p class="formtext"><?php echo __('Name')?>*</p>
    <div class="form">
    	<?php echo $form['name']->render(array('class' => !$form['name']->hasError() ? 'user' : 'userred'))?>
    </div>
</div>
<div class="formbox">
    <p class="formtext"><?php echo __('Address')?>*</p>
    <div class="form">
           <?php echo $form['address']->render(array('class' => !$form['address']->hasError() ? 'user' : 'userred'))?>
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
