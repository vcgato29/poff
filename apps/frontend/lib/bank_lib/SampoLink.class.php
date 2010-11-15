<?php
/**
* @package Banklink
* @author Jani LUukkanen
*/
class SampoLink extends CBanklink
{
	public $flPrivateKey;
	public $flBankCertificate;
	public $ixSellerCode = 'Muusika24';
	public $ixTargerAccountNumber = '332089620001';
	public $sTargetAccountOwnerName = 'Vificom OU';
	public $urlServer = "http://195.190.134.117/ibank/pizza/pizza";//"https://www2.sampopank.ee/ibank/pizza/pizza";
	public $urlCallback;
	public $nOutputEncoding = 'ISO-8859-4';
	
	public $sf_sellerCode = 'VIFI';

	public function __construct() {
		$this->flPrivateKey = dirname(__FILE__) . '/keys/vifi_key.pem';
		$this->flBankCertificate = dirname(__FILE__) . '/sampo/sampo_pub.pem';
		$this->urlCallback = 'http://www.vifi.ee/test.php';
		//$this->nOutputEncoding = $GLOBALS['charset'];
	}
}
?>