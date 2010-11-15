<?php
/**
* @package BankLink
* @author Jani Luukkanen
*/
class EstCardLink extends CBanklink
{
	public $flPrivateKey;
	public $flBankCertificate;
	public $ixSellerCode = 'Muusika24';//'Music';
	public $ixTargerAccountNumber = '';
	public $sTargetAccountOwnerName = '';
	public $urlServer = 'https://pos.estcard.ee/webpos/servlet/iPAYServlet';//"https://pos.estcard.ee/test-pos/servlet/iPAYServlet";
	public $urlCallback = '';
	public $nOutputEncoding = 'ISO-8859-4';

	public function __construct() {
		$this->flPrivateKey = $_SERVER['DOCUMENT_ROOT'].'/../keys/estcardprivate.pem'; // muusika_pangalink_key.pem
		$this->flBankCertificate = $_SERVER['DOCUMENT_ROOT'].'/../keys/estcard_pubkey.pem'; // estcard_pubkey.pem.pem
	}

	public function UrlBankServer() {
		return $this->urlServer;
	}
	/**
	 * Function returns all the input fields required by the bank using CPayment object.
	 *
	 * @param CPayment $oPayment
	 * @return string HTML including input=hidden tags
	 */
	public function HtmlMakePaymentForm($oPayment, $nInputEncoding = "UTF-8")
	{
		if (strpos($oPayment->cPrice, ","))
		{
			$oPayment->cPrice = (float)str_replace(",", ".", $oPayment->cPrice);
		}
		$rsField = array(
			'action'    => 'gaf',
            'ver'      => "002",
            'id'     => (string)$this->ixSellerCode,
			'ecuno'        => sprintf("%012s", $oPayment->ixOrder),
            'eamount'       => sprintf("%012s", round($oPayment->cPrice*100)),
			'cur' 	 => "EEK",
			'datetime'     => (string)date("YmdHis"),
			'lang'        => "et",
       	);
       	$sMacBase =
       		$rsField['ver'] .
       		sprintf("%-10s", $rsField['id']) .
       		$rsField['ecuno'] .
       		$rsField['eamount'] .
       		$rsField['cur'] .
       		$rsField['datetime'];
       	$sSignature = sha1($sMacBase);

       	$flKey = openssl_get_privatekey(file_get_contents($this->flPrivateKey));

		if (!openssl_sign($sMacBase, $sSignature, openssl_get_privatekey(file_get_contents($this->flPrivateKey))))
		{
			trigger_error ("Unable to generate signature", E_USER_ERROR);
		}
    	$rsField['mac'] = bin2hex($sSignature);


    	//$html = "<a href='" . $this->urlServer . "?";
    	$html = '';
    	foreach ($rsField as $ixField => $fieldValue)
    	{
    		//$html .= $ixField . "=" . $fieldValue . "&amp;";
    		$html .= '<input type="hidden" name="' . $ixField . '" value="' . htmlspecialchars(iconv($nInputEncoding, $this->nOutputEncoding, $fieldValue)) . '" />' . "\n";
    	}
    	//$html .= "'>Maksa</a>";
    	return $html;
	}

	/**
	 * Function that processes the callback from the bank and returns CPayment objects with isSuccessful
	 * (and other applicable) parameters filled according to the answers from the bank.
	 *
	 * @return CPayment
	 */
	public function HandleCallback()
	{
		$rsField = array();

	    foreach ((array)$_REQUEST as $ixField => $fieldValue)
	    {
            $rsField[$ixField] = $fieldValue;
	    }

		$sSignatureBase =
			sprintf("%03s", $rsField['ver']) .
			sprintf("%-10s", $rsField['id']) .
			sprintf("%012s", $rsField['ecuno']) .
			sprintf("%06s", $rsField['receipt_no']) .
			sprintf("%012s", $rsField['eamount']) .
			sprintf("%3s", $rsField['cur']) .
			$rsField['respcode'] .
			$rsField['datetime'] .
			sprintf("%-40s", $rsField['msgdata']) .
			sprintf("%-40s", $rsField['actiontext']);

	    function hex2str($hex)
	    {
			for($i=0;$i<strlen($hex);$i+=2) $str.=chr(hexdec(substr($hex,$i,2)));
			return $str;
		}

		$mac = hex2str($rsField['mac']);
		$sSignature = sha1($sSignatureBase);
		$flKey = openssl_get_publickey(file_get_contents($this->flBankCertificate));

		if (!openssl_verify ($sSignatureBase, $mac, $flKey))
		{
			trigger_error ("Invalid signature", E_USER_ERROR);
		}
		if ($rsField['receipt_no'] == 000000) # Payment was cancelled
		{
			return new CPayment($rsField['ecuno'], $rsField['msgdata'], null, null, False);
		}
		else
		{
			return new CPayment($rsField['ecuno'], $rsField['msgdata'], $rsField['eamount']/100, $rsField['cur'], True);
		}
	}
}
?>