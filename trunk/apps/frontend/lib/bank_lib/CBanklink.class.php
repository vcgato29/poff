<?php
/**
* @package BankLink
* @author Jani Luukkanen
*/
abstract class CBanklink
{
	public $flPrivateKey;
	public $flBankCertificate;
	public $ixSellerCode;
	public $ixTargerAccountNumber;
	public $sTargetAccountOwnerName;
	public $urlServer;
	public $urlCallback;
	public $nOutputEncoding;

	public $sf_sellerCode = "testvpos";
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
		$rsField = array(
			'VK_SERVICE'    => '1001',
            'VK_VERSION'    => '008',
            'VK_SND_ID'     => $this->sf_sellerCode,
            'VK_STAMP'      => $oPayment->ixOrder,
            'VK_AMOUNT'     => $oPayment->cPrice,
            'VK_CURR'       => $oPayment->nCurrency,
            'VK_ACC'        => $this->ixTargerAccountNumber,
            'VK_NAME'       => $this->sTargetAccountOwnerName,
            'VK_REF'        => $this->ReferenceNumber($oPayment->ixOrder),
            'VK_MSG'        => $oPayment->txtOrderDescription,
            'VK_RETURN'     => $this->urlCallback,
            'VK_CANCEL'     => $this->urlCallback,
			'VK_LANG'		=> "EST",
			'VK_CHARSET'	=> $this->nOutputEncoding
        	);
        $flKey = openssl_pkey_get_private(file_get_contents($this->flPrivateKey));

		if (!openssl_sign($this->CheckSum($rsField, $this->nOutputEncoding, $this->nOutputEncoding), $signature, $flKey))
		{
			trigger_error ("Unable to generate signature", E_USER_ERROR);
		}

    	$rsField['VK_MAC'] = base64_encode($signature);
    	//$rsField['VK_MAC'] = $signature;
    	$html = '';
    	foreach ($rsField as $ixField => $fieldValue)
    	{
    		$html .= '<input type="hidden" name="' . $ixField . '" value="' . htmlspecialchars(iconv($nInputEncoding, $this->nOutputEncoding, $fieldValue)) . '" />' . "\n";
    	}
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
	        if (substr($ixField, 0, 3) == 'VK_')
	        {
	            $rsField[$ixField] = $fieldValue;
	        }
	    }
		$flKey = openssl_pkey_get_public(file_get_contents($this->flBankCertificate));
		
		//echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/../keys/sampopank.cer');
		//echo $this->flBankCertificate;
		if (!openssl_verify ($this->CheckSum($rsField, $this->nOutputEncoding, $this->nOutputEncoding), base64_decode($rsField['VK_MAC']), $flKey))
		{
			trigger_error ("Invalid signature", E_USER_ERROR);
		}

		if ($rsField['VK_SERVICE'] == "1901") # Payment was cancelled
		{
			return new CPayment($rsField['VK_STAMP'], $rsField['VK_MSG'], null, null, False);
		}
		else if ($rsField['VK_SERVICE'] == "1101") # Successful payment
		{
			return new CPayment($rsField['VK_STAMP'], $rsField['VK_MSG'], $rsField['VK_AMOUNT'], $rsField['VK_CURR'], True);
		}
		else
		{
			return False;
		}
	}


	protected function ReferenceNumber($ixOrder) {
		# reference number calculation using the algorithm provided by Pankade liit
		$rsMultiplier = array (7, 3, 1);
		$ixCurrentMultiplier = 0;
		$sixOrder = (string) $ixOrder;
		for ($i = strlen($sixOrder)-1; $i >= 0; $i--)
		{
			$rsProduct[$i] = substr($sixOrder, $i, 1)*$rsMultiplier[$ixCurrentMultiplier];
			if ($ixCurrentMultiplier == 2)
			{
				$ixCurrentMultiplier = 0;
			}
			else
			{
				$ixCurrentMultiplier++;
			}
		}
		$sumProduct = 0;
		foreach ($rsProduct as $product)
		{
			$sumProduct += $product;
		}
		if ($sumProduct % 10 == 0)
		{
			$ixReference = 0;
		}
		else
		{
			$ixReference = 10 - ($sumProduct % 10);
		}
		return $sixOrder.$ixReference;
	}

	protected function CheckSum($rsField, $nInputEncoding, $nOutputEncoding)
	{
		$rsKey = $this->RsKey($rsField['VK_SERVICE']);
		$checkSum = '';
		foreach ($rsKey as $ixField)
		{
			$fieldContents = iconv($nInputEncoding, $nOutputEncoding, $rsField[$ixField]);
			//$fieldContents = $rsField[$ixField];
			$checkSum .= str_pad(strlen($fieldContents), 3, '0', STR_PAD_LEFT) . $fieldContents;
		}
		return $checkSum;
	}

	protected function RsKey($ixService) {
		if ($ixService == 1001)
		{
			return array(
				'VK_SERVICE',
				'VK_VERSION',
				'VK_SND_ID',
				'VK_STAMP',
				'VK_AMOUNT',
				'VK_CURR',
				'VK_ACC',
				'VK_NAME',
				'VK_REF',
				'VK_MSG'
				);
		}
		else if ($ixService == 1101)
		{
			return array(
				'VK_SERVICE',
				'VK_VERSION',
				'VK_SND_ID',
				'VK_REC_ID',
				'VK_STAMP',
				'VK_T_NO',
				'VK_AMOUNT',
				'VK_CURR',
				'VK_REC_ACC',
				'VK_REC_NAME',
				'VK_SND_ACC',
				'VK_SND_NAME',
				'VK_REF',
				'VK_MSG',
				'VK_T_DATE'
				);
		}
		else if ($ixService == 1901)
		{
			return array(
				'VK_SERVICE',
				'VK_VERSION',
				'VK_SND_ID',
				'VK_REC_ID',
				'VK_STAMP',
				'VK_REF',
				'VK_MSG'
				);
		}
	}
	
	
	static function getBank( $type ){
		
		switch ($type){
			case 'seb':
				return new SEBLink();
				break;
			case 'nordea':
				return new NordeaLink();
				break;
			case 'sampo':
				return new SampoLink();
				break;
			default:
				throw new Exception('wrong banklink type');
				break;
		}
			
	
		
	}
}
?>