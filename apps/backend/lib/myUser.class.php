<?php

class myUser extends sfGuardSecurityUser
{
	
	const PERM_DENY = 0;
	const PERM_READ = 4;
	const PERM_RW = 6;
	const PERM_RWD = 7;
	const PERM_INH = -1;
}
