<?php
class CommentsForm extends BaseProductCommentForm
{
	public function configure(){

	  $this->useFields(array( 'product_id', 'name', 'message', 'ip', 'host' ));	
      $this->widgetSchema['captcha']= new sfWidgetFormInput();
      $this->widgetSchema['message']= new sfWidgetFormTextarea ();
      $this->widgetSchema['ip']= new sfWidgetFormInputHidden();
      $this->widgetSchema['host']= new sfWidgetFormInputHidden();
      $this->widgetSchema['product_id']= new sfWidgetFormInputHidden();
      
      $this->validatorSchema['captcha'] =  new sfCaptchaGDValidator(array('length' => 4));

	}

} 