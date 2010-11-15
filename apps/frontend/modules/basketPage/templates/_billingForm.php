<div class="billing">
    <h1><?php echo strtoupper(__('Billing address'))?></h1>
	<div class="username">
		<?php 
			$field = $form['receiver'];
			$default = __('Name');
			$class = $field->hasError() ? 'userbold errinput' : 'userbold';
			$val = $field->getValue() ? $field->getValue() : $default;
			echo $field->render(array('class' => $class, 'value' => $val, 'title' => $default));
		?>
	</div>
	<div class="username">
		<?php 
			$field = $form['email'];
			$default = __('Email');
			$class = $field->hasError() ? 'user errinput' : 'user';
			$val = $field->getValue() ? $field->getValue() : $default;
			echo $field->render(array('class' => $class, 'value' => $val, 'title' => $default));
		?>
	</div>
	<div class="username">
		<?php 
			$field = $form['city'];
			$default = __('City');
			$class = $field->hasError() ? 'user errinput' : 'user';
			$val = $field->getValue() ? $field->getValue() : $default;
			echo $field->render(array('class' => $class, 'value' => $val, 'title' => $default));
		?>
	</div>
	<div class="username">
		<?php 
			$field = $form['street'];
			$default = __('Street');
			$class = $field->hasError() ? 'user errinput' : 'user';
			$val = $field->getValue() ? $field->getValue() : $default;
			echo $field->render(array('class' => $class, 'value' => $val, 'title' => $default));
		?>
	</div>
	<div class="username">
		<?php 
			$field = $form['zip'];
			$default = __('Zip');
			$class = $field->hasError() ? 'user errinput' : 'user';
			$val = $field->getValue() ? $field->getValue() : $default;
			echo $field->render(array('class' => $class, 'value' => $val, 'title' => $default));
		?>
	</div>
</div>