<?php
//

class MyAction extends sfActions{
	public function forwardSecureUnless( $var )
	{
		if( !$var )
			$this->forward('sfGuardAuth','secure');
	}
}