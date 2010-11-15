<?php 
/**
* @package Banklink
* @author Jani Luukkanen
*/
class SEBLink extends CBanklink
{
	public $flPrivateKey;
	public $flBankCertificate;
	public $ixSellerCode = 'monline';
	public $ixTargerAccountNumber = '10002050618003';
	public $sTargetAccountOwnerName = 'Keegi';
	public $urlServer = "https://www.seb.ee/cgi-bin/dv.sh/un3min.r";
	public $urlCallback;
	public $nOutputEncoding = 'ISO-8859-4';
	
	public function __construct() {
		$this->flPrivateKey = dirname(__FILE__) . '/seb/kaupmees_priv.pem';
		$this->flBankCertificate = dirname(__FILE__) . '/seb/eyp_pub.pem';
		$this->urlCallback = 'http://www.vifi.ee/test.php';
		//$this->nOutputEncoding = $GLOBALS['charset'];
	}
}
?>