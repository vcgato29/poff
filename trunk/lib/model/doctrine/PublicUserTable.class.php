<?php

class PublicUserTable extends Doctrine_Table
{
	public function findOneByCredentials( $username, $password ){
		return $this->findOneByLoginAndPassword( $username, $this->cryptPassword( $password ) );
	}
	
	public function cryptPassword($p){
		//return sha1($p);
		return $p;
	}

}