<?php 
/**
* @package Banklink
* @author Jani Luukkanen
*/
class HansabankLink extends CBanklink
{

	public $flPrivateKey;
	public $flBankCertificate;
	public $ixSellerCode = 'MUUSIKA';
	public $ixTargerAccountNumber = '221034662280';
	public $sTargetAccountOwnerName = 'Music Online OU';
	public $urlServer = "https://www.hanza.net/cgi-bin/hanza/pangalink.jsp";
	public $urlCallback;
	public $nOutputEncoding = 'ISO-8859-4';
	
	public function __construct() {
		
		$this->flPrivateKey = $_SERVER['DOCUMENT_ROOT'].'/../keys/muusika_pangalink_key.pem';
		$this->flBankCertificate = $_SERVER['DOCUMENT_ROOT'].'/../keys/hansa_pubkey.pem';
		$this->urlCallback = $GLOBALS['CONF']['pageUrl'].'pankCallback.php';
		//$this->nOutputEncoding = $GLOBALS['CONF']['charset'];
		
	}
}
?>