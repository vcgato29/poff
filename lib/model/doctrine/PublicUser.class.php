<?php

/**
 * PublicUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class PublicUser extends BasePublicUser
{
	public function setPassword( $val ){
		$this->_set('password', $this->getTable()->cryptPassword($val));
	}

}