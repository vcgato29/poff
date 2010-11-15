<?php

class facebookActions extends sfActions
{

	/*
	 *  login popup (javasccript based)
	 */
	public function executeIndex(sfWebRequest $request){
		$this->setLayout(false);
	}

	
	/*
	 * if user granted required permissions (email, ... )
	 * proceed to data import page
	 */
	public function executeConnect(sfWebRequest $request){
		sfFacebook::requireLogin();
	}
	
	/*
	 * find or register user according to information 
	 * signin user
	 * redirect to homepage
	 * 
	 * PS. path to this action should be configured in FACEBOOK APP interface
	 */
	public function executeImport(sfWebRequest $request){
		$users_infos = sfFacebook::getFacebookApi()->users_getInfo(array(sfFacebook::getAnyFacebookUid()),array('pic','email','email_hashes', 'name'));

		$form = new RegistrationFacebookForm(array(), array(), false);
		$bind = $this->mapToBindArray($users_infos[0]);
		
		if(!($user = Doctrine::getTable('PublicUser')->findOneByEmail($users_infos[0]['email']))){
			$form->bind($bind, array());

			if($form->isValid()){
				$user = $form->save();
			}else{
				$schema = $form->getErrorSchema();
				foreach($schema as $index => $err)
					echo $index . " " . $err;
			}
		}
		
		$this->getUser()->authAs($user);
		
		$this->redirect(
			$this->getComponent('linker', 'localizedHomepage')
		);
		
		return sfView::NONE;
	}
	
	protected function mapToBindArray($userInfo){
		$result = array();
		
		$result['login'] = $userInfo['email'];
		$result['name'] = $userInfo['name'];
		$result['email'] = $userInfo['email'];
		$result['password'] = rand(10000,100000000000);
		
		return $result;
	}
	
}